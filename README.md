# ToucanTech Demo
## Project Description
This has been created as part of the coding challenge for ToucanTech.

With it beeing a while since I have done any php using a MVC framework (cakePHP - 2011, Magento - 2017). I decided to take this opportunity to learn a new MVC framework (CodeIgnitor 4). I have seen bits of CodeIgnitor before, but never actually created a project from scratch myself.

I set a timeline of no more than 16-20hrs of actual coding time.

## Setup
To setup and run this small application just follow these steps:
This assumes you already have mysql installed with a user and db_schema already created

 1. Clone Repo to your local system
 2. Update the Confing/Database.php file to include your db settings user, password, db_schema, etc
 3. Run `composer install`
 4. Run `php spark migrate`
 5. Run `php spark db:seed DemoData`
 
## Testing
  To run the unit tests 
 - Run `vendor/bin/phpunit`
 
  To see the app running
 - Run `php spark serve`
 - In your browser goto `http://localhost:8080`
 
## Retrospective
After completing the challenge I was happy with want was accomplished in the time.

I would have prefered to do a few things differently (as pointed out in the "Didn't Go Well" section below), which now having a better understanding of the CodeIgnitor I would be able to achieve.


### Went Well
 - It was functional and met the challenge requirements.
 - Test coverage for all the backend work I had been done.
 - Was fun learning a new framework

### Didn't Go Well
 - Didn't get chance to add tests for the frontend functionality
 - Controllers were bloated and would have benefited with alot of the logic being moved out to a seperate service classes
 - No Mocking of data was done for testing - relied on seeded data only
 - Ran out of time to find a way to properly test the csv export controller.
 - JS would have benefitied from being more OOP based.
 - Lack of Comments (After working in the world or Ruby where comments are discouraged over the use of descriptive method names. I have gotten out of the habit and need to get back into it)
 
### What was Learned
 - A new framework
 - Creating the services earlier on would have avoid the contined bloat in the Controllers
 - Again staring the JS in OOP rather than just leaving it to refactor it later
