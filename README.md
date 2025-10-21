# Food Reservation System

A simple **food reservation system** using **laravel** with **docker**!


---
## Features
There is **admin** and other **users**
admin can define many foods for weekdays 
and users can login and reserve a food per day
users are created by admin and admin can delete them, create food or edit them.
admin can also login to user page by their username only!

## Usage :
The login page is the root ( /login )
users can use their username and password to log in
or they can use **"forgot password" **which resets it to  
  → `firstname + lastname`
and also admin can login using **"admin panel"** button
the admin default username and password is ("admin","1234") you can change it in src/app/http/controllers/adminlogincontroller.php
admin dashboard page has four button :
- exit : to get back to login page
- Update foods : to create or delete foods
- Login By Username : to login to user page with username
- Add/Delete User : for make or destroying users



### How database works :
This project use the **SQLITE** for database  ( can be changed in .env )
it has three tables:
- users : it keeps the users details
- foods : it keeps the food detail that admin define on any day
- reservation : it keeps any reservation details ( for each user and food and day)


---

## Instalation :
To try this web app, after installing Docker, you need to clone this repository and build the container using these commands:  
'''bash
git clone https://github.com/ParsaHmi/Food-Reservation-System.git'
'cd food-reservation'

you can use "-d" flag to run it at background  
then you open the browser and search  
http://localhost:8888/login  
this is the root of the project !
