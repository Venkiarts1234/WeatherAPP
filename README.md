# WeatherAPP

# SYMFONY WEATHER APP Symfony version 5.2
 
# Go to the project directory follow the instruction below

# clone the project repository
git clone https://github.com/Venkiarts1234/WeatherAPP.git

# Make sure you install composer on your system
# go to project directory run composer
composer install

# Create username is root and password is root to connect to mysql databse and configure username and password in .env
alter user 'root'@'localhost' identified with mysql_native_password by 'root';
DATABASE_URL=mysql://root:root@127.0.0.1:3306/weatherapi

# run following commands for the database migration
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Then start the server
symfony server:start





