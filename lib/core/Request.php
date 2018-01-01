<?php
/**
 * Class Request
 * Handling request
 * @author maoelana
 *
 */
class Request
{
  private $_registry;
  private $_paramPairs = array();
  private $_paramString;
  
  public function __construct($registry)
  {
    $this->_registry = $registry;
  }
  
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

  public function findQuery($args, $key = null)
  {
    if (is_null($key)) {
      return $args;
    }
      
    return (count($args) > 0) ? $args[0]['url'] : null;
    
  }
  
  public function findPostRequestMethod($key = null, $default = null)
  {
    if (is_null($key)) {
        
      return $_SERVER['REQUEST_METHOD'] = 'POST';
      
    }
    
    return (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST[$key]) ? filter_input(INPUT_POST, $key) : $default;
    
  }
  
  public function redirectURL($action = null, $controller = null, $params = array())
  {
    
    $request = $this->findURL($action, $controller);
    header('location:'.$request);
    exit();
    
  }
  
}