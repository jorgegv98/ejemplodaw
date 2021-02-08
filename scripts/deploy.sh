#!/bin/bash
rm -rf dist
mkdir -p dist
cp -rf src/* dist
node-sass -o dist/css/ dist/scss/main.scss
rm  -rf dist/scss

echo "Carpeta dist y sass compilado"

docker container kill apache_jorge
docker container kill mariadb_jorge
docker container rm apache_jorge
docker container rm mariadb_jorge
echo "Eliminados containers de docker"

cp -rf dist/* opt/jorge/docker/apache_jorge

docker container run \
-d \
-v /opt/jorge/apache_jorge:/var/www/html \
-e VIRTUAL_HOST=jorge.daw2.pve2.fpmislata.com \
-e VIRTUAL_PORT=80 \ 
--name apache_jorge \
php:7.2-apache
echo "Creado contenedor de apache"

docker container run \
-d \
-v /opt/tuNombre/docker/mariadb:/var/lib/mysql  \
-e MYSQL_DATABASE=jorgedb \
-e MYSQL_ROOT_PASSWORD=root  \
-p 5093:3306  \
--name  jorge_mariadb_2 \
--hostname jorgedb \
mariadb:10.1
echo "Creado contenedor de mariadb"

