# Deploy Rápido - Produção

## Setup Inicial

```bash
# 1. Configurar ambiente
cp .env.production.example .env
nano .env  # Editar com suas configurações

# 2. Criar diretórios necessários
mkdir -p storage/{app,framework,logs} storage/framework/{cache,sessions,views} bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 3. Deploy
./deploy.sh 1.1.15
```

## Comandos Rápidos (Makefile)

```bash
# Deploy completo com nova versão
make -f Makefile.production deploy VERSION=1.1.16

# Iniciar/Parar
make -f Makefile.production up
make -f Makefile.production down
make -f Makefile.production restart

# Ver logs
make -f Makefile.production logs
make -f Makefile.production logs-php
make -f Makefile.production logs-nginx

# Status e saúde
make -f Makefile.production status
make -f Makefile.production health

# Migrações
make -f Makefile.production migrate
make -f Makefile.production migrate-entries

# Cache
make -f Makefile.production cache-clear
make -f Makefile.production cache-build

# Backup/Restore
make -f Makefile.production backup
make -f Makefile.production restore FILE=backups/backup-20231215.sql

# Shell/Artisan
make -f Makefile.production shell
make -f Makefile.production artisan CMD="migrate:status"
```

## Comandos Rápidos (Docker Compose)

```bash
# Iniciar
docker compose -f docker-compose.production.yml up -d

# Parar
docker compose -f docker-compose.production.yml down

# Logs
docker compose -f docker-compose.production.yml logs -f

# Artisan
docker compose -f docker-compose.production.yml exec php php artisan [comando]

# Shell
docker compose -f docker-compose.production.yml exec php bash
```

## Estrutura de Arquivos

- `docker-compose.production.yml` - Configuração Docker para produção (com proxy reverso)
- `docker-compose.local.yml` - Configuração Docker para ambiente local (sem proxy)
- `deploy.sh` - Script automatizado de deploy
- `Makefile.production` - Atalhos para comandos comuns
- `.env.production.example` - Template de configuração
- `DEPLOY-PRODUCTION.md` - Documentação completa de deploy
- `PROXY-REVERSO.md` - Guia de configuração com nginx-proxy
- `LOCAL-SETUP.md` - Guia para rodar localmente sem proxy reverso

## Portas

**Com Proxy Reverso (configuração atual):**
- **80** - Disponível apenas para nginx-proxy (não exposta publicamente)
- **443** - Gerenciado pelo nginx-proxy com Let's Encrypt
- **3306** - MySQL (exposta para acesso externo, opcional)

**Sem Proxy Reverso:**
- Veja `PROXY-REVERSO.md` para detalhes de configuração alternativa

## Imagem Docker

A imagem `junioroliveira/seara:X.X.X` já contém:
- Código da aplicação
- Assets compilados (CSS/JS)
- Dependências Composer
- Dependências NPM/Bower

## Volumes Persistentes

- `storage/` - Uploads, logs, cache
- `bootstrap/cache/` - Cache do Laravel
- `mysql-data` - Dados do banco (volume Docker)

## Checklist de Segurança

- [ ] `APP_DEBUG=false` no .env
- [ ] Senhas fortes no MySQL
- [ ] `.env` com permissões restritas (600)
- [ ] HTTPS configurado (certificado SSL)
- [ ] Firewall permitindo apenas portas 80/443
- [ ] Backups automáticos configurados

## Troubleshooting Rápido

**Container não inicia:**
```bash
docker compose -f docker-compose.production.yml logs php
docker compose -f docker-compose.production.yml ps
```

**Erro de permissão:**
```bash
make -f Makefile.production permissions
```

**Erro 500:**
```bash
make -f Makefile.production cache-clear
make -f Makefile.production cache-build
```

**Banco não conecta:**
```bash
# Verificar se MySQL está saudável
docker inspect seara-mysql-prod | grep -A 10 Health

# Ver logs do MySQL
docker compose -f docker-compose.production.yml logs mysql
```

## Atualização de Versão

```bash
# Método 1: Script automatizado (recomendado)
./deploy.sh 1.1.16

# Método 2: Makefile
make -f Makefile.production deploy VERSION=1.1.16

# Método 3: Manual
docker pull junioroliveira/seara:1.1.16
# Editar docker-compose.production.yml com nova versão
docker compose -f docker-compose.production.yml down
docker compose -f docker-compose.production.yml up -d
docker compose -f docker-compose.production.yml exec php php artisan migrate --force
make -f Makefile.production cache-build
```

## Suporte

Para documentação completa, consulte `DEPLOY-PRODUCTION.md`
