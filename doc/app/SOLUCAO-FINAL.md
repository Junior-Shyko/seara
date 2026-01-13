# Solução Final - Assets Receivable

## 🔍 O Problema Identificado

Você percebeu a diferença crucial:

**FUNCIONANDO (account):**
```html
<script src="https://app.searacontabilidade.com.br/js/financing/account.min.js"></script>
```
Caminho: `/js/financing/account.min.js` ✅

**NÃO FUNCIONANDO (receivable):**
```html
<script src="/build/js/financing/receivable.min.js"></script>
```
Caminho: `/build/js/financing/receivable.min.js` ❌ 404

## 🎯 Causa Raiz

O Laravel Blade **compila e cacheia** as views em `storage/framework/views/`.

No `docker-compose-prod.yml` (linha 32):
```yaml
volumes:
  - ./storage:/var/www/storage  # ← Este volume preserva o cache!
```

**O que aconteceu:**
1. ✅ Você alterou `receivable/index.blade.php` para usar `asset()` (localmente)
2. ✅ Fez build da imagem 1.1.16 com a view correta
3. ❌ MAS o servidor tem o **cache compilado antigo** em `./storage/framework/views/`
4. ❌ Laravel usa o cache antigo (com `elixir()`) em vez da view nova (com `asset()`)

**Por que account funciona?**
- Porque `account/index.blade.php` **sempre usou** `asset()` desde o início
- Então o cache também está correto!

## ✅ Solução Imediata (NO SERVIDOR)

### Opção 1: Script automatizado (RECOMENDADO)

```bash
# No servidor de produção:
ssh user@seu-droplet-ip
cd /caminho/para/seara

# Copiar o script do git (se ainda não tem)
# ou executar:
./clear-cache-production.sh
```

### Opção 2: Comandos manuais

```bash
# No servidor de produção:
docker exec searaprodphp php artisan view:clear
docker exec searaprodphp php artisan cache:clear
docker exec searaprodphp php artisan config:clear

# Testar no browser
```

### Opção 3: Forçar deploy completo (mais drástico)

```bash
# No servidor:
docker-compose -f docker-compose-prod.yml down

# Remover cache local (CUIDADO: isso apaga todo o cache)
sudo rm -rf storage/framework/views/*
sudo rm -rf storage/framework/cache/*

# Subir novamente
docker-compose -f docker-compose-prod.yml up -d
```

## 🧪 Verificação

Depois de limpar o cache, verifique:

1. **No browser (Ctrl+U para ver código fonte):**
```html
<!-- ANTES (errado): -->
<script src="/build/js/financing/receivable.min.js"></script>

<!-- DEPOIS (correto): -->
<script src="/js/financing/receivable.min.js"></script>
```

2. **No DevTools (F12 → Network):**
- `/js/financing/receivable.min.js` → Status **200** ✅
- Não deve mais aparecer `/build/js/financing/receivable.min.js`

3. **Funcionalidade:**
- Erro de jQuery tooltip desaparece
- Funções do receivable funcionam normalmente

## 📊 Comparação: Antes vs Depois

### ANTES (com cache antigo)

```
Browser solicita → /build/js/financing/receivable.min.js
                    ↓
                   404 (não existe)
                    ↓
                  ERRO!
```

**Por quê?** Cache do Blade tem view com `elixir()` → gera caminho `/build/...`

### DEPOIS (cache limpo)

```
Browser solicita → /js/financing/receivable.min.js
                    ↓
                   200 (existe!)
                    ↓
                  SUCESSO ✅
```

**Por quê?** Cache limpo → Laravel lê view nova com `asset()` → gera caminho `/js/...`

## 🔧 Solução Permanente para Futuros Deploys

Para evitar esse problema no futuro, adicione ao script `force-update-production.sh`:

```bash
# Após subir os containers, adicionar:
echo "Limpando cache do Laravel..."
docker exec searaprodphp php artisan view:clear
docker exec searaprodphp php artisan cache:clear
docker exec searaprodphp php artisan config:clear
```

Ou simplesmente execute `./clear-cache-production.sh` após cada deploy.

## 📝 Resumo do Que Foi Feito

1. ✅ Identificamos que `elixir()` procura em `/build/`
2. ✅ Mudamos para `asset()` que procura em `/` (raiz de public)
3. ✅ Build da imagem 1.1.16 com views corrigidas
4. ✅ Criado script `clear-cache-production.sh`
5. ⏳ **FALTA**: Executar no servidor para limpar o cache!

## 🚀 Comando Final (Execute isso no servidor!)

```bash
ssh user@seu-droplet-ip
cd /caminho/para/seara
docker exec searaprodphp php artisan view:clear
```

Isso deve resolver **imediatamente**! 🎯

## 🎓 Lição Aprendida

**Sempre que alterar views (.blade.php) em produção:**
```bash
docker exec searaprodphp php artisan view:clear
```

O volume `./storage` preserva cache entre deploys, então mudanças em views precisam de limpeza manual do cache!
