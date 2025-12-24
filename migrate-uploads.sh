#!/bin/bash
set -e

echo "=== Migrando uploads do volume antigo para o novo volume ==="

# Verificar se o volume antigo existe
if ! docker volume ls | grep -q "prodseara_public_files"; then
    echo "Volume antigo 'prodseara_public_files' não encontrado. Nada a migrar."
    exit 0
fi

# Criar o novo volume se não existir
docker volume create prodseara_uploads 2>/dev/null || true

echo "Copiando uploads de public/img/images do volume antigo para o novo volume..."

# Usar um container temporário para copiar os arquivos
docker run --rm \
    -v prodseara_public_files:/source:ro \
    -v prodseara_uploads:/target \
    alpine sh -c "
        if [ -d /source/img/images ]; then
            cp -av /source/img/images/* /target/ 2>/dev/null || true
            echo 'Uploads migrados com sucesso!'
            echo 'Total de arquivos migrados:'
            ls -1 /target | wc -l
        else
            echo 'Diretório /source/img/images não encontrado no volume antigo.'
        fi
    "

echo ""
echo "=== Migração concluída ==="
echo ""
echo "Próximos passos:"
echo "1. Compilar os assets: docker compose exec node npm run prod"
echo "2. Fazer o build da nova imagem Docker"
echo "3. Parar os containers: docker compose -f docker-compose.production.yml down"
echo "4. Subir os containers: docker compose -f docker-compose.production.yml up -d"
echo "5. (Opcional) Remover o volume antigo: docker volume rm prodseara_public_files"
