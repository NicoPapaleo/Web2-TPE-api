<?php
require_once 'config.php';
require_once 'libs/router.php';
require_once 'app/controllers/CancionesApiController.php';
require_once './app/controllers/albums.api.controller.php';


$router = new Router();

//                  ENDPOINT        VERBO           CONTROLLER              METODO 
$router->addRoute('canciones',      'GET',      'CancionesApiController',   'getCanciones');
$router->addRoute('canciones',      'POST',     'CancionesApiController',   'addCancion');
$router->addRoute('canciones/:ID',  'GET',      'CancionesApiController',   'getCanciones');
$router->addRoute('canciones/:ID',  'DELETE',   'CancionesApiController',   'deleteCancion');
$router->addRoute('canciones/:ID',  'PUT',      'CancionesApiController',   'updateCancion');
$router->addRoute('canciones/:ID/:subrecurso',  'GET',      'CancionesApiController',   'getCanciones');

$router->addRoute('albums',         'GET',      'AlbumApiController',       'get'   ); # TaskApiController->get($params)
$router->addRoute('albums',         'POST',     'AlbumApiController',       'create');
$router->addRoute('albums/:ID',     'GET',      'AlbumApiController',       'get'   );
$router->addRoute('albums/:ID',     'DELETE',   'AlbumApiController',       'delete');
$router->addRoute('albums/:ID',     'PUT',      'AlbumApiController',       'update');
$router->addRoute('albums/:ID/:subrecurso', 'GET',    'AlbumApiController', 'get'   );

$router->route($_GET['resource'] , $_SERVER['REQUEST_METHOD']);
