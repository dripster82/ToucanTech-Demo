# ToucanTech Demo

## Setup
To setup and run this small application just follow these steps

 - Clone Repo to your local system
 - Update the Confing/Database.php file to includ your db settings
 - Run `composer install`
 - Run `php spark migrate`
 - Run `php spark db:seed DemoData`
 
## Testing
  To run the unit tests 
 - Run `vendor/bin/phpunit`
 
  To see the app running
 - Run `php spark serve`
 - In your browser goto `http://localhost:8080`
 
