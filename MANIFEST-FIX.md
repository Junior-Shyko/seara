# Correção do Erro "File not defined in asset manifest"

## O Problema

Erro em produção:
```
File js/financing/receivable.js not defined in asset manifest.
(View: /var/www/resources/views/financing/receivable/index.blade.php)
```

## Causa Raiz

O Laravel Elixir usa a função `elixir()` nas views para buscar assets no arquivo `public/build/rev-manifest.json`, mas:

1. ❌ O arquivo `rev-manifest.json` não existia
2. ❌ O blade estava referenciando `receivable.js` (sem .min)
3. ❌ O arquivo compilado é `receivable.min.js` (com .min)

## Solução Implementada

### 1. Criado `public/build/rev-manifest.json`

Este arquivo mapeia as referências de assets para os arquivos compilados:

```json
{
  "js/financing/receivable.js": "js/financing/receivable.min.js",
  "js/financing/receivable.min.js": "js/financing/receivable.min.js",
  ...
}
```

**Importante**: Note a linha 21 do manifest - mapeia `receivable.js` → `receivable.min.js`

### 2. Arquivos Modificados

- ✅ `public/build/rev-manifest.json` (NOVO - criado)
- ✅ `gulpfile.js` (limpo, sem geração automática do manifest)

## Como Aplicar a Correção em Produção

### Opção 1: Build completo e deploy (RECOMENDADO)

```bash
# 1. No ambiente LOCAL:
./build-production.sh 1.1.15

# Quando perguntar se quer fazer push, responda "s"

# 2. No SERVIDOR (droplet):
ssh user@droplet-ip
cd /caminho/para/seara

# Editar docker-compose-prod.yml
nano docker-compose-prod.yml
# Alterar linha 29: image: junioroliveira/seara:1.1.15

# Executar atualização forçada
./force-update-production.sh 1.1.15
```

### Opção 2: Copiar apenas o manifest (RÁPIDO - para teste)

```bash
# No SERVIDOR (droplet):
ssh user@droplet-ip
cd /caminho/para/seara

# Criar diretório build se não existir
mkdir -p public/build

# Criar o arquivo rev-manifest.json
cat > public/build/rev-manifest.json << 'EOF'
{
  "css/gentelella.min.css": "css/gentelella.min.css",
  "css/receipt.min.css": "css/receipt.min.css",
  "css/receipt-pdf.min.css": "css/receipt-pdf.min.css",
  "css/company.min.css": "css/company.min.css",
  "css/home.min.css": "css/home.min.css",
  "css/entry.min.css": "css/entry.min.css",
  "css/setting-box.css": "css/setting-box.css",
  "css/plugins": "css/plugins",
  "js/gentelella.min.js": "js/gentelella.min.js",
  "js/register.min.js": "js/register.min.js",
  "js/company.min.js": "js/company.min.js",
  "js/parsley.min.js": "js/parsley.min.js",
  "js/mask_camp.min.js": "js/mask_camp.min.js",
  "js/mask.min.js": "js/mask.min.js",
  "js/receipt.min.js": "js/receipt.min.js",
  "js/users.min.js": "js/users.min.js",
  "js/home.min.js": "js/home.min.js",
  "js/customer.min.js": "js/customer.min.js",
  "js/financing/account.min.js": "js/financing/account.min.js",
  "js/financing/income_category.min.js": "js/financing/income_category.min.js",
  "js/financing/receivable.min.js": "js/financing/receivable.min.js",
  "js/financing/receivable.js": "js/financing/receivable.min.js",
  "js/financing/payment.min.js": "js/financing/payment.min.js",
  "js/launch/account_launch.min.js": "js/launch/account_launch.min.js",
  "js/launch/entry.min.js": "js/launch/entry.min.js",
  "js/bank/bank.js": "js/bank/bank.js",
  "js/typeBank/typeBank.min.js": "js/typeBank/typeBank.min.js",
  "js/permission/list_permission.min.js": "js/permission/list_permission.min.js",
  "js/setting_box/setting-box.js": "js/setting_box/setting-box.js"
}
EOF

# Copiar para dentro do container PHP
docker cp public/build/rev-manifest.json searaprodphp:/var/www/public/build/rev-manifest.json

# Verificar se foi copiado
docker exec searaprodphp ls -lh /var/www/public/build/rev-manifest.json

# Testar a aplicação no browser
```

## Verificação

Após aplicar a correção, verifique:

1. **No terminal do servidor**:
```bash
# Verificar se o manifest existe no container
docker exec searaprodphp cat /var/www/public/build/rev-manifest.json | grep receivable
```

Deve retornar:
```json
"js/financing/receivable.js": "js/financing/receivable.min.js",
"js/financing/receivable.min.js": "js/financing/receivable.min.js",
```

2. **No browser**:
   - Acesse a página de receivables
   - O erro "not defined in asset manifest" deve desaparecer
   - Os assets devem carregar normalmente

## Notas Importantes

1. **Sempre que adicionar um novo asset compilado**, adicione-o ao `rev-manifest.json`
2. O manifest precisa estar em `public/build/rev-manifest.json`
3. O manifest é incluído automaticamente na imagem Docker (via `COPY . /var/www`)
4. Para novos arquivos .js/.css, adicione duas linhas no manifest:
   ```json
   "path/to/file.js": "path/to/file.min.js",
   "path/to/file.min.js": "path/to/file.min.js"
   ```

## Troubleshooting

### Erro persiste após copiar o manifest

**Solução**: O container pode estar usando cache. Force a atualização:
```bash
./force-update-production.sh 1.1.15
```

### Manifest não é encontrado

**Solução**: Verifique se o diretório build/ foi copiado para o volume:
```bash
docker exec searaprodphp ls -lha /var/www/public/
docker exec searaprodnginx ls -lha /var/www/public/
```

Se não estiver lá, use a Opção 2 (copiar manualmente).

### Outros assets também não funcionam

**Solução**: Verifique se eles estão no manifest:
```bash
docker exec searaprodphp cat /var/www/public/build/rev-manifest.json
```

Adicione os assets faltantes ao manifest e copie novamente.

## Resumo

✅ **Problema**: Laravel Elixir não encontrava o manifest
✅ **Solução**: Criado `public/build/rev-manifest.json` com mapeamento de todos os assets
✅ **Deploy**: Incluir manifest na imagem Docker ou copiar manualmente para o container
