#!/bin/bash

# Script de Deploy para Produção - Seara
# Uso:  ./deploy.sh [tag]
#   ./deploy.sh          -> usa a tag "latest"
#   ./deploy.sh 1.1.33   -> usa a tag "1.1.33" (e fixa ela no compose)
#
# IMPORTANTE: este script APAGA o volume `*_prod-app-root` a cada deploy.
# Esse volume guarda o código da aplicação (/var/www) e, se não for recriado,
# o Docker continua servindo a versão antiga mesmo depois de um `pull`.
# storage/ (uploads) e mysql-data (banco) NÃO são tocados.

set -e

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

log_info()    { echo -e "${GREEN}[INFO]${NC} $1"; }
log_warning() { echo -e "${YELLOW}[WARNING]${NC} $1"; }
log_error()   { echo -e "${RED}[ERROR]${NC} $1"; }

TAG="${1:-latest}"
IMAGE_NAME="junioroliveira/seara:${TAG}"
COMPOSE_FILE="docker-compose.production.yml"
COMPOSE="docker compose -f ${COMPOSE_FILE}"

[ -f "$COMPOSE_FILE" ] || { log_error "${COMPOSE_FILE} não encontrado! Rode na pasta do projeto."; exit 1; }
[ -f ".env" ]          || { log_error "Arquivo .env não encontrado!"; exit 1; }

log_info "Iniciando deploy — imagem ${IMAGE_NAME}"

# 1. Backup do banco (best effort)
if $COMPOSE ps --status running | grep -q "seara-mysql-prod"; then
    BACKUP_DIR="backups"
    mkdir -p "$BACKUP_DIR"
    BACKUP_FILE="${BACKUP_DIR}/backup-$(date +%Y%m%d-%H%M%S).sql"
    log_info "Backup do banco em ${BACKUP_FILE}..."
    $COMPOSE exec -T mysql sh -c 'mysqldump -u root -p"${MYSQL_ROOT_PASSWORD:-root}" "${MYSQL_DATABASE}"' > "$BACKUP_FILE" 2>/dev/null \
        && log_info "Backup ok." \
        || log_warning "Backup falhou (seguindo mesmo assim)."
fi

# 2. Fixar a tag no compose quando uma versão explícita for passada
if [ "$TAG" != "latest" ]; then
    log_info "Fixando tag ${TAG} no ${COMPOSE_FILE}..."
    sed -i "s|junioroliveira/seara:[^[:space:]]*|junioroliveira/seara:${TAG}|g" "$COMPOSE_FILE"
fi

# 3. Baixar a imagem nova
log_info "Baixando ${IMAGE_NAME}..."
docker pull "$IMAGE_NAME"

# 4. Derrubar containers
log_info "Parando containers..."
$COMPOSE down

# 5. APAGAR o volume do código (recriado do zero a partir da imagem nova)
log_info "Removendo volume prod-app-root (código da aplicação)..."
docker volume ls -q | grep -E '_prod-app-root$' | xargs -r docker volume rm

# 6. Subir
log_info "Subindo containers..."
$COMPOSE up -d

# 7. Aguardar saúde
log_info "Aguardando containers ficarem saudáveis..."
for i in $(seq 1 30); do
    UNHEALTHY=$(docker ps --filter health=unhealthy --filter health=starting --format '{{.Names}}' | grep -E 'searaprod|seara-nginx-prod|seara-mysql-prod' || true)
    [ -z "$UNHEALTHY" ] && break
    sleep 3
done

# 8. Migrations
log_info "Executando migrations..."
$COMPOSE exec -T php php artisan migrate --force || log_warning "migrate falhou ou sem pendências."

# 9. Cache
log_info "Recriando cache..."
$COMPOSE exec -T php php artisan view:clear
$COMPOSE exec -T php php artisan config:cache
$COMPOSE exec -T php php artisan route:cache

# 10. Status final
echo ""
log_info "Status dos containers:"
for c in searaprod seara-nginx-prod seara-mysql-prod; do
    printf "  %-20s %s\n" "$c" "$(docker inspect "$c" --format='{{.State.Health.Status}}' 2>/dev/null || echo 'unknown')"
done
echo ""

# 11. Limpar imagens órfãs
docker image prune -f >/dev/null 2>&1 || true

log_info "Deploy concluído — ${IMAGE_NAME}"
