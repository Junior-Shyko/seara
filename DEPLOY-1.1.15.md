# Deploy da Versão 1.1.15 - Correção do rev-manifest.json

## O que foi corrigido nesta versão

✅ **Incluído** `public/build/rev-manifest.json` na imagem Docker
✅ **Corrigido** erro "File not defined in asset manifest"
✅ **Assets compilados** com alterações do receivable.js

## Checksums para validação

```bash
# receivable.min.js
MD5: 4978dbb198a4482aa75cd8239dcfce03

# rev-manifest.json
MD5: 207f01e9fe79e444eb6c6806a2b6a01b
```

## Deploy no Servidor (Droplet)

### Passo 1: Conectar ao servidor

```bash
ssh user@seu-droplet-ip
cd /caminho/para/seara
```

### Passo 2: Atualizar docker-compose-prod.yml

```bash
# Editar o arquivo
nano docker-compose-prod.yml

# Alterar linha 29:
# DE:  image: junioroliveira/seara:1.1.14
# PARA: image: junioroliveira/seara:1.1.15

# Salvar: Ctrl+O, Enter, Ctrl+X
```

### Passo 3: Executar atualização forçada

```bash
./force-update-production.sh 1.1.15
```

OU manualmente:

```bash
# Parar containers
docker-compose -f docker-compose-prod.yml down

# Remover volumes antigos
docker volume rm prodseara_public_assets

# Remover imagem antiga (limpar cache)
docker rmi junioroliveira/seara:1.1.15 2>/dev/null || true

# Pull da nova imagem
docker pull junioroliveira/seara:1.1.15

# Subir containers
docker-compose -f docker-compose-prod.yml up -d
```

### Passo 4: Verificar se funcionou

```bash
# 1. Verificar status dos containers
docker-compose -f docker-compose-prod.yml ps
# Todos devem estar "Up" e "healthy"

# 2. Verificar se o rev-manifest.json está no container
docker exec searaprodphp ls -lh /var/www/public/build/rev-manifest.json

# Deve mostrar:
# -rw------- 1 www-data www-data 1.6K Dec 21 17:56 rev-manifest.json

# 3. Verificar checksum
docker exec searaprodphp md5sum /var/www/public/build/rev-manifest.json

# Deve retornar: 207f01e9fe79e444eb6c6806a2b6a01b

# 4. Verificar receivable.min.js
docker exec searaprodphp md5sum /var/www/public/js/financing/receivable.min.js

# Deve retornar: 4978dbb198a4482aa75cd8239dcfce03

# 5. Verificar se nginx também tem os arquivos
docker exec searaprodnginx ls -lh /var/www/public/build/rev-manifest.json
docker exec searaprodnginx ls -lh /var/www/public/js/financing/receivable.min.js
```

### Passo 5: Testar no browser

1. Acesse https://app.searacontabilidade.com.br
2. Vá para a página de Receivables
3. Abra DevTools (F12) → Network
4. Recarregue a página com **Ctrl+Shift+R** (hard refresh)
5. Verificar:
   - ✅ `/build/js/financing/receivable.min.js` deve carregar com **status 200**
   - ✅ Não deve haver erro "not defined in asset manifest"
   - ✅ Não deve haver erro de jQuery tooltip

## Se algo der errado

### Erro: Container não sobe

```bash
# Ver logs
docker-compose -f docker-compose-prod.yml logs php
docker-compose -f docker-compose-prod.yml logs nginx
```

### Erro: rev-manifest.json não encontrado

```bash
# Verificar se o entrypoint executou
docker-compose -f docker-compose-prod.yml logs php | grep "Assets atualizados"

# Deve mostrar: "Assets atualizados com sucesso!"

# Se não mostrar, force a atualização:
docker-compose -f docker-compose-prod.yml down
docker volume rm prodseara_public_assets
docker-compose -f docker-compose-prod.yml up -d
```

### Erro: Assets ainda não carregam (404)

```bash
# Verificar se os volumes estão corretos
docker inspect searaprodphp | grep -A 10 "Mounts"

# Deve mostrar:
# - public_assets:/var/www/public
# - uploads:/var/www/public/img/images

# Verificar conteúdo do volume
docker run --rm -v prodseara_public_assets:/public alpine ls -lh /public/build/

# Deve listar: rev-manifest.json
```

### Erro: Página em branco ou erro 500

```bash
# Limpar cache do Laravel
docker exec searaprodphp php artisan config:clear
docker exec searaprodphp php artisan cache:clear
docker exec searaprodphp php artisan view:clear

# Reiniciar containers
docker-compose -f docker-compose-prod.yml restart
```

## Resumo do que acontece no deploy

1. **Down**: Para os containers atuais
2. **Volume rm**: Remove volume de assets antigos (força atualização)
3. **Pull**: Baixa imagem 1.1.15 do Docker Hub
4. **Up**: Inicia containers
5. **Entrypoint**: Copia `/tmp/public-assets` → `/var/www/public` (incluindo `/build/rev-manifest.json`)
6. **Nginx**: Lê assets do volume compartilhado `public_assets`

## Arquivos importantes na versão 1.1.15

```
/var/www/public/
├── build/
│   └── rev-manifest.json          ← NOVO! Resolve o erro
├── js/
│   └── financing/
│       └── receivable.min.js      ← Atualizado com suas mudanças
├── css/
│   └── ...
└── fonts/
    └── ...
```

## Checklist Final

- [ ] docker-compose-prod.yml atualizado para versão 1.1.15
- [ ] force-update-production.sh executado com sucesso
- [ ] Containers estão "Up" e "healthy"
- [ ] rev-manifest.json existe em `/var/www/public/build/`
- [ ] receivable.min.js tem o checksum correto
- [ ] Página de receivables carrega sem erros no browser
- [ ] Erro "not defined in asset manifest" desapareceu

---

**Qualquer dúvida**, consulte os logs:
```bash
docker-compose -f docker-compose-prod.yml logs -f
```
