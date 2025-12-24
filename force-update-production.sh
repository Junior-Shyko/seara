#!/bin/bash
set -e

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== Atualização Forçada de Assets em Produção ===${NC}"
echo ""

# Verificar se está no servidor de produção ou local
read -p "Você está executando no SERVIDOR DE PRODUÇÃO (droplet)? (s/N): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Ss]$ ]]; then
    echo -e "${RED}Este script deve ser executado NO SERVIDOR DE PRODUÇÃO!${NC}"
    echo "Para fazer o build e push local, use: ./build-production.sh"
    exit 1
fi

# Verificar versão a atualizar
VERSION=${1:-"1.1.14"}
echo -e "${BLUE}Versão a ser atualizada: ${VERSION}${NC}"
echo ""

# Passo 1: Parar containers
echo -e "${YELLOW}[1/6] Parando containers...${NC}"
docker compose -f docker-compose.production.yml down
echo -e "${GREEN}✓ Containers parados${NC}"
echo ""

# Passo 2: Remover volume de assets para forçar atualização
echo -e "${YELLOW}[2/6] Removendo volume de assets antigos...${NC}"
docker volume rm prodseara_public_assets 2>/dev/null || echo "Volume já estava removido"
echo -e "${GREEN}✓ Volume de assets removido${NC}"
echo ""

# Passo 3: Remover imagem local antiga para evitar cache
echo -e "${YELLOW}[3/6] Removendo imagem local antiga...${NC}"
docker rmi junioroliveira/seara:${VERSION} 2>/dev/null || echo "Imagem já estava removida"
docker rmi junioroliveira/seara:latest 2>/dev/null || echo "Imagem latest já estava removida"
echo -e "${GREEN}✓ Cache de imagem limpo${NC}"
echo ""

# Passo 4: Pull forçado da nova imagem
echo -e "${YELLOW}[4/6] Baixando nova imagem do Docker Hub...${NC}"
docker pull junioroliveira/seara:${VERSION}
echo -e "${GREEN}✓ Nova imagem baixada${NC}"
echo ""

# Passo 5: Verificar se os assets estão corretos na imagem
echo -e "${YELLOW}[5/6] Verificando assets na imagem...${NC}"
HASH_IN_IMAGE=$(docker run --rm junioroliveira/seara:${VERSION} md5sum /var/www/public/js/financing/receivable.min.js | awk '{print $1}')
echo "Hash do receivable.min.js na imagem: ${HASH_IN_IMAGE}"

# Verificar se o arquivo não está vazio
if [ -z "$HASH_IN_IMAGE" ]; then
    echo -e "${RED}✗ ERRO: Não foi possível verificar os assets na imagem!${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Assets encontrados na imagem${NC}"
echo ""

# Passo 6: Subir containers com FORCE_ASSETS_UPDATE
echo -e "${YELLOW}[6/6] Iniciando containers com atualização forçada de assets...${NC}"
docker compose -f docker-compose.production.yml up -d
echo -e "${GREEN}✓ Containers iniciados${NC}"
echo ""

# Aguardar containers iniciarem
echo "Aguardando containers iniciarem (10 segundos)..."
sleep 10

# Verificar se os assets foram copiados corretamente
echo ""
echo -e "${BLUE}=== Verificação Final ===${NC}"
echo ""
echo "1. Verificando assets no container PHP:"
docker exec searaprodphp md5sum /var/www/public/js/financing/receivable.min.js || echo -e "${RED}✗ Erro ao verificar assets no PHP${NC}"
echo ""
echo "2. Verificando assets no container Nginx:"
docker exec searaprodnginx md5sum /var/www/public/js/financing/receivable.min.js || echo -e "${RED}✗ Erro ao verificar assets no Nginx${NC}"
echo ""
echo "3. Status dos containers:"
docker compose -f docker-compose.production.yml ps
echo ""

# Verificar logs do entrypoint
echo -e "${BLUE}=== Logs do PHP (inicialização) ===${NC}"
docker compose -f docker-compose.production.yml logs php | grep -A 5 "Seara Production Entrypoint" || echo "Entrypoint não executado corretamente"
echo ""

echo -e "${GREEN}=== Atualização concluída! ===${NC}"
echo ""
echo "Próximos passos:"
echo "1. Acesse a aplicação no browser"
echo "2. Abra o DevTools (F12) → Network"
echo "3. Recarregue a página com Ctrl+Shift+R (hard refresh)"
echo "4. Verifique se receivable.min.js está sendo carregado"
echo "5. Verifique se o erro de jQuery desapareceu"
echo ""
echo "Se ainda houver problemas, execute:"
echo "  docker compose -f docker-compose.production.yml logs php"
echo "  docker compose -f docker-compose.production.yml logs nginx"
