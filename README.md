# The Movie Server App

I found this [awesome tutorial](http://www.sitepoint.com/creating-crud-app-minutes-angulars-resource/) showing how to use angular to make a CRUD client with angular.  The creator said he even set up a server side application for anyone to test against while building the tutorial's applicaiton. But when I tried to do that, I was getting CORS errors. 

So, I created this php application, which can serve as the backend for the angular application, which the tutorial walks through. This php application is not meant for production. It does no safety or sanity checking. It just takes the data entered, and saves it to a flat json file. I did it this way, so that there would be minimal setup, in favor of getting to the client side code as quickly as possible.

## requirements

to run this application, you will need:

* php version 5.4 or greater
* composer - if not installed, get it here: [https://getcomposer.org/download/](https://getcomposer.org/download/)
* basic familiarity with the terminal.

## setup

Open the terminal, `cd` to this directory, and run `composer install`

This can take a couple minutes. When it's done, there will be a new folder in this directory called "vendor"

## running the server

In this directory, run `php -S localhost:8000 -t web` This will start the webserver. `control-c` to stop it.

Now, open a browser, and navigate to (http://localhost:8000/)[http://localhost:8000/]. You should a page that says "It Works!" and nothing else.

## next steps

Head over to [http://www.sitepoint.com/creating-crud-app-minutes-angulars-resource/](http://www.sitepoint.com/creating-crud-app-minutes-angulars-resource/) and begin the tutorial. There are a couple modifications you will need to make it work within this environment. 

* The author's proposed directory structure has movieApp at the root. Instead, put everything that he has in that folder in the folder called web (where the index.html file is now). The web folder will be where you do all your client side code.
* In services.js, change the address from 'http://movieapp-sitepointdemos.rhcloud.com/api/movies/:id' to '/api/movies/:id'
