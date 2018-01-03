<?php
/**
 * class ActiveRecord
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version 1.0
 * @since Since Release 2017
 *
 */

class ActiveRecord
{
  public static function getDatabaseAdapter()
  {
    return DbAdapterFactory::dbInit('PDO', array(DB_CONNECTION, DB_USR, DB_PWD));
  }
}