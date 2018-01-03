<?php
/**
 * class Registry
 * Implement Singleton for single data object 
 * that will be used by Registry
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version 1.0 
 * @since Since Release 1.0
 */

class Registry
{
 
 /**
  * Registry Data Object 
  * @var array
  */
 private static $_data = [];
 
 /**
  * get
  * @param string $key
  * @return NULL|mixed
  */
 public static function get($key)
 {
   return (isset(self::$_data[$key]) ? self::$_data[$key] : null);
 }
 
 /**
  * set
  * @param string $key
  * @param string $value
  */
 public static function set($key, $value)
 {
   self::$_data[$key] = $value;
 }
 
 /**
  * setAll
  * @param array $key
  */
 public static function setAll(array $key)
 {
   self::$_data = $key;
 }
 
 /**
  * checking if key set 
  * @param string $key
  * @return self::$data[$key]
  */
 public static function isKeySet($key)
 {
   return (isset(self::$_data[$key]));
 }
    
}