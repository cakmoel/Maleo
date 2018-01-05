<?php
/**
 * init.php
 * Autoloading classes in library folder
 * Reference:
 * https://gist.github.com/jwage/221634
 * https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
 * http://blog.montmere.com/2011/09/21/psr-0-final-proposal/
 * http://php.net/manual/en/function.spl-autoload-register.php
 * http://php.net/manual/en/language.namespaces.rationale.php
 * 
 */

if (version_compare(PHP_VERSION, '5.4', '>=')) {
    
  if (version_compare(PHP_VERSION, '5.6', '>=')) {
        
  spl_autoload_register(function ($className){

   $fileName = '';
   $namespace = '';
       
   $directories = array('core', 'db', 'helper');
   
   foreach ($directories as $dir) {
       
    $includePath = APP_SYSPATH . APP_LIB . DS . $dir;
    if (false !== ($lastNsPos = strripos($className, '\\'))) {
           
       $namespace = substr($className, 0, $lastNsPos);
       $className = substr($className, $lastNsPos + 1);
       $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
           
    }
       
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $fullFileName =  $includePath . DIRECTORY_SEPARATOR . $fileName;
    
    if (file_exists($fullFileName)) {
        require $fullFileName;
        return true;
    } 
       
   }
      
   return false;
       
    });
            
  }
    
} else {
    
    trigger_error("Your PHP version is not supported!");
    
}



/*
// register loader classes needed on application directory and set cache directory
Autoloader::setCacheFilePath(APP_SYSPATH . APP_PATH . DS . 'cache/cache.txt');
Autoloader::setClassPaths(array(
    APP_SYSPATH . APP_PATH . DS . 'controllers/',
    APP_SYSPATH . APP_PATH . DS . 'models/',
));

Autoloader::register();
*/
