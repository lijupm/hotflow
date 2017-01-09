# Hotflo Assessment

This application is done as part of Hotflo recruitment process

## Installation

To install the application locally, please follow the steps given below

1. <code>git clone https://github.com/lijupm/hotflow.git</code>
2. <code>cd hotflow</code>
(Make sure that you configure a site that points to the above directory)
3. <code>composer install</code>
4. <code>bin/console doctrine:schema:update --force</code>
5. <code>bin/console assetic:dump</code>
6. <code>bin/console assetic:dump --env=prod</code>
7. <code>bin/console cache:clear</code>
8. <code>bin/console cache:clear --env=prod</code>
9. <code>chmod 777 -R var/cache var/logs</code>

## Load Test data
To pre-load some test data to your application, run the following command

1. <code>bin/console doctrine:fixtures:load</code>

That's it! Now you should be able to view the application home page. 
![Alt text](/web/images/homepage.png?raw=true "Home page")

## ER Diagram
ER diagram of the application is given below
![Alt text](/web/images/er_diagram.png?raw=true "ER Diagram")

## Application Entities
Here are some entities used in the application
![Alt text](/web/images/entities.png?raw=true "Home page")
