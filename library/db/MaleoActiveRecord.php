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
class MaleoActiveRecord
{
  public static function getDatabaseAdapter()
  {
    return MaleoDatabaseFactory::dbInit('PDO', array(DB_CONNECTION, DB_USR, DB_PWD));
  }
}