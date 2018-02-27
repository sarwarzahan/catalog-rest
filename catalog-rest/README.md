Install Docker and Docker Compose

First run in project folder: docker-compose up

get the ip of mysql container to connect from symfony:

docker inspect symfony-mysql | grep '"IPAddress"'

Install composer globally. Now in project folder run: 

composer install

use all the default settings except 'database_host'

use the ip of mysql container in 'database_host' value