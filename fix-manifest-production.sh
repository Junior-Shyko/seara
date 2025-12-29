#!/bin/bash
set -e

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${GREEN}=== Correção do rev-manifest.json em Produção ===${NC}"
echo ""

echo -e "${YELLOW}Este script deve ser executado NO SERVIDOR DE PRODUÇÃO!${NC}"
read -p "Você está no servidor de produção? (s/N): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Ss]$ ]]; then
    echo "Execute este script no servidor de produção!"
    exit 1
fi

echo -e "${YELLOW}[1/5] Parando containers...${NC}"
docker compose -f docker-compose.production.yml down
echo -e "${GREEN}✓ Containers parados${NC}"
echo ""

echo -e "${YELLOW}[2/5] Removendo volume de assets para forçar atualização...${NC}"
docker volume rm prodseara_public_assets
echo -e "${GREEN}✓ Volume removido${NC}"
echo ""

echo -e "${YELLOW}[3/5] Subindo containers (entrypoint copiará assets novamente)...${NC}"
docker compose -f docker-compose.production.yml up -d
echo -e "${GREEN}✓ Containers iniciados${NC}"
echo ""

echo "Aguardando 10 segundos para containers iniciarem..."
sleep 10

echo -e "${YELLOW}[4/5] Verificando se build/ foi copiado...${NC}"
if docker exec searaprodphp ls /var/www/public/build/rev-manifest.json >/dev/null 2>&1; then
    echo -e "${GREEN}✓ rev-manifest.json encontrado!${NC}"
else
    echo -e "${RED}✗ rev-manifest.json NÃO encontrado!${NC}"
    echo ""
    echo "Tentando copiar manualmente..."
    docker exec searaprodphp mkdir -p /var/www/public/build
    docker exec searaprodphp cp /tmp/public-assets/build/rev-manifest.json /var/www/public/build/
    docker exec searaprodphp chown www-data:www-data /var/www/public/build/rev-manifest.json
    echo -e "${GREEN}✓ Copiado manualmente${NC}"
fi
echo ""

echo -e "${YELLOW}[5/5] Verificação final...${NC}"
echo ""
echo "1. Status dos containers:"
docker compose -f docker-compose.production.yml ps
echo ""

echo "2. Conteúdo do diretório build/:"
docker exec searaprodphp ls -lh /var/www/public/build/
echo ""

echo "3. Checksum do manifest:"
docker exec searaprodphp md5sum /var/www/public/build/rev-manifest.json
echo ""

echo -e "${GREEN}=== Correção concluída! ===${NC}"
echo ""
echo "Agora teste no browser:"
echo "1. Acesse https://app.searacontabilidade.com.br"
echo "2. Vá para a página de Receivables"
echo "3. Abra DevTools (F12) → Network"
echo "4. Recarregue com Ctrl+Shift+R"
echo "5. Verifique se /build/js/financing/receivable.min.js carrega"
