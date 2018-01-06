<?php
namespace Maleo;
/**
 * class MaleoAppLoader
 * 
 * @author Maleo Developer Community
 * @copyright 2017 contributors
 * @license MIT
 * @version Beta
 * @since Since Release Beta
 */
class MaleoLoader
{

 /**
  * An array that will be used as associative of namespace prefix and it value.
  * where the key is a namespace prefix while 
  * the value is array of base directories
  * 
  * @var array
  */
 protected $proclitic = array();
 
 /**
  * set the mapped file for namespace prefix and relative class
  * 
  * @param string $prefix
  * @param string $relativeClass
  * @return boolean|string mixed Boolean 
  */
 protected function setMappedFile($prefix, $relativeClass)
 {
     if (isset($this->proclitic[$prefix]) === false) {
         return false;
     }
     
     foreach ($this->proclitic[$prefix] as $baseDir) {
         
         $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
         
         if ($this->fileRequired($file)) {
             return $file;
         }
         
     }
     
     return false;
     
 }
 
 /**
  * If a file exists, then require it.
  * 
  * @param string $file The file required
  * @return boolean True if the file is exists, otherwise if not.
  */
 protected function fileRequired($file)
 {
     if (is_readable($file)) {
         require $file;
         return true;
     }
     
     return false;
 }
 
 /**
  * Append a base directory for a namespace prefix
  * 
  * @param string $prefix
  * @param string $baseDir
  * @param boolean $prepend
  */
 public function addBaseDirectory($prefix, $baseDir, $prepend = false)
 {
   $prefix = trim($prefix, '\\') . '\\';
   
   $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . '/';
   
   if (isset($this->proclitic[$prefix]) === false) {
       $this->proclitic[$prefix] = array();
   }
   
   if ($prepend) {
      array_unshift($this->proclitic[$prefix], $baseDir);
   } else {
      array_push($this->proclitic[$prefix], $baseDir);
   }
   
 }
 
 /**
  * Loading the class file
  * 
  * @param string $class
  * @return boolean|string|boolean
  */
 public function loaderClass($class)
 {
   $prefix = $class;
   
   while (false !== $pos = strrpos($prefix, '\\')) {
      
     $prefix = substr($class, 0, $pos + 1);
       
     $relativeClass = substr($class, $pos + 1);
     
     $mappedFile = $this->setMappedFile($prefix, $relativeClass);
     if ($mappedFile) {
         return $mappedFile;
     }
     
     $prefix = rtrim($prefix, '\\');  
   }
   
   return false;
   
 }
 
 /**
  * Register loader with SPL autoloader
  * 
  * @return void
  */
 public function registerLoader()
 {
   spl_autoload_register(array($this, 'loaderClass'));
 }
 
}