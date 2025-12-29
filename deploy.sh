#!/bin/bash

# Script de Deploy para Produção - Seara
# Uso: ./deploy.sh [versão]
# Exemplo: ./deploy.sh 1.1.16

set -e  # Para em caso de erro

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Função para log
log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Verificar se foi passada a versão
if [ -z "$1" ]; then
    log_error "Por favor, informe a versão da imagem"
    echo "Uso: $0 <versão>"
    echo "Exemplo: $0 1.1.16"
    exit 1
fi

VERSION=$1
IMAGE_NAME="junioroliveira/seara:${VERSION}"
COMPOSE_FILE="docker-compose.production.yml"

log_info "Iniciando deploy da versão ${VERSION}"

# Verificar se o arquivo docker-compose existe
if [ ! -f "$COMPOSE_FILE" ]; then
    log_error "Arquivo ${COMPOSE_FILE} não encontrado!"
    exit 1
fi

# Verificar se o arquivo .env existe
if [ ! -f ".env" ]; then
    log_warning "Arquivo .env não encontrado. Criando a partir do .env.example..."
    if [ -f ".env.example" ]; then
        cp .env.example .env
        log_warning "Por favor, edite o arquivo .env com as configurações de produção!"
        exit 1
    else
        log_error "Arquivo .env.example também não encontrado!"
        exit 1
    fi
fi

# Fazer backup do banco de dados
log_info "Criando backup do banco de dados..."
BACKUP_DIR="backups"
mkdir -p $BACKUP_DIR
BACKUP_FILE="${BACKUP_DIR}/backup-$(date +%Y%m%d-%H%M%S).sql"

if docker compose -f $COMPOSE_FILE ps | grep -q "seara-mysql-prod"; then
    docker compose -f $COMPOSE_FILE exec -T mysql mysqldump -u root -proot seara > $BACKUP_FILE 2>/dev/null || {
        log_warning "Não foi possível criar backup do banco (container pode não estar rodando)"
    }
    if [ -f "$BACKUP_FILE" ]; then
        log_info "Backup criado em: ${BACKUP_FILE}"
    fi
fi

# Atualizar versão no docker-compose.yml
log_info "Atualizando versão no ${COMPOSE_FILE}..."
sed -i "s|junioroliveira/seara:.*|junioroliveira/seara:${VERSION}|g" $COMPOSE_FILE

# Pull da nova imagem
log_info "Baixando imagem ${IMAGE_NAME}..."
docker pull $IMAGE_NAME

# Parar containers
log_info "Parando containers..."
docker compose -f $COMPOSE_FILE down

# Subir novos containers
log_info "Iniciando novos containers..."
docker compose -f $COMPOSE_FILE up -d

# Aguardar containers ficarem saudáveis
log_info "Aguardando containers ficarem saudáveis..."
sleep 10

# Verificar status
log_info "Verificando status dos containers..."
docker compose -f $COMPOSE_FILE ps

# Executar migrações
log_info "Executando migrações..."
docker compose -f $COMPOSE_FILE exec -T php php artisan migrate --force || {
    log_warning "Migrações falharam ou não há migrações pendentes"
}

# Limpar e recriar cache
log_info "Limpando e recriando cache..."
docker compose -f $COMPOSE_FILE exec -T php php artisan cache:clear
docker compose -f $COMPOSE_FILE exec -T php php artisan config:cache
docker compose -f $COMPOSE_FILE exec -T php php artisan route:cache

# Corrigir permissões
log_info "Corrigindo permissões..."
docker compose -f $COMPOSE_FILE exec -T php chmod -R 775 storage bootstrap/cache || {
    log_warning "Não foi possível ajustar permissões via chmod"
}

# Verificar saúde dos containers
log_info "Verificando saúde dos containers..."
sleep 5

PHP_HEALTH=$(docker inspect seara-php-prod --format='{{.State.Health.Status}}' 2>/dev/null || echo "unknown")
NGINX_HEALTH=$(docker inspect seara-nginx-prod --format='{{.State.Health.Status}}' 2>/dev/null || echo "unknown")
MYSQL_HEALTH=$(docker inspect seara-mysql-prod --format='{{.State.Health.Status}}' 2>/dev/null || echo "unknown")

echo ""
echo "Status dos containers:"
echo "  PHP:   ${PHP_HEALTH}"
echo "  Nginx: ${NGINX_HEALTH}"
echo "  MySQL: ${MYSQL_HEALTH}"
echo ""

# Limpar imagens antigas
log_info "Limpando imagens antigas..."
docker image prune -f

log_info "Deploy da versão ${VERSION} concluído com sucesso!"
log_info "Acesse a aplicação em: http://localhost"

# Mostrar logs
read -p "Deseja ver os logs? (s/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Ss]$ ]]; then
    docker compose -f $COMPOSE_FILE logs -f
fi
