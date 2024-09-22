# TRT Laravel Project

This project demonstrates the login and signup of the application, it detects if the username, email already exist in the database, it also detects the location of the current user for city and state purposes only

## Prerequisites

Before running the project, make sure you have the following installed:

- PHP 8.0 or higher
- Composer
- MySQL
- Node.js & npm
- Git

## Installation Steps

1. **Clone the repository**

   ```bash
   git clone https://github.com/JieZuos/TRT-Exam.git
   cd TRT-Exam

## env config
Use This as the Demo data for .env, it is not the best practice to show sensitive data but for this demo it will be ignored

APP_NAME=TRT
APP_ENV=local
APP_KEY=base64:M38+BE6zvYoVp89m5YmdcTlr6HZ9134LxUuDBN5IVJc=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trtexam
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=arjie.vicuna@gmail.com
MAIL_PASSWORD=unixrobucbxdopsl
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=arjie.vicuna@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

GOOGLE_API_KEY=AIzaSyByW_D3gVqTjImLe69HbTuq26gf0jQ8qsU

## Migration of the file
 To easilty create database and migrate the file it has already made a command to run both function at the same the

run this command

php artisan migrate:with-db

## Start the application

to start the application just do

php artisan serve 

enjoy testing the application and thank you for the opportunity
