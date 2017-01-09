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

## Assignments
3. [Write an object oriented method in PHP that gives an overview of the sessions and the specialists and the anesthetists that are scheduled per OR.](https://github.com/lijupm/hotflow/blob/master/src/Hotflo/ORBundle/Controller/OperatingRoomController.php#L34)
4. [Write an object oriented method in PHP that gives an overview of the sessions and OR’s of a specific specialist.](https://github.com/lijupm/hotflow/blob/master/src/Hotflo/ORBundle/Controller/SpecialistController.php#L37)
5. [Write an object oriented method in PHP that checks if a specialists available in a certain timeslot. Do not write a query, but use the objects you have created.](https://github.com/lijupm/hotflow/blob/master/src/Hotflo/ORBundle/Controller/SpecialistController.php#L53)


## Some specific test scenarios
In the assignment description, few points are noted
* A hospital has 10 operatingrooms (OR’s).
* This hospital has 5 specialists in service that are scheduled to perform surgeries.
* It also has 5 anesthetists in service who sedate the patient at the beginning of the session.
* Specialists and anesthetists are limitedly available (some work 40 hours, others 32).

All these scenarios are handled by the service [CapacityManagerService](https://github.com/lijupm/hotflow/blob/master/src/Hotflo/ORBundle/Service/CapacityManagerService.php)

## How to test above scenarios
* A hospital has 10 operatingrooms (OR’s).

 To test this scenario, go to "Data Entry" >> "Operating Rooms" page. You can see there is already 8 ORs available. You can add 2 more to the list, but cannot more than that because the hospital's OR limit is set to 10. 

* This hospital has 5 specialists in service that are scheduled to perform surgeries.
 To test this scenario, go to "Data Entry" >> "Specialists" and try to add more than 5 specialists. You should get an error message

* It also has 5 anesthetists in service who sedate the patient at the beginning of the session.
To test this scenario, go to "Data Entry" >> "Anesthetists" and try to add more than 5 Anesthetists, you should get an error message. 

* Specialists and anesthetists are limitedly available (some work 40 hours, others 32).
To test this scenario, go to "Data Entry" >> "Sessions" page and go to 'Create new Session' page. Try to add Specialist "Adam" to a new Session. It should give an error message saying that he don't have any time left for the week. (For testing purpose, Adam's 'Availability per week' is set to 10
