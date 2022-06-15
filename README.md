# project
Larave project for testing

## requirements

- PHP >= 7.3
- MySQL
- Composer

## Install project

run in terminal:
- ```git clone https://github.com/alikadv/project.git```
- ```cd project```
- ```composer install```
- ```cp .env.example .env``` Populate .env with your database credentials
- ```php artisan migrate --seed``` will populate the database with the sample data
- ```php artisan key:generate```
- ```php artisan serve```

## API Requests

- You can find sample requests in the postman export file: 
  project.postman_collection.json

