<?php
/**
 * class BaseModel
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version 1.0
 * @since Since Release 2017
 *
 */

class BaseModel
{
/**  
 * dbAdapter
 * @var string
 */
protected $dbAdapter;

/**  
 * SQL 
 * @var string
 */
protected $sql;

/**
 * Error
 * @var string
 */
protected $error;

/**
 * Constructor
 * calling database adapter
 */
public function __construct()
{
 $this->dbAdapter = ActiveRecord::getDatabaseAdapter();
}
  
protected function setSql($sql)
{
 $this->sql = $sql;
}

public function findAll($data = null)
{

try {
    
  if (!$this->sql) {
    throw new Exception("No SQL found!");      
  }
  
  $results = $this->dbAdapter->dbFetchAll($this->sql, $data);
  
  return $results;
  
} catch (Exception $e) {
    
  $this->error = LogError::newMessage($e);
  $this->error = LogError::customErrorMessage();
  
}

}

public function findRow($data = null)
{
 try {
   
  if (!$this->sql) {
    throw new Exception("No SQL found!");
  }
  
  $result = $this->dbAdapter->dbFetchRow();
  return $result;
  
 } catch (Exception $e) {
  $this->error = LogError::newMessage($e);
  $this->error = LogError::customErrorMessage();
 }
 
}

public function insert($table, $data)
{
  try {
     
    return $this->dbAdapter->dbInsert($table, $data);
  
  } catch (Exception $e) {
    $this->error = LogError::newMessage($e);
    $this->error = LogError::customErrorMessage();
  }
  
}

public function update($table, $data, $where)
{
  
}
}