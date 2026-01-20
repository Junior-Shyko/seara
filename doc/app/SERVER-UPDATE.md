# Arquivos que Precisam Ser Atualizados no Servidor

Este documento lista EXATAMENTE o que precisa ser enviado/atualizado no seu droplet de produção.

## Resumo das Mudanças

### docker-compose-prod.yml - MUDOU MUITO! ⚠️

**Mudanças principais:**
- Versão da imagem: `1.1.13` → `1.1.14` (linha 29)
- Adicionado volume `public_assets:/var/www/public` (linha 34)
- Volume de uploads agora usa `storage_uploads:/var/www/storage/app/public` (linha 35)
- Nginx agora usa `public_assets:/var/www/public:ro` (linha 75)
- Removido `volumes_from` do nginx
- Adicionados volumes na seção volumes: `public_assets` e `uploads` (linhas 107-108)

## Arquivos que DEVEM ir para o servidor

### 1️⃣ Arquivos OBRIGATÓRIOS (sem eles não funciona!)

```
docker-compose-prod.yml          ← MODIFICADO - Configuração principal
docker/php/Dockerfile            ← MODIFICADO - Precisa do entrypoint
docker/php/docker-entrypoint.sh  ← NOVO - Script que copia assets
```

### 2️⃣ Scripts úteis (recomendados)

```
force-update-production.sh       ← NOVO - Atualiza assets forçadamente
deploy-production.sh             ← NOVO - Deploy automatizado
migrate-uploads.sh              ← NOVO - Migra uploads (primeira vez)
DEPLOY.md                       ← NOVO - Documentação completa
```

### 3️⃣ Arquivos que NÃO precisam ir (só local)

```
build-production.sh             ← Só para ambiente de desenvolvimento
resources/assets/js/...         ← Vai dentro da imagem Docker
public/js/...                   ← Vai dentro da imagem Docker
```

## Como Enviar os Arquivos para o Servidor

### Opção 1: Usando Git (RECOMENDADO)

```bash
# 1. No ambiente LOCAL, fazer commit de tudo
git add docker-compose-prod.yml \
        docker/php/Dockerfile \
        docker/php/docker-entrypoint.sh \
        force-update-production.sh \
        deploy-production.sh \
        migrate-uploads.sh \
        DEPLOY.md

git commit -m "feat: sistema de atualização automática de assets em produção"
git push origin develop  # ou master, dependendo da sua branch

# 2. No SERVIDOR, fazer pull
ssh user@seu-droplet-ip
cd /caminho/para/seara
git pull

# 3. Dar permissão aos scripts
chmod +x force-update-production.sh
chmod +x deploy-production.sh
chmod +x migrate-uploads.sh
chmod +x docker/php/docker-entrypoint.sh
```

### Opção 2: Usando SCP (Manual)

```bash
# Do ambiente LOCAL, copiar arquivos para o servidor
scp docker-compose-prod.yml user@droplet-ip:/caminho/para/seara/
scp docker/php/Dockerfile user@droplet-ip:/caminho/para/seara/docker/php/
scp docker/php/docker-entrypoint.sh user@droplet-ip:/caminho/para/seara/docker/php/
scp force-update-production.sh user@droplet-ip:/caminho/para/seara/
scp deploy-production.sh user@droplet-ip:/caminho/para/seara/
scp migrate-uploads.sh user@droplet-ip:/caminho/para/seara/
scp DEPLOY.md user@droplet-ip:/caminho/para/seara/

# Depois, no SERVIDOR, dar permissões
ssh user@droplet-ip
cd /caminho/para/seara
chmod +x force-update-production.sh
chmod +x deploy-production.sh
chmod +x migrate-uploads.sh
chmod +x docker/php/docker-entrypoint.sh
```

### Opção 3: Copiar e Colar Manualmente (Última opção)

```bash
# No SERVIDOR, editar cada arquivo manualmente
ssh user@droplet-ip
cd /caminho/para/seara

# Exemplo para docker-compose-prod.yml:
nano docker-compose-prod.yml
# Copiar e colar o conteúdo do arquivo local

# Repetir para cada arquivo necessário
```

## Checklist Pós-Envio

Depois de enviar os arquivos, verifique:

```bash
# No SERVIDOR:
cd /caminho/para/seara

# 1. Verificar se docker-compose-prod.yml tem as mudanças
grep "1.1.14" docker-compose-prod.yml
grep "public_assets" docker-compose-prod.yml

# 2. Verificar se o entrypoint existe
ls -lh docker/php/docker-entrypoint.sh

# 3. Verificar permissões dos scripts
ls -lh *.sh

# 4. Se necessário, dar permissões
chmod +x force-update-production.sh
chmod +x deploy-production.sh
chmod +x migrate-uploads.sh
chmod +x docker/php/docker-entrypoint.sh
```

## Próximo Passo: Fazer o Deploy

Depois de enviar os arquivos, execute:

```bash
# No SERVIDOR:
./force-update-production.sh 1.1.14
```

Isso vai:
1. Parar os containers
2. Remover volumes antigos
3. Baixar a nova imagem
4. Subir com assets atualizados

## Resumo Visual

```
SEU COMPUTADOR (local)              SERVIDOR (droplet)
==================                  ==================

docker-compose-prod.yml    ───►     docker-compose-prod.yml
docker/php/Dockerfile      ───►     docker/php/Dockerfile
docker/php/entrypoint.sh   ───►     docker/php/entrypoint.sh
force-update-prod.sh       ───►     force-update-prod.sh
deploy-production.sh       ───►     deploy-production.sh
migrate-uploads.sh         ───►     migrate-uploads.sh

                                    └─► Executar:
                                        ./force-update-production.sh
```

## Dúvidas Comuns

**Q: Preciso enviar os assets compilados (public/js/*.min.js)?**
A: NÃO! Eles vão dentro da imagem Docker. Basta fazer o build da imagem localmente e push para Docker Hub.

**Q: E se eu não quiser usar git?**
A: Use SCP ou copie/cole manualmente, mas git é mais fácil e seguro.

**Q: Posso deletar o volume prodseara_public_files antigo?**
A: SIM, mas DEPOIS de verificar que tudo está funcionando. Use: `docker volume rm prodseara_public_files`

**Q: E se der erro?**
A: Veja os logs com: `docker-compose -f docker-compose-prod.yml logs`
