<?php

class Router
{
  private $_registry;
  private $_path;
  private $_args = [];
  private $_file;
  private $_error;
  
  public $route = [];
  public $controller;
  public $action;
  
  public function __construct($registry)
  {
   $this->_registry = $registry;
  }
  
  public function setPath($path)
  {
    try {
      
      if (!is_dir($path)) {
       
        throw new Exception("Invalid controller path: {$path}");
        
      }
      
      $this->_path = $path;
      
    } catch (Exception $e) {
        
      $this->_error = LogError::newMessage($e);
      $this->_error = LogError::customErrorMessage();
      
    }
    
  }
  
  public function loader()
  {
    // checking the controller
    $this->findController();
    
    if (!is_readable($this->_file)) {
        
      $this->_file = $this->_path . '/PageController.php';
      $this->controller = 'page';
      $this->action = 'notfound';
      
    }
    
    include $this->_file;
    
    $classController = $this->controller . 'Controller';
    $controller = new $classController($this->_registry);
    
    if (!is_callable(array($controller, $this->action))) {
        
       $action = 'index';
       
    } else {
        
       $action = $this->action;
       
    }
    
    // loading arguments for action
    $i = 0;
    foreach ($this->route as $key => $value) {
        
      if ($key > 1) {
         
        $this->_args[$this->route[$key -1]] = $value;
        $i++;
        
      }
      
    }
    
    if ($i > 1) {
       
       call_user_func(array($controller, $action), $this->args);
       
    } else {
        
       call_user_func_array(array($controller, $action), $this->args);
       
    }
    
  }
  
  private function findController()
  {
    $requestURL = rtrim(filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL), '/');
    $route =  (empty($requestURL)) ? 'index' : $requestURL;
    $this->route = explode('/', $route);
    $this->controller = (isset($this->route[0])) ? $this->route[0] : 'index';
    $this->action = (isset($this->route[1])) ? $this->route[1] : 'index';
    $this->_file = $this->_path . '/' . ucfirst($this->controller) . 'Controller.php';
      
  }
  
}