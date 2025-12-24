# Configuração com Proxy Reverso

Este guia explica como usar o Seara com um proxy reverso (nginx-proxy + Let's Encrypt).

## Pré-requisitos

Você precisa ter o nginx-proxy e letsencrypt-companion rodando. Se não tiver, crie com:

```bash
# Criar rede do proxy
docker network create nginx-proxy

# Rodar nginx-proxy
docker run -d \
  --name nginx-proxy \
  --restart always \
  --network nginx-proxy \
  -p 80:80 \
  -p 443:443 \
  -v /var/run/docker.sock:/tmp/docker.sock:ro \
  -v nginx-certs:/etc/nginx/certs \
  -v nginx-vhost:/etc/nginx/vhost.d \
  -v nginx-html:/usr/share/nginx/html \
  jwilder/nginx-proxy

# Rodar letsencrypt-companion
docker run -d \
  --name letsencrypt-companion \
  --restart always \
  --network nginx-proxy \
  --volumes-from nginx-proxy \
  -v /var/run/docker.sock:/var/run/docker.sock:ro \
  -v nginx-certs:/etc/nginx/certs:rw \
  -e DEFAULT_EMAIL=seu-email@dominio.com \
  jrcs/letsencrypt-nginx-proxy-companion
```

## Configuração do .env

Configure as variáveis no arquivo `.env`:

```env
# Domínio da aplicação
VIRTUAL_HOST=app.searacontabilidade.com.br

# Let's Encrypt
LETSENCRYPT_HOST=app.searacontabilidade.com.br
LETSENCRYPT_EMAIL=franciscoanto@gmail.com

# Outras configurações...
DB_HOST=mysql
DB_DATABASE=sccontab
DB_USERNAME=usersccontab
DB_PASSWORD=sua-senha-segura
```

## Diferenças da Configuração

O `docker-compose.production.yml` foi configurado para proxy reverso:

### ✅ O que mudou:

1. **Porta do Nginx:**
   - ❌ Antes: `ports: - "80:80"` (expõe diretamente)
   - ✅ Agora: `expose: - "80"` (disponível apenas para proxy)

2. **Redes:**
   - Adicionada rede `nginx-proxy` (externa)
   - Mantida rede interna `seara-prod`

3. **Variáveis de Ambiente:**
   ```yaml
   - VIRTUAL_HOST=${VIRTUAL_HOST}
   - LETSENCRYPT_HOST=${LETSENCRYPT_HOST}
   - LETSENCRYPT_EMAIL=${LETSENCRYPT_EMAIL}
   ```

4. **Labels:**
   - Adicionada label para o letsencrypt-companion

### 📝 O que permanece igual:

- MySQL ainda expõe porta 3306 (opcional, remova se não precisar de acesso externo)
- Volumes e configurações internas não mudam

## Como Usar

### 1. Certifique-se que a rede nginx-proxy existe

```bash
docker network ls | grep nginx-proxy

# Se não existir, crie:
docker network create nginx-proxy
```

### 2. Configure o DNS

Aponte seu domínio para o IP do servidor:

```
A record: app.searacontabilidade.com.br -> IP_DO_SERVIDOR
```

### 3. Suba a aplicação

```bash
docker compose -f docker-compose.production.yml up -d
```

### 4. Verifique os logs

```bash
# Logs da aplicação
docker compose -f docker-compose.production.yml logs -f

# Logs do nginx-proxy
docker logs -f nginx-proxy

# Logs do letsencrypt
docker logs -f letsencrypt-companion
```

### 5. Acesse a aplicação

Aguarde alguns minutos para o certificado SSL ser gerado, então acesse:

```
https://app.searacontabilidade.com.br
```

## Troubleshooting

### Certificado SSL não é gerado

```bash
# Ver logs do letsencrypt-companion
docker logs letsencrypt-companion

# Verificar se o domínio está acessível
curl -I http://app.searacontabilidade.com.br
```

### Erro 502 Bad Gateway

```bash
# Verificar se o container nginx está rodando
docker compose -f docker-compose.production.yml ps

# Verificar se está na rede correta
docker inspect seara-nginx-prod | grep -A 20 Networks
```

### Domínio não encontrado

```bash
# Verificar configuração do VIRTUAL_HOST
docker inspect seara-nginx-prod | grep VIRTUAL_HOST

# Verificar arquivo gerado pelo nginx-proxy
docker exec nginx-proxy cat /etc/nginx/conf.d/default.conf | grep app.searacontabilidade
```

## Acesso Direto (sem proxy)

Se precisar testar sem o proxy reverso temporariamente, você pode:

1. Comentar a rede `nginx-proxy` no docker-compose
2. Trocar `expose` por `ports` novamente
3. Remover as variáveis de ambiente e labels

Mas isso NÃO é recomendado para produção!

## Segurança Adicional

### Remover porta do MySQL

Se não precisar de acesso externo ao MySQL, remova ou comente:

```yaml
# mysql:
#   ports:
#     - "${DB_PORT:-3306}:3306"
```

O MySQL ainda ficará acessível internamente via rede `seara-prod`.

### Firewall

Configure firewall para permitir apenas portas 80 e 443:

```bash
# UFW (Ubuntu)
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw deny 3306/tcp  # Bloquear MySQL externo
sudo ufw enable
```

## Backup com Proxy Reverso

Os comandos de backup permanecem os mesmos:

```bash
# Backup do banco
docker compose -f docker-compose.production.yml exec mysql mysqldump -u root -p sccontab > backup.sql

# Restore
docker compose -f docker-compose.production.yml exec -T mysql mysql -u root -p sccontab < backup.sql
```

## Múltiplas Aplicações

Você pode rodar várias aplicações no mesmo servidor, cada uma com seu domínio:

```
app.searacontabilidade.com.br -> Seara
outro.dominio.com.br -> Outra App
```

Basta que cada container tenha:
- `VIRTUAL_HOST` diferente
- Mesmo `nginx-proxy` network
- Mesmo padrão de labels/environment
