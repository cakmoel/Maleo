<?php
/**
 * Class MaleoRouter
 * setting controller path
 * handling routes to load the controller
 * 
 * @author Maleo developer community
 * @copyright contributors
 * @license MIT
 * @version Beta
 * @since Since Release Beta
 */

class MaleoRouter
{
/**
 * Registry Object
 * 
 * @var string
 */
private $_registry;

/**
 * Controller path
 *  
 * @var string
 */
private $_path;

/**
 * Controller arguments
 * 
 * @var array
 */
private $_args = array();

/**
 * a file targeted by route
 * 
 * @var string
 */
private $_file;

/**
 * Error
 *  
 * @var string
 */
private $_error;

/**
 * Route
 * 
 * @var array
 */
public $route = array();

/**
 * Controller
 * 
 * @var string
 */
public $controller;

/**
 * action
 *  
 * @var string
 */
public $action;

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
 * Set controller path
 * 
 * @param string $path
 * @throws Exception
 */
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

/**
 * Handling routes to load the controller
 * 
 * @access public
 */
public function loader()
{
  // checking the controller
 $this->findController();
    
 if (!is_readable($this->_file)) {
    
    $this->_file = $this->_path.'/PageController.php';
    $this->controller = 'page';
    // 404
    $this->action = 'notfound';
      
  }
  
  // include file controller
  include $this->_file;
    
  $class = $this->controller . 'Controller';
  $controller = new $class($this->_registry);
    
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
       
   call_user_func(array($controller, $action), $this->_args);
       
  } else {
        
   call_user_func_array(array($controller, $action), $this->_args);
       
  }
    
}

/**
 * Checking the controller
 * 
 * @access private
 */
private function findController()
{
  $requestURL = rtrim(filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL), '/');
  $route =  (empty($requestURL)) ? 'index' : $requestURL;
  $this->route = explode('/', $route);
  
  $this->controller = (isset($this->route[0])) ? $this->route[0] : 'index';
  $this->action = (isset($this->route[1])) ? $this->route[1] : 'index';
  // set the controller path
  $this->_file = $this->_path . '/' . ucfirst($this->controller) . 'Controller.php'; 
  
}
  
}