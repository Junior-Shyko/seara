#!/bin/bash
set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${GREEN}=== Limpando Cache do Laravel em Produção ===${NC}"
echo ""

echo -e "${YELLOW}Limpando cache de views (Blade)...${NC}"
docker exec searaprodphp php artisan view:clear
echo -e "${GREEN}✓ Cache de views limpo${NC}"
echo ""

echo -e "${YELLOW}Limpando cache da aplicação...${NC}"
docker exec searaprodphp php artisan cache:clear
echo -e "${GREEN}✓ Cache da aplicação limpo${NC}"
echo ""

echo -e "${YELLOW}Limpando cache de configuração...${NC}"
docker exec searaprodphp php artisan config:clear
echo -e "${GREEN}✓ Cache de configuração limpo${NC}"
echo ""

echo -e "${YELLOW}Limpando cache de rotas...${NC}"
docker exec searaprodphp php artisan route:clear
echo -e "${GREEN}✓ Cache de rotas limpo${NC}"
echo ""

echo -e "${GREEN}=== Cache limpo com sucesso! ===${NC}"
echo ""
echo "Agora teste no browser:"
echo "1. Recarregue a página de Receivables"
echo "2. Faça Ctrl+Shift+R (hard refresh)"
echo "3. Verifique o código fonte (Ctrl+U)"
echo "4. Deve mostrar: src=\"/js/financing/receivable.min.js\""
echo "   (sem o /build/)"
