# Setup Local sem Proxy Reverso

Este guia mostra como rodar a aplicação localmente usando `searaapp.local` sem Let's Encrypt.

## Opção 1: Usar docker-compose.local.yml (Recomendado)

Use o arquivo `docker-compose.local.yml` que já está configurado para ambiente local:

```bash
# Subir containers
docker compose -f docker-compose.local.yml up -d

# Ver logs
docker compose -f docker-compose.local.yml logs -f

# Parar containers
docker compose -f docker-compose.local.yml down
```

## Opção 2: Modificar docker-compose.production.yml temporariamente

Se preferir modificar o arquivo de produção temporariamente, faça estas 5 mudanças:

### MUDANÇA 1: Trocar `expose` por `ports` no serviço nginx

```yaml
# De:
expose:
  - "80"

# Para:
ports:
  - "80:80"
```

### MUDANÇA 2: Comentar a rede nginx-proxy

```yaml
networks:
  - seara-prod
  # - nginx-proxy  # <-- Comentar esta linha
```

### MUDANÇA 3: Comentar variáveis de ambiente

```yaml
# Comentar todo este bloco:
# environment:
#   - VIRTUAL_HOST=${VIRTUAL_HOST:-app.searacontabilidade.com.br}
#   - LETSENCRYPT_HOST=${LETSENCRYPT_HOST:-app.searacontabilidade.com.br}
#   - LETSENCRYPT_EMAIL=${LETSENCRYPT_EMAIL:-franciscoanto@gmail.com}
```

### MUDANÇA 4: Comentar labels

```yaml
# Comentar:
# labels:
#   - "com.github.jrcs.letsencrypt_nginx_proxy_companion.nginx_proxy=true"
```

### MUDANÇA 5: Comentar rede externa no final do arquivo

```yaml
networks:
  seara-prod:
    driver: bridge
  # nginx-proxy:    # <-- Comentar estas 2 linhas
  #   external: true
```

## Configurar /etc/hosts

Adicione o domínio local ao seu arquivo `/etc/hosts`:

```bash
# Editar /etc/hosts
sudo nano /etc/hosts

# Adicionar linha:
127.0.0.1   searaapp.local
```

## Configurar .env

Certifique-se que o `.env` está configurado para local:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://searaapp.local

DB_HOST=mysql
DB_DATABASE=seara
DB_USERNAME=laravel
DB_PASSWORD=secret
```

## Iniciar Aplicação

```bash
# Com docker-compose.local.yml
docker compose -f docker-compose.local.yml up -d

# OU com docker-compose.production.yml modificado
docker compose -f docker-compose.production.yml up -d

# Aguardar containers ficarem saudáveis
sleep 15

# Verificar status
docker compose -f docker-compose.local.yml ps
```

## Acessar Aplicação

Abra no navegador:

```
http://searaapp.local
```

Ou teste via curl:

```bash
curl -I http://searaapp.local
```

## Executar Migrações

```bash
# Com docker-compose.local.yml
docker compose -f docker-compose.local.yml exec php php artisan migrate

# OU com docker-compose.production.yml
docker compose -f docker-compose.production.yml exec php php artisan migrate
```

## Comandos Úteis

```bash
# Ver logs
docker compose -f docker-compose.local.yml logs -f

# Shell do PHP
docker compose -f docker-compose.local.yml exec php bash

# Artisan
docker compose -f docker-compose.local.yml exec php php artisan [comando]

# MySQL
docker compose -f docker-compose.local.yml exec mysql mysql -u root -p

# Limpar cache
docker compose -f docker-compose.local.yml exec php php artisan cache:clear
docker compose -f docker-compose.local.yml exec php php artisan config:cache
```

## Parar Aplicação

```bash
docker compose -f docker-compose.local.yml down
```

## Diferenças Local vs Produção

| Configuração | Local | Produção |
|-------------|-------|----------|
| Porta | `ports: - "80:80"` | `expose: - "80"` |
| Rede nginx-proxy | Não | Sim |
| VIRTUAL_HOST | Não | Sim |
| Let's Encrypt | Não | Sim |
| SSL | Não | Sim (automático) |
| Domínio | searaapp.local | app.searacontabilidade.com.br |
| APP_DEBUG | true | false |
| APP_ENV | local | production |

## Troubleshooting

### Porta 80 já está em uso

```bash
# Ver o que está usando a porta 80
sudo lsof -i :80

# Parar apache/nginx local se estiver rodando
sudo systemctl stop apache2
# ou
sudo systemctl stop nginx
```

### Domínio não resolve

```bash
# Verificar /etc/hosts
cat /etc/hosts | grep searaapp

# Testar DNS
ping searaapp.local

# Se não resolver, adicione novamente
echo "127.0.0.1   searaapp.local" | sudo tee -a /etc/hosts
```

### Erro 502 Bad Gateway

```bash
# Verificar se PHP está rodando
docker compose -f docker-compose.local.yml ps

# Ver logs do PHP
docker compose -f docker-compose.local.yml logs php

# Ver logs do Nginx
docker compose -f docker-compose.local.yml logs nginx
```

## Voltar para Produção

Quando terminar os testes locais e quiser voltar para produção:

1. Desfaça as 5 mudanças no `docker-compose.production.yml` (ou use o git)
2. Ou simplesmente use `docker-compose.production.yml` original
3. Reconfigure o `.env` para produção

```bash
# Parar ambiente local
docker compose -f docker-compose.local.yml down

# Subir produção
docker compose -f docker-compose.production.yml up -d
```
