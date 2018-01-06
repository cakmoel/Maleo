<?php
/**
 * Class MaleoDatabaseFactory
 * Responsible for instantiating the appropriate database adapter type 
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version Beta
 * @since Since Release Beta
 */
class MaleoDatabaseFactory
{

/**
 * Initializing database adapter type
 * 
 * @access public
 * @param string $type
 * @param string $connectionValue
 * @throws Exception
 * @return object adapter
 */
public static function dbInit($type, $connectionValue)
{
  $adapterType = "MaleoAdapter" . $type;	
    
   if (class_exists($adapterType)) {
    
       return new $adapterType($connectionValue);
	
   } else {
			
     throw new Exception("File {$adapterType} Does Not Exists !");
	 
   }
}

}