<?php
require(dirname(__FILE__) . '/simpletest/autorun.php');
require(dirname(__FILE__) . '/../classes/Log.php');

class TestLog extends UnitTestCase 
{
  
  public function __construct()
  {
    parent::__construct('Log test');      
  }
  
  public function testFirstLogMessages() 
  {
    @unlink(dirname(__FILE__) . '/../temp/test.log');
    $log = new Log(dirname(__FILE__) . '/../temp/test.log');
    $log -> message('should write to this file');
    $this->assertTrue(is_readable(dirname(__FILE__) . '/../temp/test.log'));
    
  }
 
}

