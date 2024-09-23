# Descargar imágenes docker
docker pull shinsenter/laravel:php8.1

docker pull mysql:5.7

# Crear contenedores docker
docker run --name finanzapp-db -p 3306:3306 -e MYSQL_ROOT_PASSWORD=password -d mysql:5.7

docker run -p 80:80 -p 443:443 -p 443:443/udp -v .:/var/www/html --name finanzapp -d shinsenter/laravel:php8.1

# Crear un red y conectarlos a los contendores
docker network create finanzapp-net

docker network connect finanzapp-net finanzapp-db

docker network connect finanzapp-net finanzapp

# Acceder al contenedor con Laravel 8.x y PHP 8.x

docker exec -it finanzapp /bin/bash

```shell
$ php artisan key:generate
$ php artisan config:clear
$ php artisan migrate
```
