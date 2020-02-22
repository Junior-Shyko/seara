#!/usr/bin/env bash

docker-compose exec database sh -c "mysql -uroot -proot --database seara < /opt/files/$1"
