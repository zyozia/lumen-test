# Lumen PHP Framework

## Requirements

* PHP >= 8.0
* PHP >= 8.0
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Pgsql PHP Extension

## Installation

##### 1. Clone & install
```bash
git clone git@****LumenTest.git
cd LumenTest
composer install
```
##### 2. Configure `.env`

* Copy **.env.example** in a bash `cp .env.example .env` or in an other terminal `php -r "file_exists('.env') || copy('.env.example', '.env');"`
* Configure the **.env** to your needs


##### 3. Create database and Configuration of the .env file
```bash
# Database
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=postgres

#Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username
MAIL_PASSWORD=password
MAIL_ENCRYPTION=null
```
##### 4. Run migrations
```bash
php artisan migrate
```

## Run server
###### With PHP Server
```bash
php -S localhost:8000 -t public
```

###### With Apache/Nginx

Configure your server to look for `index.php` into project `/public` folder

## Documentation
###### Framework documentation - [here](https://lumen.laravel.com/docs/9.x)
###### Api documentation - [here](https://documenter.getpostman.com/view/1899601/UyxkjQye)
###### Postman json collection - [here](https://www.getpostman.com/collections/5bcc35f52808b2ed8bda)
