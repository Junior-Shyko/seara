#!/bin/bash
set -e

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Versão da imagem (pode ser passada como argumento)
VERSION=${1:-"1.1.14"}
IMAGE_NAME="junioroliveira/seara"

echo -e "${GREEN}=== Build de Produção - Seara ${VERSION} ===${NC}"
echo ""

# Passo 1: Compilar assets
echo -e "${YELLOW}[1/4] Compilando assets...${NC}"
if docker compose ps | grep -q "node"; then
    echo "Usando container node em execução..."
    docker compose run --rm node npm run prod
else
    echo "Iniciando container node temporário..."
    docker compose run --rm node npm run prod
fi
echo -e "${GREEN}✓ Assets compilados com sucesso!${NC}"
echo ""

# Passo 2: Verificar se os assets foram compilados
echo -e "${YELLOW}[2/4] Verificando assets compilados...${NC}"
if [ ! -f "public/js/financing/receivable.min.js" ]; then
    echo -e "${RED}✗ Erro: Assets não foram compilados corretamente!${NC}"
    echo "Execute primeiro: docker compose exec node npm run prod"
    exit 1
fi

# Verificar se os assets são recentes (compilados nas últimas 24 horas)
ASSET_AGE=$(find public/js/financing/receivable.min.js -mmin +1440 2>/dev/null | wc -l)
if [ "$ASSET_AGE" -eq "1" ]; then
    echo -e "${YELLOW}⚠ AVISO: Assets compilados há mais de 24 horas!${NC}"
    echo "Timestamp do arquivo compilado:"
    ls -lh public/js/financing/receivable.min.js
    echo ""
    read -p "Os assets estão atualizados? Continuar? (s/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Ss]$ ]]; then
        echo "Build cancelado. Execute: docker compose exec node npm run prod"
        exit 1
    fi
fi

# Mostrar hash MD5 para rastreabilidade
HASH=$(md5sum public/js/financing/receivable.min.js | awk '{print $1}')
echo "Hash MD5 do receivable.min.js: ${HASH}"
echo -e "${GREEN}✓ Assets verificados!${NC}"
echo ""

# Passo 3: Build da imagem Docker
echo -e "${YELLOW}[3/4] Criando imagem Docker ${IMAGE_NAME}:${VERSION}...${NC}"
docker build \
    --no-cache \
    -t ${IMAGE_NAME}:${VERSION} \
    -t ${IMAGE_NAME}:latest \
    -f docker/php/Dockerfile .
echo -e "${GREEN}✓ Imagem criada com sucesso!${NC}"
echo ""

# Passo 4: Perguntar se deseja fazer push
echo -e "${YELLOW}[4/4] Push para Docker Hub${NC}"
read -p "Deseja fazer push da imagem para o Docker Hub? (s/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Ss]$ ]]; then
    echo "Fazendo push de ${IMAGE_NAME}:${VERSION}..."
    docker push ${IMAGE_NAME}:${VERSION}
    docker push ${IMAGE_NAME}:latest
    echo -e "${GREEN}✓ Push concluído!${NC}"
else
    echo "Push cancelado."
fi

echo ""
echo -e "${GREEN}=== Build concluído com sucesso! ===${NC}"
echo ""
echo "Imagem criada: ${IMAGE_NAME}:${VERSION}"
echo ""
echo "Próximos passos:"
echo "1. (Primeira vez apenas) Migrar uploads: ./migrate-uploads.sh"
echo "2. Atualizar a versão no docker-compose.production.yml para ${VERSION}"
echo "3. (Se fez push) Deploy: ./deploy-production.sh"
echo "   (Se local) docker compose -f docker-compose.production.yml up -d --build"
