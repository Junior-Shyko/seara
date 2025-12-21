#!/bin/bash

# Script para build da imagem de produção com assets compilados
# Uso: ./bin/build-production.sh [versão]

set -e

VERSION=${1:-latest}
IMAGE_NAME="junioroliveira/seara:${VERSION}"

echo "🚀 Iniciando build da imagem de produção..."
echo "📦 Imagem: ${IMAGE_NAME}"
echo ""

# Verificar se o Dockerfile de produção existe
if [ ! -f "docker/php/Dockerfile.production" ]; then
    echo "❌ Erro: docker/php/Dockerfile.production não encontrado!"
    exit 1
fi

# Build da imagem com multi-stage
echo "🔨 Compilando assets e criando imagem..."
docker build --no-cache \
    -t "${IMAGE_NAME}" \
    -f docker/php/Dockerfile.production \
    .

echo ""
echo "✅ Build concluído com sucesso!"
echo "📦 Imagem criada: ${IMAGE_NAME}"
echo ""
echo "Para fazer push para o Docker Hub:"
echo "  docker push ${IMAGE_NAME}"
