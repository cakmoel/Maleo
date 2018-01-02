<?php
/**
 * Class DbAdapterFactory
 * Responsible for instantiating the appropriate database adapter type 
 * 
 * @author lakota developer community
 * @copyright contributors
 * @license MIT
 * @version 1.0
 * @since Since Release 1.0
 *
 */

class DbAdapterFactory
{

/**
 * @method dbInit
 * @static
 * @access public
 * @param string $type
 * @param string $connectionValue
 * @throws Exception
 * @return object adapter -- new $dbAdapterType($connectionValue)
 */
public static function dbInit($type, $connectionValue)
{
  $dbAdapterType = "DbAdapter".$type;	
    
    if (class_exists($dbAdapterType)) {
    
    return new $dbAdapterType($connectionValue);
	
    } else {
			
    throw new Exception("Database Adapter Type Does Not Exists !");
	 
    }
}

}