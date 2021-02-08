#!/bin/bash
rm -rf dist
mkdir -p dist
cp -rf src/* dist
node-sass -o ./dist/web/css/ ./dist/web/scss/main.scss
rm  -rf dist/web/scss

echo "Carpeta dist y sass compilado"

docker container stop apache_jorge
docker container stop mariadb_jorge
docker container rm apache_jorge
docker container rm mariadb_jorge
echo "Eliminados containers de docker"

rm -rf /opt/jorge_garcia/docker/apache
mkdir /opt/jorge_garcia/docker/apache
cp -rf dist/* opt/jorge_garcia/docker/apache

docker container run \
-d \
-v /opt/jorge_garcia/docker/apache:/var/www/html \
-e VIRTUAL_HOST=jorge.daw2.pve2.fpmislata.com \
-e VIRTUAL_PORT=80 \ 
--name apache_jorge \
php:7.2-apache
echo "Creado contenedor de apache"

docker container run \
-d \
-v /opt/jorge_garcia/docker/mariadb:/var/lib/mysql  \
-e MYSQL_DATABASE=jorgedb \
-e MYSQL_ROOT_PASSWORD=root  \
-p 5093:3306  \
--name  jorge_mariadb_2 \
--hostname jorgedb \
mariadb:10.1
echo "Creado contenedor de mariadb"

