<?php 

include 'library/setting.php';

Autoloader::setCacheFilePath(APP_SYSPATH . APP_PATH . DS . 'cache/cache.txt');
Autoloader::setClassPaths(array(
    APP_SYSPATH . APP_PATH . DS . 'controllers/',
    APP_SYSPATH . APP_PATH . DS . 'models/',
    APP_SYSPATH . APP_LIB . DS . 'core/',
    APP_SYSPATH . APP_LIB . DS . 'db/',
    APP_SYSPATH . APP_LIB . DS . 'helper/',
));

Autoloader::register();

// declare registry object
$registry = new MaleoRegistry();

// load the request
$registry->request = new MaleoRequest($registry);

// database registry object
$registry->db = MaleoDatabaseFactory::dbInit(ADAPTER_TYPE, array(DB_CONNECTION, DB_USR, DB_PWD));

// load up the view
$registry->view = new MaleoView($registry);

// set the view path
$registry->view->setPath(APP_SYSPATH . APP_PATH . DS . 'views');

// load the router
$registry->router = new MaleoRouter($registry);

// set the controller path
$registry->router->setPath(APP_SYSPATH . APP_PATH . DS . 'controllers');

// load the controller 
$registry->router->loader();
