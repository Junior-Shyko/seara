# Deploy de Produção com Docker Compose

Este guia explica como fazer deploy da aplicação Seara em produção usando Docker Compose.

## Pré-requisitos

- Docker Engine 20.10+
- Docker Compose 1.29+
- Acesso à imagem: `junioroliveira/seara:1.1.15`

## Estrutura

A imagem Docker já contém:
- Todo o código da aplicação
- Assets compilados (CSS/JS via Gulp)
- Dependências do Composer instaladas
- Dependências do NPM/Bower instaladas

## Configuração Inicial

### 1. Preparar o ambiente

```bash
# Criar diretórios necessários
mkdir -p storage/{app,framework,logs}
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p bootstrap/cache

# Configurar permissões
chmod -R 775 storage bootstrap/cache
```

### 2. Configurar arquivo .env

```bash
# Copiar exemplo (se necessário)
cp .env.example .env

# Editar variáveis de produção
nano .env
```

**Variáveis importantes para produção:**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com.br

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=seara
DB_USERNAME=laravel
DB_PASSWORD=SUA_SENHA_SEGURA

# Configurar credenciais seguras do MySQL
DB_ROOT_PASSWORD=SUA_SENHA_ROOT_SEGURA
```

### 3. Iniciar os containers

```bash
# Subir os serviços
docker compose -f docker-compose.production.yml up -d

# Verificar status
docker compose -f docker-compose.production.yml ps

# Ver logs
docker compose -f docker-compose.production.yml logs -f
```

### 4. Executar migrações

```bash
# Rodar migrações do banco de dados
docker compose -f docker-compose.production.yml exec php php artisan migrate --force

# Se necessário, migrar entries
docker compose -f docker-compose.production.yml exec php php artisan entries:migrate
```

### 5. Configurar permissões finais

```bash
# Dentro do container
docker compose -f docker-compose.production.yml exec php chmod -R 775 storage bootstrap/cache
docker compose -f docker-compose.production.yml exec php chown -R www-data:www-data storage bootstrap/cache
```

## Atualização de Versão

### 1. Baixar nova imagem

```bash
# Pull da nova versão
docker pull junioroliveira/seara:1.1.16

# Atualizar docker-compose.production.yml com a nova versão
sed -i 's/seara:1.1.15/seara:1.1.16/g' docker-compose.production.yml
```

### 2. Atualizar containers

```bash
# Parar containers atuais
docker compose -f docker-compose.production.yml down

# Subir com nova imagem
docker compose -f docker-compose.production.yml up -d

# Rodar migrações se necessário
docker compose -f docker-compose.production.yml exec php php artisan migrate --force

# Limpar cache
docker compose -f docker-compose.production.yml exec php php artisan cache:clear
docker compose -f docker-compose.production.yml exec php php artisan config:cache
docker compose -f docker-compose.production.yml exec php php artisan route:cache
```

## Backup

### Backup do Banco de Dados

```bash
# Criar backup
docker compose -f docker-compose.production.yml exec mysql mysqldump -u root -p seara > backup-$(date +%Y%m%d-%H%M%S).sql

# Restaurar backup
docker compose -f docker-compose.production.yml exec -T mysql mysql -u root -p seara < backup-20231215-120000.sql
```

### Backup de Uploads

```bash
# Backup do diretório storage
tar -czf storage-backup-$(date +%Y%m%d-%H%M%S).tar.gz storage/
```

## Monitoramento

### Ver logs

```bash
# Todos os serviços
docker compose -f docker-compose.production.yml logs -f

# Apenas PHP
docker compose -f docker-compose.production.yml logs -f php

# Apenas Nginx
docker compose -f docker-compose.production.yml logs -f nginx

# Apenas MySQL
docker compose -f docker-compose.production.yml logs -f mysql
```

### Verificar saúde dos containers

```bash
docker compose -f docker-compose.production.yml ps
docker inspect seara-php-prod | grep -A 10 Health
docker inspect seara-nginx-prod | grep -A 10 Health
docker inspect seara-mysql-prod | grep -A 10 Health
```

## SSL/HTTPS (Opcional)

Para configurar SSL com Let's Encrypt:

1. Instalar certbot
2. Gerar certificados
3. Montar certificados no nginx
4. Atualizar configuração do nginx para usar HTTPS

```bash
# Exemplo com certbot
certbot certonly --standalone -d seu-dominio.com.br
```

Adicionar ao `docker-compose.production.yml` no serviço nginx:

```yaml
volumes:
  - /etc/letsencrypt:/etc/letsencrypt:ro
```

## Troubleshooting

### Container não inicia

```bash
# Ver logs detalhados
docker compose -f docker-compose.production.yml logs php

# Verificar configuração
docker compose -f docker-compose.production.yml config
```

### Problemas de permissão

```bash
# Corrigir permissões
docker compose -f docker-compose.production.yml exec php chmod -R 775 storage bootstrap/cache
docker compose -f docker-compose.production.yml exec php chown -R www-data:www-data storage bootstrap/cache
```

### Limpar tudo e recomeçar

```bash
# CUIDADO: Isso remove volumes e dados!
docker compose -f docker-compose.production.yml down -v
docker compose -f docker-compose.production.yml up -d
```

## Comandos Úteis

```bash
# Entrar no container PHP
docker compose -f docker-compose.production.yml exec php bash

# Executar artisan commands
docker compose -f docker-compose.production.yml exec php php artisan [comando]

# Acessar MySQL
docker compose -f docker-compose.production.yml exec mysql mysql -u root -p

# Reiniciar serviço específico
docker compose -f docker-compose.production.yml restart php
```

## Segurança

- Sempre usar senhas fortes para MySQL
- Manter `APP_DEBUG=false` em produção
- Configurar firewall para expor apenas portas necessárias (80, 443)
- Manter imagens Docker atualizadas
- Fazer backups regulares
- Usar HTTPS em produção
