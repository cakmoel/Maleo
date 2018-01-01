<?php

require 'config.php';
include 'Autoloader.php';
include 'utilities.php';

if (version_compare(PHP_VERSION, '5.4', '>=')) {
    
  if (version_compare(PHP_VERSION, '5.6', '>=')) {
        
    spl_autoload_register(function ($class){
            
       $directories = ['core/', 'db/', 'provider/'];
            
       foreach ($directories as $dir) {
                
         if (is_readable(APP_SYSPATH . APP_LIB . DS . $dir . $class . '.php')) {
            include APP_SYSPATH . APP_LIB . DS . $dir . $class . '.php';
            return true;
         }
               
       }
            
       return false;
            
    });
            
  }
    
} else {
    
    trigger_error("Your PHP version is not supported!");
    
}

$dbAdapter = DbAdapterFactory::dbInit(ADAPTER_TYPE, array(DB_CONNECTION, DB_USR, DB_PWD));