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
    # Preservando o diretório de uploads (img/images)
    if [ -d "$ASSETS_SOURCE" ]; then
        echo "Copiando assets de $ASSETS_SOURCE para $PUBLIC_DIR..."

        # Criar diretório temporário para uploads se necessário
        TEMP_UPLOADS=""
        if [ -d "$PUBLIC_DIR/img/images" ]; then
            TEMP_UPLOADS="/tmp/uploads-backup"
            echo "Fazendo backup temporário de uploads..."
            mkdir -p "$TEMP_UPLOADS"
            cp -a "$PUBLIC_DIR/img/images/." "$TEMP_UPLOADS/" 2>/dev/null || true
        fi

        # Copiar todos os assets
        cp -a "$ASSETS_SOURCE/." "$PUBLIC_DIR/"

        # Restaurar uploads se havia backup
        if [ -n "$TEMP_UPLOADS" ] && [ -d "$TEMP_UPLOADS" ]; then
            echo "Restaurando uploads..."
            mkdir -p "$PUBLIC_DIR/img/images"
            cp -a "$TEMP_UPLOADS/." "$PUBLIC_DIR/img/images/" 2>/dev/null || true
            rm -rf "$TEMP_UPLOADS"
        fi

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
