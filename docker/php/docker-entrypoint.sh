#!/bin/bash
set -e

echo "=== Seara Production Entrypoint ==="

# Diretório temporário onde os assets originais estão (dentro da imagem)
ASSETS_SOURCE="/tmp/public-assets"
PUBLIC_DIR="/var/www/public"

# Se é a primeira vez ou se precisa atualizar os assets
if [ ! -f "$PUBLIC_DIR/.assets-initialized" ] || [ "${FORCE_ASSETS_UPDATE:-false}" = "true" ]; then
    echo "Inicializando/Atualizando assets públicos..."

    # Copiar arquivos estáticos da imagem para o volume
    # Uploads agora ficam em storage/app/public/images (volume separado)
    if [ -d "$ASSETS_SOURCE" ]; then
        echo "Copiando assets de $ASSETS_SOURCE para $PUBLIC_DIR..."

        # Copiar todos os assets
        cp -a "$ASSETS_SOURCE/." "$PUBLIC_DIR/"

        # Garantir que o link simbólico do storage existe
        STORAGE_PUBLIC="/var/www/storage/app/public"
        if [ ! -L "$PUBLIC_DIR/storage" ]; then
            echo "Criando link simbólico para storage..."
            ln -sf "$STORAGE_PUBLIC" "$PUBLIC_DIR/storage"
        fi

        # Garantir que o diretório de uploads existe no storage
        mkdir -p "$STORAGE_PUBLIC/images"
        chown -R www-data:www-data "$STORAGE_PUBLIC"

        # Marcar como inicializado
        date > "$PUBLIC_DIR/.assets-initialized"
        echo "Assets atualizados com sucesso!"
    else
        echo "AVISO: Diretório de assets source não encontrado em $ASSETS_SOURCE"
        echo "Os assets não foram atualizados."
    fi
else
    echo "Assets já inicializados. Para forçar atualização, defina FORCE_ASSETS_UPDATE=true"
fi

# Garantir permissões corretas
echo "Ajustando permissões..."
chown -R www-data:www-data "$PUBLIC_DIR"
chmod -R 755 "$PUBLIC_DIR"

echo "=== Iniciando PHP-FPM ==="

# Executar o comando original do container (php-fpm)
exec docker-php-entrypoint "$@"
