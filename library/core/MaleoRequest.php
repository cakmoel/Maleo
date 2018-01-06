<?php
/**
 * Class MaleoRequest
 * Handling request
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version Beta
 * @since Since Release Beta
 */

class MaleoRequest
{
 /**
  * _registry data object
  * 
  * @var string
  */
 private $_registry;
 
 /**
  * _parameters pairs
  * 
  * @var array
  */
 private $_paramPairs = array();
 
 /**
  * _parameter string
  * 
  * @var string
  */
 private $_paramString;
 
 /**
  * Constructor
  * 
  * @param string $registry
  */
 public function __construct($registry)
 {
  $this->_registry = $registry;
 }
 
 /**
  * findURL
  * 
  * @param string $action
  * @param string $controller
  * @param array $params
  * @return string
  */
 public function findURL($action = null, $controller = null, $params = array())
 {
   if (is_null($controller)) $controller = $this->_registry->router->controller;
     
    $request = $controller . '/' . $action;
     
    if (!is_null($params)) {
         
     foreach ($params as $key => $value) {
         
      $this->_paramPairs[] = urlencode($value);
        
     }
      
     $this->_paramString = implode('/', $this->_paramPairs);
       
     $request .= '/'. $this->_paramString;
      
    }
     
    $request = APP_URL . '/' . trim($request, '/');
     
    return $request;
     
 }

 /**
  * findQuery
  *  
  * @param array $args
  * @param string $key
  * @return array|NULL|array
  */
 public function findQuery($args = array(), $key = null)
 {
    
  if (is_null($key)) {
    return $args;
  }
      
  return (count($args) > 0) ? $args[0]['url'] : null;
    
 }
 
 /**
  * findPostMethod
  * 
  * @param string $key
  * @param string $default
  * @return string|string|mixed
  */
 public function findPostMethod($key = null, $default = null)
 {
  if (is_null($key)) {
    return $_SERVER['REQUEST_METHOD'] = 'POST';
      
  }
    
  return (isset($_POST[$key])) ? filter_input(INPUT_POST, $key, FILTER_SANITIZE_URL) : $default;
    
 }
 
 /**
  * redirectURL
  * 
  * @param string $action
  * @param string $controller
  * @param array $params
  */
 public function redirectURL($action = null, $controller = null, $params = array())
 {
   $request = $this->findURL($action, $controller);
   header('location:'.$request);
   exit();
    
 }
  
}