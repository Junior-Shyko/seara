# Deploy - Seara

Este documento descreve o processo de deploy da aplicação Seara.

## Pré-requisitos

- Docker e Docker Compose instalados
- Acesso ao Docker Hub (imagem: `junioroliveira/seara`)
- Arquivo `.env` configurado para produção

## Deploy Automatizado

### Via GitHub Actions

O deploy é acionado automaticamente quando um PR é mergeado na branch `develop`.

Secrets necessários no GitHub:
- `DOCKER_USERNAME`: usuário do Docker Hub
- `DOCKER_PASSWORD`: senha ou token do Docker Hub
- `DEPLOY_HOST`: servidor de destino
- `DEPLOY_USER`: usuário SSH
- `DEPLOY_KEY`: chave SSH privada
- `DEPLOY_PATH`: caminho no servidor

### Via Script

```bash
# Deploy com versão específica
./deploy.sh 1.1.16

# Ou deploy simples
./deploy-production.sh
```

## Deploy Manual

### 1. Baixar nova imagem

```bash
docker pull junioroliveira/seara:latest
```

### 2. Parar containers

```bash
docker compose -f docker-compose.production.yml down
```

### 3. Subir containers

```bash
docker compose -f docker-compose.production.yml up -d
```

### 4. Executar migrações

```bash
docker compose -f docker-compose.production.yml exec php php artisan migrate --force
```

---

## Mudanças Recentes

### Upload de Arquivos para Storage

Os arquivos de upload agora são salvos dentro da pasta `storage/app/public/` ao invés de `public/img/`.

**Estrutura atual:**
```
storage/
└── app/
    └── public/
        └── images/       # Imagens de uploads
            └── ...
```

### Migração do Volume de Imagens

Se você possui imagens antigas em `public/img/images/`, é necessário migrar para `storage/app/public/images/`:

```bash
# 1. Acessar o container
docker compose -f docker-compose.production.yml exec php bash

# 2. Mover as imagens para storage
mv /var/www/public/img/images/* /var/www/storage/app/public/images/

# Ou via host (fora do container)
mv ./public/img/images/* ./storage/app/public/images/
```

### Permissões da Pasta Storage

A pasta `storage` precisa de permissões de escrita para o web server:

```bash
# Via container
docker compose -f docker-compose.production.yml exec php chmod -R 775 storage

# Via host
sudo chmod -R 775 storage
sudo chown -R www-data:www-data storage
```

### Link Simbólico (storage:link)

O Laravel precisa de um link simbólico de `public/storage` para `storage/app/public` para servir arquivos públicos:

```bash
# Criar link simbólico
docker compose -f docker-compose.production.yml exec php php artisan storage:link
```

**Verificar se o link existe:**
```bash
ls -la public/ | grep storage
# Deve mostrar: storage -> /var/www/storage/app/public
```

> **Nota:** O comando `storage:link` já é executado automaticamente no startup do container conforme configurado no `docker-compose.production.yml`.

---

## Checklist de Deploy

- [ ] Backup do banco de dados
- [ ] Pull da nova imagem
- [ ] Parar containers
- [ ] Subir novos containers
- [ ] Executar migrações
- [ ] Verificar permissões do storage (`chmod -R 775 storage`)
- [ ] Verificar link simbólico (`php artisan storage:link`)
- [ ] Limpar cache (`php artisan cache:clear && config:cache && route:cache`)
- [ ] Testar aplicação

## Volumes e Persistência de Dados

### Tipos de Montagem

| Montagem | Tipo | O que contém | Perde ao apagar volume? |
|----------|------|--------------|-------------------------|
| `./storage` | **Bind mount** | Uploads, logs, cache | **NÃO** - está no host |
| `./bootstrap/cache` | **Bind mount** | Cache do Laravel | **NÃO** - está no host |
| `mysql-data` | Volume Docker | Dados do MySQL | **SIM** - não apagar! |
| `app-root` | Volume Docker | Código da aplicação | Sim, recria da imagem |
| `app-public` | Volume Docker | CSS/JS compilados | Sim, recria da imagem |
| `app-vendor` | Volume Docker | Dependências Composer | Sim, recria da imagem |

### Limpeza de Volumes Docker (Deploy Limpo)

Ao atualizar a aplicação, pode ser necessário limpar os volumes Docker para garantir que o código novo seja utilizado:

```bash
# 1. Parar containers
docker compose -f docker-compose.production.yml down

# 2. Listar volumes (para verificar os nomes)
docker volume ls | grep seara

# 3. Remover volumes de código (SEGURO - não afeta uploads)
docker volume rm prodseara_app-root
docker volume rm prodseara_app-public
docker volume rm prodseara_app-vendor

# 4. Subir containers (volumes serão recriados com código novo)
docker compose -f docker-compose.production.yml up -d

# 5. Recriar link simbólico e ajustar permissões
docker compose -f docker-compose.production.yml exec php php artisan storage:link
docker compose -f docker-compose.production.yml exec php chmod -R 775 storage
```

> **IMPORTANTE:** Os arquivos de upload em `storage/` **NÃO serão perdidos** ao apagar os volumes `app-root`, `app-public` ou `app-vendor`, pois o storage é um **bind mount** que aponta diretamente para a pasta `./storage` no servidor host.

### Volumes que NUNCA devem ser apagados

- `mysql-data` - Contém todos os dados do banco de dados
- `./storage` - Contém uploads de usuários (mas este é bind mount, não volume Docker)

## Troubleshooting

### Imagens não aparecem

1. Verificar se o link simbólico existe:
   ```bash
   docker compose -f docker-compose.production.yml exec php ls -la public/storage
   ```

2. Recriar link simbólico:
   ```bash
   docker compose -f docker-compose.production.yml exec php php artisan storage:link
   ```

3. Verificar permissões:
   ```bash
   docker compose -f docker-compose.production.yml exec php chmod -R 775 storage
   ```

### Erro de permissão no storage

```bash
docker compose -f docker-compose.production.yml exec php chown -R www-data:www-data storage
docker compose -f docker-compose.production.yml exec php chmod -R 775 storage
```

### Logs

```bash
# Ver logs de todos os containers
docker compose -f docker-compose.production.yml logs -f

# Logs apenas do PHP
docker compose -f docker-compose.production.yml logs -f php

# Logs do Laravel
docker compose -f docker-compose.production.yml exec php tail -f storage/logs/laravel.log
```
