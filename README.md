# Food Reservation System

A food reservation system using laravel with docker‌!


## Design & Prototype
there is admin and other users
admin can define many foods for weekdays 
and users can login and reserve a food per day
users are created by admin and admin can delete them, create food or edit them.
admin can also login to user page by their username only!

## pages and passwords :
the login page is the root ( /login )
users can use their username and password to log in
or they can use "forgot password" to set the new passsword ( the default new password is "firtsname + lastname" )
and also admin can login using "admin panel" button
the admin default username and password is ("admin","1234") you can change it in src/app/http/controllers/adminlogincontroller.php
admin dashboard page has four button :
- exit : to get back to login page
- Update foods : to creat or delete foods
- Login By Username : to login to user page with username
- Add/Delete User : for make or destroying users



### How database works :
this project use the SQLITE for database
it has three tables:
- users : it keeps the users details
- foods : it keeps the food detail that admin define on any day
- reservation : it keeps any reservation details ( for each user and food and day)




## try it :
to try this web app, after installing Docker, you need to clone this repository and build the container using this command :
docker-compose up 
you can use "-d" flag to run it at backgroung
then you open the browser and search 
http://localhost:8888/login
this is the root of the project !
