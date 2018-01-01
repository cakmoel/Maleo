<?php 

require 'lib/init.php';

Autoloader::setCacheFilePath(APP_SYSPATH . APP_LOG . DS . 'cache.txt');
Autoloader::setClassPaths(array(
    APP_SYSPATH . APP_CONTROLLERS . DS, 
    APP_SYSPATH . APP_MODELS . DS,
));

Autoloader::register();

$registry = new Registry();

$registry->request = new Request($registry);

$registry->db = $dbAdapter;

$registry->view = new View($registry);

$registry->view->setPath(APP_SYSPATH . APP_VIEWS);

$registry->router = new Router($registry);

$registry->router->setPath(APP_SYSPATH . APP_CONTROLLERS);

$registry->router->loader();