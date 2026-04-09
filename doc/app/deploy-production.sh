#!/bin/bash
set -e

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== Deploy de Produção - Seara ===${NC}"
echo ""

# Verificar se o docker-compose.production.yml existe
if [ ! -f "docker-compose.production.yml" ]; then
    echo -e "${RED}Erro: docker-compose.production.yml não encontrado${NC}"
    exit 1
fi

# Passo 1: Parar containers
echo -e "${YELLOW}[1/4] Parando containers de produção...${NC}"
docker compose -f docker-compose.production.yml down
echo -e "${GREEN}✓ Containers parados${NC}"
echo ""

# Passo 2: Limpar volume de assets antigos para forçar atualização
echo -e "${YELLOW}[2/4] Limpando cache de assets...${NC}"
read -p "Deseja limpar o volume de assets para forçar atualização completa? (s/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Ss]$ ]]; then
    docker volume rm prodseara_public_assets 2>/dev/null || true
    echo -e "${GREEN}✓ Volume de assets removido${NC}"
else
    echo "Volume de assets mantido (assets serão atualizados pelo entrypoint)"
fi
echo ""

# Passo 3: Pull da nova imagem
echo -e "${YELLOW}[3/4] Baixando nova imagem...${NC}"
docker compose -f docker-compose.production.yml pull php
echo -e "${GREEN}✓ Imagem atualizada${NC}"
echo ""

# Passo 4: Subir containers
echo -e "${YELLOW}[4/4] Iniciando containers...${NC}"
docker compose -f docker-compose.production.yml up -d
echo -e "${GREEN}✓ Containers iniciados${NC}"
echo ""

# Aguardar um pouco para os containers iniciarem
echo "Aguardando containers iniciarem..."
sleep 5

# Verificar status
echo ""
echo -e "${BLUE}=== Status dos Containers ===${NC}"
docker compose -f docker-compose.production.yml ps
echo ""

# Verificar logs do PHP para confirmar inicialização dos assets
echo -e "${BLUE}=== Logs do PHP (inicialização de assets) ===${NC}"
docker compose -f docker-compose.production.yml logs php | tail -20
echo ""

# Verificar se os assets estão acessíveis
echo -e "${BLUE}=== Verificando assets ===${NC}"
echo "Tentando acessar gentelella.min.js..."
docker exec searaprodphp ls -lh /var/www/public/js/gentelella.min.js 2>/dev/null && \
    echo -e "${GREEN}✓ Assets encontrados no container PHP${NC}" || \
    echo -e "${RED}✗ Assets NÃO encontrados no container PHP${NC}"

docker exec searaprodnginx ls -lh /var/www/public/js/gentelella.min.js 2>/dev/null && \
    echo -e "${GREEN}✓ Assets encontrados no container Nginx${NC}" || \
    echo -e "${RED}✗ Assets NÃO encontrados no container Nginx${NC}"

echo ""
echo -e "${GREEN}=== Deploy concluído! ===${NC}"
echo ""
echo "Para verificar se tudo está funcionando:"
echo "  - Acesse a aplicação no browser"
echo "  - Verifique o console do browser (F12)"
echo "  - Verifique logs: docker compose -f docker-compose.production.yml logs -f"
