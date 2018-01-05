<?php
namespace Maleo\core;

use Maleo\helper\MaleoActiveRecord;

use Maleo\helper\LogError;

use Exception;

/**
 * class MaleoModel
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version Beta
 * @since Since Release Beta
 */
class MaleoModel
{
/**  
 * dbAdapter
 * 
 * @var string
 */
protected $dbAdapter;

/**  
 * SQL 
 * 
 * @var string
 */
protected $sql;

/**
 * Error
 * 
 * @var string
 */
protected $error;

/**
 * Constructor
 * calling database adapter
 */
public function __construct()
{
 $this->dbAdapter = MaleoActiveRecord::getDatabaseAdapter();
}

/**
 * set SQL
 * 
 * @param string $sql
 */
protected function setSql($sql)
{
 $this->sql = $sql;
}

/**
 * Retrieve all records
 * 
 * @param string $data
 * @throws Exception
 * @return array
 */
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

/**
 * Retrieve a spesific record
 * 
 * @param string $data
 * @throws Exception
 * @return array
 */
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

/**
 * Insert new records
 * 
 * @param string  $tableName
 * @param array $parameters
 */
public function insert($tableName, $parameters = array())
{
  try {
     
    $insertNewRecord = $this->dbAdapter->dbInsert($tableName, $parameters);
      
  } catch (Exception $e) {
    $this->error = LogError::newMessage($e);
    $this->error = LogError::customErrorMessage();
  }
  
}

/**
 * Updating records
 * 
 * @param string $tableName
 * @param array $updateParameters
 * @param string $whereCondition
 * @param array $whereParameters
 */
public function update($tableName, $updateParameters = array(), $whereCondition = '', $whereParameters = array())
{
 try {
   
   $updateRecords = $this->dbAdapter->dbUpdate($tableName, $updateParameters, $whereCondition, $whereParameters);
     
 } catch (Exception $e) {
   
   $this->error = LogError::newMessage($e);
   $this->error = LogError::customErrorMessage();
   
 }
 
}

/**
 * Delete records
 * 
 * @param string $tableName
 * @param string $whereCondition
 * @param array $whereParameters
 */
public function delete($tableName, $whereCondition = null, $whereParameters = array())
{
 try {
   
   $deleteRecords = $this->dbAdapter->dbDelete($tableName, $whereCondition, $whereParameters);
   
 } catch (Exception $e) {
   
   $this->error = LogError::newMessage($e);
   $this->error = LogError::customErrorMessage();
   
 } 
 
}

}