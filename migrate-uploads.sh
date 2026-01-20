#!/bin/bash
set -e

echo "=== Migrando uploads para storage/app/public/images ==="

# Verificar se o volume antigo existe
if ! docker volume ls | grep -q "prodseara_public_files"; then
    echo "Volume antigo 'prodseara_public_files' não encontrado."
    echo "Verificando se há uploads em prodseara_uploads..."

    if ! docker volume ls | grep -q "prodseara_uploads"; then
        echo "Nenhum volume de uploads encontrado. Nada a migrar."
        exit 0
    fi

    SOURCE_VOLUME="prodseara_uploads"
    SOURCE_PATH="/source"
else
    SOURCE_VOLUME="prodseara_public_files"
    SOURCE_PATH="/source/img/images"
fi

# Criar o novo volume para storage se não existir
docker volume create prodseara_storage_uploads 2>/dev/null || true

echo "Copiando uploads de $SOURCE_VOLUME para prodseara_storage_uploads..."

# Usar um container temporário para copiar os arquivos
docker run --rm \
    -v ${SOURCE_VOLUME}:/source:ro \
    -v prodseara_storage_uploads:/target \
    alpine sh -c "
        mkdir -p /target/images
        if [ -d ${SOURCE_PATH} ]; then
            cp -av ${SOURCE_PATH}/* /target/images/ 2>/dev/null || true
            echo 'Uploads migrados com sucesso!'
            echo 'Total de arquivos migrados:'
            ls -1 /target/images 2>/dev/null | wc -l
        else
            echo 'Diretório ${SOURCE_PATH} não encontrado no volume.'
        fi
    "

echo ""
echo "=== Migração concluída ==="
echo ""
echo "Próximos passos:"
echo "1. Atualizar docker-compose-prod.yml para usar o novo volume:"
echo "   volumes:"
echo "     - storage_uploads:/var/www/storage/app/public"
echo ""
echo "2. Criar o link simbólico no container:"
echo "   docker exec searaprodphp php artisan storage:link"
echo ""
echo "3. (Opcional) Remover volumes antigos após verificar:"
echo "   docker volume rm prodseara_public_files"
echo "   docker volume rm prodseara_uploads"
