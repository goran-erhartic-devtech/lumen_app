# LUMEN APP

How to setup the app:
1)  Clone this repo
2)  Navigate to the root of the project in console and run 'composer install' to install all dependencies
3)  Setup Homestead virtualbox, and sync the project folder - (do not forget to edit hosts file)
4)  Run 'vagrant up' command where you have setup the Homestead
5)  SSH into the Homestead box, and navigate to the root of the project - once there, run Migrations and Seeds to populate MySQL database

How to run the app:
1) After you have Homestead up and running, navigate your browser to the address you have provided in the hosts file
2) If everything has been properly setup, on the nome page you will be greeted with the type of environment (develop)

How to use the APIs:
1) Open Postman and try GET on '/employees' route - you will get an authorization error. In Postman's headers enter this Key/Value: login/yeah. This will allow you to trigger getAll() request and get all Employees
2) GET on route '/employee/{id}' will retrieve one employee by ID
3) POST on route '/employee' will allow you to create a new employee
4) PUT on route '/employee/{id}' will allow you to edit/update employee by ID
5) DELETE on route '/empoyee/{id}' will allow you to delete an employee by ID

| Parameter name | Type | Requried | Unique |
| ---------------|------|----------|--------|
| name | String | yes | yes |
| age | integer | yes | no |
| jmbg | integer (5) | yes | yes |
| project | String | no | no |
| department  | String | no | no |
| isActive | tinyInt | yes | no |