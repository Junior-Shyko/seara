# Seara

Primeiro de tudo, vamos clonar esse repositório

    git clone https://github.com/fcoedno/seara.git
    
> Obs.: Se você tiver `make` pode simplesmente executar `make init`. Esse comando
deve executar todas as rotinas necessárias para subir o projeto :).

Gere o arquivo .env

    cp .env.dist .env

Agora suba o container com `docker-compose`

    docker-compose up -d

Hora de instalar as dependências do projeto

    docker compose exec php composer install
    docker compose exec node npm install gulp@3.x laravel-elixir
    docker compose exec node bower install --allow-root

Agora algumas configurações básicas

    docker-compose exec php php artisan key:generate
    docker-compose exec php php artisan migrate
    docker compose exec node gulp

Talvez seja necessário configurar algumas permissões:

    sudo chmod -R 777 storage

Alterar composer v1 para v2
    
    composer self-update --2
