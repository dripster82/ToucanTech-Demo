# ToucanTech Demo

## Setup
To setup and run this small application just follow these steps

 - Clone Repo to your local system
 - You will require mysql already installed
   Update the Confing/Database.php file to include your db settings user, password, db_schema, etc
 - Run `composer install`
 - Run `php spark migrate`
 - Run `php spark db:seed DemoData`
 
## Testing
  To run the unit tests 
 - Run `vendor/bin/phpunit`
 
  To see the app running
 - Run `php spark serve`
 - In your browser goto `http://localhost:8080`
 
