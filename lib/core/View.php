<?php
/**
 * class View
 * @author maoelana
 *
 */

class View
{
 private $_registry;
 private $_vars = [];
 private $_path;
 private $_norender = false;
 private $_error;
 
 public function __construct($registry)
 {
   $this->_registry = $registry;
 }
 
 public function __set($key, $value)
 {
   $this->_vars[$key] = $value;
 }
 
 public function setPath($path)
 {
  try {
      
    if (!is_dir($path)) {
        
       throw new Exception("Invalid view path: {$path}");
       
    } 
    
    $this->_path = $path;
    
  } catch (Exception $e) {
      
    $this->_error = LogError::newMessage($e);
    $this->_error = LogError::customErrorMessage();
    
  }
  
 }
 
 public function load($file)
 {
   foreach ($this->_vars as $key => $value) {
       
       $$Key = $value;
       
   }
   
   include $this->_path . '/' . $file;
   
 }
 
 public function setNoRender($norender = true)
 {
  $this->_norender = $norender;
 }
 
 public function dispatch()
 {
  try {
      
    if ($this->_norender) {
          
       return;
          
       foreach ($this->_vars as $key => $value) {
              
          $$key = $value;
              
        }
          
   $view = $this->_path .'/'. $this->_registry->router->controller .'/'. $this->_registry->router->action . '.php';
   if (!file_exists($view)) {
       
     throw new Exception("View not found in {$view}");
     
   }
   
    include($view);
      
    }
    
  } catch (Exception $e) {
      
     $this->_error = LogError::newMessage($e);
     $this->_error - LogError::customErrorMessage();
     
  }
  
 }
 
}