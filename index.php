<?php 

require 'library/init.php';

Autoloader::setCacheFilePath(APP_SYSPATH . APP_LIB . DS . 'cache/cache.txt');
Autoloader::setClassPaths(array(
    APP_SYSPATH . APP_PATH . DS . 'controllers/', 
    APP_SYSPATH . APP_PATH . DS . 'models/',
));

Autoloader::register();

// declare registry object
$registry = new Registry();

// load the request
$registry->request = new Request($registry);

// database registry object
$registry->db = $dbAdapter;

// load up the view
$registry->view = new View($registry);

// set the view path
$registry->view->setPath(APP_SYSPATH . APP_PATH . '/views');

// load the router
$registry->router = new Router($registry);

// set the controller path
$registry->router->setPath(APP_SYSPATH . APP_PATH . '/controllers');

// load the controller 
$registry->router->loader();