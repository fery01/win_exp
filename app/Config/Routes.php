<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', function () {
    return view('folder_view'); 
});

$routes->get('/folders', 'Folder::getAllFolders');  
$routes->get('/subfolders/(:num)', 'Folder::getSubfolders/$1');  