<?php 

require 'library/init.php';

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