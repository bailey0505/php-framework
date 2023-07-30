# Bailey's PHP Framework
> Custom MVP, CRUD PHP Framework. Primarily designed for fast, secure development without reliance on composer


## General Overview
- The template engine in use is twig. 
- Classes can utilize the CRUD module. (refer to admin user class).
- The App class is where you can set default values for you app. This class also has a lot of useful functions. Only static functions should be added to it
- default.php controller will handle your login and reset password pages as well as act as a fall back for requests that we did not prepare for.
- When cloning you should rename .gitignore.sample to .gitignore before initial commit

## Admin Interface
- The Admin interface is the pro version of https://demo.adminkit.io/
- To view inside of your project you can go to app/Modules/adminkit-pro/static/
- Before moving app to production that link should either be part of git ignore and or use htaccess to block access


## Routes
- Inside of routes you will have web and api. all requests that do not have /api/ with default to web

## Public
- Public will hold all of your views as well as all of your assets 
- The views directory is split up into partials, pages and bases
- Inside of your pages directory you should have folder names that reside with the auth levels. 


## Dev
- You will have a database and configuration folders inside of here as well as anything that you deem important(maybe a scripts directory)
- Inside of database you will find initial-design. It is recommended that you run these migrations at the start of the project(updating user insert to your details)


## App 
- This is where the meat of the application is. 
- You have Ajax and Post folders. These should be where all those files are stored
- The controllers folder is where all your controllers will live. Same as pages you need folder names that reside with auth level
- Library Is where all of your classes will live
- Modules are any third party or self made packages will live