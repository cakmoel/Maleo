<?php
/**
 * abstract class BaseGateway
 * Encapsulates some common functionality which needed by all table gateway objects
 * Reference:
 * https://speakerdeck.com/hhamon/database-design-patterns-with-php-53
 * http://martinfowler.com/eaaCatalog/tableDataGateway.html
 * http://css.dzone.com/books/practical-php-patterns-table
 *
 * @author lakota developer community
 * @copyright contributors
 * @license MIT
 * @version 1.0
 * @since Since Release 1.0
 *
 */

abstract class BaseGateway
{
    
/**
 * Database Adapter
 * @var string
*/
protected $databaseAdapter;
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
   
public function __construct($adapter)
{
   try {
            
    if (is_null($adapter)) throw new Exception("Database adapter is not found");
       $this->databaseAdapter = $adapter;
            
   } catch (Exception $e) {
            
      $this->error = LogError::newMessage($e);
      $this->error = LogError::customErrorMessage();
            
   }
        
}
    
// table in the database
abstract protected function findTableName(); 
// class name for this table and for the row items
abstract protected function findObjectName(); 
// fields that define sort order
abstract protected function findOrderFields();
    
/**
 * Primary Keys in the database
 * can be overidden by subclasses
 * 
 * @method findPrimaryKeyName
 * @return string
 */
protected function findPrimaryKeyName()
{
 return "ID";
}
    
/**
 * Retrieve all the records in the table
 * 
 * @method findAll
 * @param string $sort
 * @return array[]
 */
public function findAll($sort = null)
{
 $sql = $this->getSelectStatement();
        
 if (!is_null($sort)) {
            
   $sql .= ' ORDER BY ' . $sort;
            
 }
        
 return $this->transformRecordToObject($this->databaseAdapter->dbFetchAll());
        
}

/**
 * Retrieve all the records in the table sorted
 * 
 * @param string $asc
 * @return array[]
 */
public function findAllSorted($asc)
{
  $sql = $this->getSelectStatement() . ' ORDER BY ' . $this->findOrderFields();
  if (!$asc) {
   $sql .= " DESC";
  }
  return $this->transformRecordToObject($this->databaseAdapter->dbFetchAll());       
}

/**    
 * Retrieve all the records that match the criteria specified 
 * by passed where clause
 * 
 * @param string $whereClause
 * @param array $parameter
 * @param string $sort
 * @return object|array[]
 */
public function findBy($whereClause, $parameter = [], $sort = null)
{
  $sql = $this->getSelectStatement() . ' WHERE ' . $whereClause;
   if (!is_null($sort)) {
    $sql .= ' ORDER BY ' . $sort;
   }
   $result = $this->databaseAdapter->dbFetchAll($sql, $parameter);
   return $this->transformRecordToObject($result);        
}

/**
 * 
 * @param integer $id
 * @return object
 */
public function findById($id)
{
 $sql = $this->getSelectStatement() . ' WHERE ' . $this->findPrimaryKeyName() . '=:id';
 return $this->transformRowToObject($this->databaseAdapter->dbFetchRow($sql, array(':id'=>$id)));
}
    
protected function getSelectStatement()
{
  $className = $this->findObjectName();
  return "SELECT " . $className::fieldNameList() . " FROM " . $this->findTableName();
}

/**
 * 
 * @param array $results
 * @return object array[]
 */
protected function transformRecordToObject($results)
{
  $className = $this->findObjectName();
  $rows = [];
  foreach ($results as $result) {
            
     $instance = new $className($row, false);
     $rows[] = $instance;
            
  }
        
 return $rows;
        
}

/**
 * Transform Row to Object
 * 
 * @param string $result
 * @return object
 */
protected function transformRowToObject($result)
{
$className = $this->findObjectName();
return new $className($result, false);
}
    
}