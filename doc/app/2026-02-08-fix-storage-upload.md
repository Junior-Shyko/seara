# Fix Storage e Upload de Imagens - 2026-02-08

## Problema 1: Impossivel criar diretorio root do Storage

**Erro:** `League\Flysystem\Exception: Impossible to create the root directory "".`

**Causa:** O diretorio `storage/app/public` estava como um symlink circular, causando o erro `Too many levels of symbolic links`. O Flysystem recebia um path vazio como root do disco `public` e nao conseguia criar o diretorio.

**Solucao:**
```bash
rm storage/app/public
mkdir -p storage/app/public/images
chmod -R 775 storage/app/public
php artisan storage:link
```

## Problema 2: Imagens salvas mas nao renderizadas no navegador

**Erro:** As imagens eram salvas com sucesso via upload (Dropzone), mas a URL `http://searaapp.local/storage/images/...` retornava 404.

**Causa:** No `docker-compose.production.yml`, o container **php** montava o storage do host (`./storage:/var/www/storage`), mas o container **nginx** nao tinha esse bind mount. O symlink `public/storage -> /var/www/storage/app/public` existia, porem o nginx nao conseguia resolver o destino porque o diretorio `storage/` nao estava montado nele.

**Solucao:** Adicionar o bind mount do storage ao container nginx:

```yaml
nginx:
  volumes:
    - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf:ro
    - app-root:/var/www:ro
    - ./storage:/var/www/storage:ro    # linha adicionada
```

Depois reiniciar os containers:
```bash
docker-compose -f docker-compose.production.yml down
docker-compose -f docker-compose.production.yml up -d
```

## Arquivos envolvidos

- `config/filesystems.php` - Configuracao do disco `public`
- `app/Http/Controllers/EntryController.php:304` - Metodo de upload
- `resources/assets/js/launch/entry.js:525-547` - Funcao `getFiles()` que renderiza imagens
- `docker/nginx/default.conf` - Configuracao do Nginx
- `docker-compose.production.yml` - Volumes dos containers
