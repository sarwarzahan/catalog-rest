# This is a REST Api implementation using Symfony 3.4, MySql database and Docker for deployment

## Installation Steps
----------------------
- Install Docker and Docker Compose (https://www.docker.com/community-edition).
- Install php 7.0 and composer (https://getcomposer.org/) to run command-line tools from host machine.
- Now run **docker-compose up** in your project root folder.
- Now get the ip of MySql database container to configure in Symfony. Run the command in root folder: **docker inspect symfony-mysql | grep '"IPAddress"'**
- Now inside Symfony project folder (catalog-rest) run: **composer install** . Keep all the default settings except **'database_host'**. Use the ip of mysql container in **'database_host'** value

## Create Tables, load DataFixures and run Test
-------------------------------------------------
- To create database tables, run inside Symfony project folder (catalog-rest): **php bin/console doctrine:schema:update --force**
- To load DataFixures, run inside Symfony project folder (catalog-rest): **php bin/console doctrine:fixtures:load**
- To run test (There is a known issue, check known issues section), run inside Symfony project folder (catalog-rest): **php bin/console kahlan:run**

## Generate the SSH keys for API authentication. Required for **lexik/jwt-authentication-bundle bundle**
- Run inside Symfony project folder (catalog-rest): **mkdir var/jwt**
- Then: **openssl genrsa -out var/jwt/private.pem -aes256 4096**
- Use key password 1234, you can choose anything, but then you have set the password value to **jwt_key_pass_phrase** in **app/config/parameters.yml**
- Then: **openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem**

## Test the REST API
----------------------------
- Use any tool like **Postman** or **curl**
- To access the api documentation, browse **http://localhost:8000/doc**
- Authentication is not required for **GET** operations. 
- The following tips are for **Postman** tool. To authenticate: request type- **POST**, url- **localhost:8000/login**, Headers- **Content-Type application/json**,
**Body (example)**- {
    "username": "betty",
    "password": "betty123"
}
- After SEND the request and you will get response a like: 
{
    "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJiZXR0eSIsImlhdCI6MTUxOTk1MzY2MiwiZXhwIjoxNTIwMDQwMDYyfQ.Rrg4kr2qvoYmDeLh4HJbMJuwAglFa79L2vzaMOthQJwEGhUcsOZYKg_HsParjRU8SjVXR1IquxbPZmc6oUtW9awUXu-dG7aUyL1_6MPApSgElgJAKQH_Aae9i15yNelVgNQLJ4q-3hOiPweiQn9kdBMtjpfGRym0kglrOx-8guBeotuzZZubKJT6r1NEaM_aICT-SOCK37hRLBHn9Uc1nhaASGGbJiFKGyBBvMh40ltCc5LLAyfo1tFgJbFADxtYrIJWLwqK6os3S_rbDAlLDhwrlLNSv6Xzf-HmXwGnlnnJtTXT4xymgKdTNiPGQ7ls_JNX1YKfo47WT08O-R8Fwz5L92TkqSxcqQHHvfBjw5qMEWVt-BW7R6nsbgNnuyIBSiV2O5kBHqcZQXX4IJrbt054LZddigc72hvwsIPhtZESKmxhBIAlxPiJRhPNVfo3CtkazWOj6wIzZ_Lwa5PY2CAPe3uAnufad_mnV7X6HF9jo37TzfCgxtL7GVmiBab4t0JH65xt0RulV5Br62cSfAshUbHnK55ErTQUiASfEPnLg4n6hEDByqO63ejGY0-WRBcpPT8gwv3QR1BMYiaPMctk7J6_2XW2SMaBR-4R_6H9jDh2kIEKd_Lamlov5Kt4G52h2NOpo8S4npKyUl5AS-b-4BsWOgAjevnIoI6MHVY"
}

- Now use the value of token to request for POST, PATCH, DELETE operation. For example in Postman to create product: request type- **POST**, url- **localhost:8000/product/create**, Headers- **Content-Type application/json**,
**Authorization Bearer use_token_value**,
**Body (example)**- {
    "name": "test12",
    "category": "2",
    "sku": "A000adc",
    "price": "10.55",
    "quantity": "17"
}

- To update product: request type- **PATCH**, url- **localhost:8000/product/update/{product_id}**, Headers- **Content-Type application/json**,
**Authorization Bearer use_token_value**,
**Body (example)**- {
    "name": "test12",
    "category": "2",
    "sku": "A000adc",
    "price": "10.55",
    "quantity": "17"
}

- To delete product: request type- **DELETE**, url- **localhost:8000/product/delete/{product_id}**, Headers- **Content-Type application/json**,
**Authorization Bearer use_token_value**,
**Body (example)**- Nothing

- To get a product: request type- **GET**, url- **localhost:8000/products/{product_id}**
- To get list of products: request type- **GET**, url- **localhost:8000/products**
- To get list of categories: request type- **GET**, url- **localhost:8000/categories**

## Known Issues
----------------------------
- Running the test after first time shows "Compile Error: Cannot declare class Doctrine\Common\Annotations\Annotation\Target" or similar Doctrine issues. 
It's happening due to invalid cache or some bug in PHP opcache. Deleting all files from "var/cache/dev" directory solves it. You have to delete every 
time you run kahlan test.

- Sometimes doctrine cache throws 500 error. Run the command : php bin/console cache:clear --env=prod , If that does not solve the problem delete
all files from "var/cache/prod" directory.

## Extra Tips
-----------------
- If you need to login in Docker container, use the following command: **docker exec -it symfony-webserver /bin/sh** 