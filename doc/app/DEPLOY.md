# Guia de Deploy - Seara

Este documento descreve o processo completo de deploy de alterações em produção.

## Pré-requisitos

- Docker e Docker Compose instalados localmente e no servidor
- Acesso ao Docker Hub (conta junioroliveira)
- Acesso SSH ao droplet de produção

## Processo Completo de Deploy

### 1. Desenvolvimento Local

```bash
# 1.1. Fazer alterações nos arquivos fonte
# Exemplo: editar resources/assets/js/financing/receivable.js

# 1.2. Compilar assets
docker-compose exec node gulp

# 1.3. Verificar se os assets foram compilados
ls -lh public/js/financing/receivable.min.js
# Deve mostrar timestamp recente

# 1.4. Testar localmente
# Acesse http://localhost:8080 e teste as alterações
```

### 2. Build e Push da Imagem Docker

```bash
# 2.1. Definir nova versão (incrementar de 1.1.14 para 1.1.15, por exemplo)
VERSION="1.1.15"

# 2.2. Executar build de produção
./build-production.sh $VERSION

# 2.3. IMPORTANTE: Fazer login no Docker Hub quando solicitado
# e confirmar o PUSH quando o script perguntar (responder "s")

# 2.4. Verificar se o push foi concluído
# Deve mostrar: "✓ Push concluído!"
```

### 3. Atualizar docker-compose-prod.yml

```bash
# 3.1. Editar docker-compose-prod.yml
# Alterar a linha 29:
#   image: junioroliveira/seara:1.1.15  # <- nova versão

# 3.2. Commit e push das alterações (opcional)
git add docker-compose-prod.yml
git commit -m "Bump version to $VERSION"
git push
```

### 4. Deploy no Servidor de Produção

```bash
# 4.1. Conectar ao servidor
ssh user@seu-droplet-ip

# 4.2. Ir para o diretório do projeto
cd /caminho/para/seara

# 4.3. Puxar alterações do git (se fez commit)
git pull

# 4.4. OU editar manualmente o docker-compose-prod.yml
# nano docker-compose-prod.yml
# Alterar a versão da imagem para 1.1.15

# 4.5. Executar atualização forçada
./force-update-production.sh 1.1.15
```

### 5. Verificação Pós-Deploy

```bash
# 5.1. Verificar status dos containers
docker-compose -f docker-compose-prod.yml ps
# Todos devem estar "Up" e "healthy"

# 5.2. Verificar logs
docker-compose -f docker-compose-prod.yml logs php | tail -20
# Deve mostrar "Assets atualizados com sucesso!"

# 5.3. Verificar hash dos assets
docker exec searaprodphp md5sum /var/www/public/js/financing/receivable.min.js
docker exec searaprodnginx md5sum /var/www/public/js/financing/receivable.min.js
# Os hashes devem ser IDÊNTICOS

# 5.4. Testar no browser
# - Acessar a aplicação
# - Abrir DevTools (F12) → Network
# - Fazer hard refresh: Ctrl+Shift+R
# - Verificar se receivable.min.js está sendo carregado (status 200)
# - Verificar se não há erros no Console
```

## Troubleshooting

### Problema: Assets não atualizam no droplet

**Sintoma**: `receivable.min.js` não tem as alterações, mesmo após deploy

**Solução**:
```bash
# No servidor de produção:
./force-update-production.sh 1.1.15

# Se ainda não funcionar, verificar:
docker-compose -f docker-compose-prod.yml logs php
docker-compose -f docker-compose-prod.yml logs nginx
```

### Problema: Erro "jQuery tooltip is not a function"

**Sintoma**: Assets não estão sendo carregados

**Causa**: Assets compilados não estão no volume compartilhado

**Solução**:
```bash
# Remover volume e reiniciar:
docker-compose -f docker-compose-prod.yml down
docker volume rm prodseara_public_assets
docker-compose -f docker-compose-prod.yml up -d
```

### Problema: Imagem não foi atualizada no Docker Hub

**Sintoma**: Build local funciona, mas droplet tem versão antiga

**Causa**: Esqueceu de fazer push da imagem

**Solução**:
```bash
# No ambiente local:
docker push junioroliveira/seara:1.1.15
docker push junioroliveira/seara:latest

# No servidor:
./force-update-production.sh 1.1.15
```

### Problema: Container nginx está unhealthy

**Sintoma**: `docker-compose ps` mostra nginx como unhealthy

**Causa**: Nginx não consegue acessar o PHP ou os assets

**Solução**:
```bash
# Verificar logs:
docker-compose -f docker-compose-prod.yml logs nginx

# Verificar se o volume está montado:
docker exec searaprodnginx ls -lh /var/www/public/js

# Reiniciar containers:
docker-compose -f docker-compose-prod.yml restart
```

## Checklist Rápido

Antes de cada deploy, verifique:

- [ ] Assets foram compilados localmente (`gulp` executado)
- [ ] Build da imagem foi concluído com sucesso
- [ ] Push para Docker Hub foi concluído (não cancelado)
- [ ] Versão no `docker-compose-prod.yml` foi atualizada
- [ ] Script `force-update-production.sh` foi executado no servidor
- [ ] Containers estão healthy
- [ ] Assets estão acessíveis no browser (F12 → Network)

## Scripts Disponíveis

| Script | Onde executar | Descrição |
|--------|---------------|-----------|
| `build-production.sh` | Local | Compila assets e cria imagem Docker |
| `force-update-production.sh` | Servidor | Força atualização completa em produção |
| `deploy-production.sh` | Servidor | Deploy normal (sem forçar atualização) |
| `migrate-uploads.sh` | Servidor | Migra uploads de volume antigo (primeira vez apenas) |

## Notas Importantes

1. **SEMPRE** compile os assets com `gulp` antes de fazer build da imagem
2. **SEMPRE** faça push da imagem para o Docker Hub
3. **SEMPRE** atualize a versão no `docker-compose-prod.yml`
4. Use `force-update-production.sh` quando tiver problemas com assets
5. O volume `prodseara_public_assets` é recriado automaticamente pelo entrypoint
6. O volume `prodseara_uploads` preserva os arquivos enviados pelos usuários
