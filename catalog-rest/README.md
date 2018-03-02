
Install Docker and Docker Compose

First run in project folder: docker-compose up

get the ip of mysql container to connect from symfony:

docker inspect symfony-mysql | grep '"IPAddress"'

Install composer globally. Now in project folder run: 

composer install

use all the default settings except 'database_host'

use the ip of mysql container in 'database_host' value


Login to a container: docker exec -it symfony-webserver /bin/sh

php bin/console doctrine:fixtures:load

php bin/console doctrine:schema:update --force

Facing issues;

Compile Error: Cannot declare class Doctrine\Common\Annotations\Annotation\Target, because the name is already in use or similar 
error. It's happening due to invalid cache or some bug in PHP opcache

solution: delete all files from var/cache/dev directory