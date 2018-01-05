<?php
namespace Maleo\db;

use Exception;

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
 * @return object adapter -- new $dbAdapterType($connectionValue)
 */
public static function dbInit($type, $connectionValue)
{
  $dbAdapterType = "MaleoAdapter".$type;	
    
    if (class_exists($dbAdapterType)) {
    
    return new $dbAdapterType($connectionValue);
	
    } else {
			
    throw new Exception("Database Adapter Type Does Not Exists !");
	 
    }
}

}