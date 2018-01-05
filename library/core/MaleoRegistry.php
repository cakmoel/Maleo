<?php
namespace Maleo\core;

/**
 * class MaleoRegistry
 * Implement Registry for single data object 
 * that will be used by Registry Object
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version 1.0 
 * @since Since Release 1.0
 */

class MaleoRegistry
{
 
 /**
  * Registry Data Object
  *  
  * @var array
  */
 private static $_data = array();
 
 /**
  * get registry object itself
  * 
  * @param string $key
  * @return NULL|mixed
  */
 public static function get($key)
 {
   return (isset(self::$_data[$key]) ? self::$_data[$key] : null);
 }
 
 /**
  * set registry object
  * 
  * @param string $key
  * @param string $value
  */
 public static function set($key, $value)
 {
   self::$_data[$key] = $value;
 }
 
 /**
  * setAll registry object as an associative array
  * 
  * @param array $key
  */
 public static function setAll(array $key = array())
 {
   self::$_data = $key;
 }
 
 /**
  * checking if key of registry object set or not
  * 
  * @param string $key
  * @return self::$data[$key]
  */
 public static function isKeySet($key)
 {
   return (isset(self::$_data[$key]));
 }
    
}