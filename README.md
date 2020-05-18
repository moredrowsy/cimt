# CIMT CERT Incident Management Tool

## Project install and setup

Install composer and npm dependencies and compile ui

```bash
composer install
npm install && npm run dev
```

## Setup mysql user and databse

```sql
CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON database_name.table_name TO 'newuser'@'localhost';
```

Setup database environment '.env' file at root with '.env.example' for db connection, db name, user, pass, etc.  
Configure MAIL_DRIVER and associated variables for email verification in .env file and config/mail.php

## Migrate and seed to database at /laravel6 root folder

```bash
php artisan migrate && php artisan db:seed
```

## Start the website

```bash
php artisan serve
```
