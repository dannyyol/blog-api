## Simple Blog API: Laravel 7.24 based Blog API

## How to install
* Clone the repository with git clone 
* Copy .env.example file to .env and edit database credentials there (Rename .env.example to .env) 
* Configure the new .env file like this 
    + DB_DATABASE={database name}
    + DB_USERNAME=root
    + DB_PASSWORD= 
* Run "composer install" 
* Run "php artisan key:generate" 
* Run "php artisan migrate --seed" or "php artisan db:seed" (it has some seeded data for testing) 

# Blog API Endpoints
## Post endpoints are below
* Read post endpoint http://127.0.0.1:8000/api/v1/posts/ - GET Method
* Create post endpoint http://127.0.0.1:8000/api/v1/post/ - POST Method
* Update post http://127.0.0.1:8000/api/v1/post/{id} - PUT Method
* Show a post http://127.0.0.1:8000/api/v1/post/{id} - GET Method
* Delete post http://127.0.0.1:8000/api/v1/post/{id} - DELETE Method

## Comment endpoints are below
* Read comment post endpoint http://127.0.0.1:8000/api/v1/comment/create/3 - GET Method
* Create comment endpoint http://127.0.0.1:8000/api/v1/comment/create/{post} - POST Method
* Update comment http://127.0.0.1:8000/api/v1/comment/{id} - PUT Method
* Delete comment http://127.0.0.1:8000/api/v1/comment/{id} - DELETE Method

## Category endpoints are below
* Read category post endpoint http://127.0.0.1:8000/api/v1/categories - GET Method
* create category endpoint http://127.0.0.1:8000/api/v1/category/ - POST Method
* update category endpoint http://127.0.0.1:8000/api/v1/category/{5} - PUT Method
* Delete category http://127.0.0.1:8000/api/v1/category/{5} - DELETE Method
