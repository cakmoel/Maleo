<?php
namespace Maleo\core;

use Exception;

use Maleo\helper\LogError;

/**
 * class MaleoView
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version 1.0 
 * @since Since Release 1.0
 */

class MaleoView
{
 /**
  * registry data object
  * 
  * @var string
  */
 private $_registry;
 
 /**
  * variables
  * 
  * @var array
  */
 private $_vars = array();
 
 /**
  * view's path
  * 
  * @var string
  */
 private $_path;
 
 /**
  * _norender
  * 
  * @var string
  */
 private $_norender = false;
 
 /**
  * error
  * 
  * @var string
  */
 protected $error;
 
 /**
  * constructor
  * 
  * @param string $registry
  */
 public function __construct($registry)
 {
   $this->_registry = $registry;
 }
 
 /**
  * magic method __set
  * 
  * @param string $key
  * @param string $value
  */
 public function __set($key, $value)
 {
   $this->_vars[$key] = $value;
 }
 
 /**
  * set view path
  * 
  * @param string $path
  * @throws Exception
  */
 public function setPath($path)
 {
  try {
      
    if (!is_dir($path)) {
        
       throw new Exception("Invalid view path: {$path}");
       
    } 
    
    $this->_path = $path;
    
  } catch (Exception $e) {
      
    $this->error = LogError::newMessage($e);
    $this->error = LogError::customErrorMessage();
    
  }
  
 }
 
 /**
  * load view file
  * 
  * @param string $file
  */
 public function load($file)
 {
   foreach ($this->_vars as $key => $value) {
       $$key = $value;
   }
   
   include $this->_path . '/' . $file;
   
 }
 
 /**
  * setNoRender
  * 
  * @param boolean $norender
  */
 public function setNoRender($norender = true)
 {
  $this->_norender = $norender;
 }
 
 /**
  * Dispatch
  * 
  * @throws Exception
  * @return void|boolean
  */
 public function dispatch()
 {
  try {
      
    if ($this->_norender) return;
    
    foreach ($this->_vars as $key => $value) {
        $$key = $value;
    }
    
    $output = $this->_path .'/'. $this->_registry->router->controller .'/'. $this->_registry->router->action . '.php';
    if (!is_readable($output)) {
        
        throw new Exception("View not found in {$output}");
        return false;
        
    }
    
    include($output);
    
  } catch (Exception $e) {
      
     $this->error = LogError::newMessage($e);
     $this->error = LogError::customErrorMessage();
     
  }
  
 }
 
}