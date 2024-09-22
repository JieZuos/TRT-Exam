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
Use This as the Demo data for .env in .env-example, it is not the best practice to show sensitive data but for this demo it will be ignored, since it is a disposable api

## Migration of the file
 To easilty create database and migrate the file it has already made a command to run both function at the same the

run this command

php artisan migrate:with-db

## Start the application

to start the application just do

php artisan serve 

enjoy testing the application and thank you for the opportunity
