# The Movie Server App

I found this [awesome tutorial](http://www.sitepoint.com/creating-crud-app-minutes-angulars-resource/) on using angular to connect to a RESTful service and make a CRUD application.  The creator said he even set up a server side application for anyone to test against while building the tutorial's applicaiton. But when I tried to do that, I was getting CORS errors. 

So, I created this php application, which can serve as the backend for the angular application that the tutorial walks through. This php application is not meant for production. It does no safety or sanity checking. It just takes the data entered, and saves it to a flat json file. The server has minimal setup, in favor of getting to the client side code as quickly as possible. 

## requirements

to run this application, you will need:

* php version 5.4 or greater
* composer - if not installed, get it here: [https://getcomposer.org/download/](https://getcomposer.org/download/)
* basic familiarity with the terminal.

## setup

Open the terminal, `cd` to this directory, and run `composer install` if you put composer in your path, or run `php composer.phar install` if you just have the phar downloaded to this directory.

This can take a couple minutes. When it's done, there will be a new folder in this directory called "vendor"

## running the server

In this directory, run `php -S localhost:8000 -t web` This will start the webserver. `control-c` to stop it.

With the webserver running, open a browser, and navigate to [http://localhost:8000/](http://localhost:8000/). You should a page that says "It Works!" and nothing else.

You can leave the webserver running while you do development. Updates will propogate automatically. (I included this disclaimer for developers who are accustomed to having to run a build command and restart their webserver. Everyone else can ignore this.)

## next steps

Head over to [http://www.sitepoint.com/creating-crud-app-minutes-angulars-resource/](http://www.sitepoint.com/creating-crud-app-minutes-angulars-resource/) and begin the tutorial. There are a couple modifications you will need to make it work within this environment. 

* The author's proposed directory structure has movieApp at the root. Instead, put everything that he has in that folder in the folder called web (where the index.html file is now). The web folder will be where you do all your client side code.
* In services.js, change the address from 'http://movieapp-sitepointdemos.rhcloud.com/api/movies/:id' to '/api/movies/:id'
