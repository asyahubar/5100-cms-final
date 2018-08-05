<?php

/*
 * api routes
 */
$router->get('recipes', 'ApiController@recipes');
$router->get('recipe/{id}', 'ApiController@recipe');
$router->get('ingredient/{title}', 'ApiController@ingredient');

/*
 * website routes
 */
// authentication
$router->get('register', 'Authenticate@register');
$router->get('login', 'Authenticate@login');
$router->get('logout', 'Authenticate@logout', true);
$router->post('createuser', 'Authenticate@createuser');
$router->post('validate', 'Authenticate@validate');

// browse
$router->get('', 'PagesController@home');
$router->get('create', 'PagesController@create', true);
$router->get('edit', 'PagesController@edit', true);
$router->get('update/{id}', 'PagesController@update', true);
$router->get('delete', 'PagesController@destroy', true);
