# WeatherAPP

## Getting Started

These instructions will give you a copy of the project up and running on
your local machine for development and testing purposes.

### Prerequisites

Requirements for the software and other tools to build, test and push 
- php 7.2 and above
- mysql 5.7 and above
- composer

### Installing

A step by step series of examples that tell you how to get a development
environment running

Clone the project repository

    git clone https://github.com/Venkiarts1234/WeatherAPP.git

Go to the project directory follow the instruction below

    cd WeatherAPP/


Make sure you install composer on your system

    composer install

Create username is root and password is root to connect to mysql databse and configure username and password in .env

Checks if the best practices and the right coding style has been used.

    alter user 'root'@'localhost' identified with mysql_native_password by 'root';
   
Run following commands for the database migration

    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
   
Then start the server

    symfony server:start
   
Symfony runs on http://127.0.0.1:8000

Thank you

