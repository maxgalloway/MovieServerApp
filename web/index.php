<?php
/**
This is the RESTful service that powers the Movie Application

Copyright 2015 Max Galloway

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

//	A helper application for fetching movies in the data store.
//	If the movie with the specified id exists, return its index
//  in the datastore. Otherwise, return null.
$app['getIndexOfMovieById']	=	$app->protect(function ($id) use ($app) {
	if (isset($app->movieData) && is_array($app->movieData)) {
		foreach ($app->movieData as $index => $movie) {
			if ($movie->_id === $id) {
				return $index;
			}
		}
	}
	
	return null;
});

//	An init function, which is run before the other methods in 
//  this service. 
//	Loads the datastore from a file, into the application container
//	for the other request-handling methods to use.
$app->before(function (Request $request, Silex\Application $app) {
	$fileData = @file_get_contents('data.json');
	if ($fileData !== false) {
		$jsonData = json_decode($fileData);
		
		if (isset($jsonData)) {
			$app->movieData = $jsonData;
			return;
		}
	}
	
	$app->movieData = [];
	return;
});

//	Default index action -- return index.html
$app->get('/', function () {
	return file_get_contents('index.html');
});

//	Return movie with given id, or a 404
$app->get('/api/movies/{id}', function (Silex\Application $app, $id) {
	$i = $app['getIndexOfMovieById']($id);
	
	if (isset($i, $app->movieData[$i])) {
		return new JsonResponse($app->movieData[$i]);
	} else {
		return new Response(null, 404);
	}	
});

//	Return all movies
$app->get('/api/movies', function (Silex\Application $app) {
	return new JsonResponse($app->movieData);
});

// Create a new movie
$app->post('/api/movies', function (Silex\Application $app, Request $request) {
	$nextId = uniqid();
	
	$blankMovie = [	
		'director'		=>	"movie $nextId's director",
		'genre'			=>	"movie $nextId's genre",
		'releaseYear'	=>	"movie $nextId's releaseYear",
		'title'			=>	"movie $nextId's title"
	];
	
	$postedMovie = json_decode($request->getContent(), true);
	
	$newMovie = array_merge($blankMovie, $postedMovie);
	$newMovie['__v'] 	=	0;
	$newMovie['_id']	=	$nextId;	
	$app->movieData[]	=	$newMovie;
	
	file_put_contents('data.json', json_encode($app->movieData));
	
	return new JsonResponse(['message' => "movie $nextId added"], 201);
});

//	Update existing movie
$app->put('/api/movies/{id}', function (Silex\Application $app, Request $request, $id) {
	$i = $app['getIndexOfMovieById']($id);
	
	if (isset($i, $app->movieData[$i])) {
		
		$blankMovie = [
			'director'		=>	$app->movieData[$i]->director,
			'genre'			=>	$app->movieData[$i]->genre,
			'releaseYear'	=>	$app->movieData[$i]->releaseYear,
			'title'			=>	$app->movieData[$i]->title
		];
		
		$postedMovie = json_decode($request->getContent(), true);
		
		$newMovie = array_merge($blankMovie, $postedMovie);
		$newMovie['__v'] 	=	0;
		$newMovie['_id']	=	$id;
		
		$app->movieData[$i]	=	$newMovie;
		
		file_put_contents('data.json', json_encode($app->movieData));
		
		return new JsonResponse($app->movieData[$i]);
		
	} else {
		return new Response(null, 404);
	}
});

//	Delete movie with given id.
$app->delete('/api/movies/{id}', function (Silex\Application $app, $id) {
	$i = $app['getIndexOfMovieById']($id);

	if (isset($i, $app->movieData[$i])) {
		array_splice($app->movieData,$i,1);
		file_put_contents('data.json', json_encode($app->movieData));
		return new JsonResponse($app->movieData[$i]);
	} else {
		return new Response(null, 404);
	}
});

$app->run();
