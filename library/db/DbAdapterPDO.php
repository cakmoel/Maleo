<?php
/**
 * Class DbAdapterPDO
 * Database adaper that use PDO API
 * Reference:
 * http://www.devshed.com/c/a/PHP/PHP-Service-Layers-Database-Adapters/
 * 
 * @author lakota developer community
 * @license MIT
 * @version 1.0
 * @since Since Release 1.0
 *
 */

class DbAdapterPDO implements DbAdapterInterface
{
/**
* Database Connection
* @access private
* @var string
*/
private $_db;
	
/**
* Statement handle
* @access private
* @var string
*/
private $_lastStatement = null;

/**
 * Error
 * @var string
 */
private $_error;
	
/**
* Constructor is passed an array containing the following connection information :
* $values[0] -- Connection string
* $values[1] -- user name
* $values[2] -- password
* @param array $values
* 
*/
public function __construct($values)
{
   $this->setDbConnection($values);
}
	
/**
* @method setDbConnection
* {@inheritDoc}
* @see DbAdapterInterface::setDbConnection()
*/
public function setDbConnection($values = array())
{
  try {
  	$connectionString = $values[0];
  	$DbUser = $values[1];
  	$DbPassword = $values[2];
  	
  	$db = new PDO($connectionString, $DbUser, $DbPassword);
  	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$this->_db = $db;
  	
  } catch (PDOException $e) {
  	$this->_error = Logerror::newMessage($e);
  	$this->_error = Logerror::customErrorMessage();
  }
  	
}
	
/**
* @method closeDbConnection
* {@inheritDoc}
* @see DbAdapterInterface::closeDbConnection()
*/
public function closeDbConnection()
{
  $db = null;
}
	
/**
* @method dbQuery
* {@inheritDoc}
* @see DbAdapterInterface::dbQuery()
* @return PDO statement object
*/
public function dbQuery($sql, $parameters = array())
{
  if (!is_array($parameters)) {
   $parameters = array($parameters);
  }
		
  $this->_lastStatement = null;
		
  if (count($parameters) > 0) {
			
  // user prepared statement if parameters found
			
  $this->_lastStatement = $this->_db->prepare($sql);
			
  $executed = $this->_lastStatement->execute($parameters);
			
  if (!$executed) {
    throw new PDOException();
  }
			
  } else {		
  // use normal query
  $this->_lastStatement = $this->_db->query($sql);
			
    if (!$this->_lastStatement) {
    
    throw new PDOException();

    }
			
  }
		
   return $this->_lastStatement;
		
}

/**
* @method dbFetchField
* {@inheritDoc}
* @see DbAdapterInterface::dbFetchField()
* @return string
*/
public function dbFetchField($sql, $parameters = array()) 
{
  $row = $this->dbFetchRow($sql, $parameters);

  return ($row && count($row) > 0) ? array_shift($row) : null;
	
}
	
/**
* @method dbFetchRow
* {@inheritDoc}
* @see DbAdapterInterface::dbFetchRow()
* @return array
*/
public function dbFetchRow($sql, $parameters = array())
{
  $statementHandle = $this->dbQuery($sql, $parameters);
		
  $row = $statementHandle -> fetch(PDO::FETCH_ASSOC);
		
  return $row ? $row : null;
		
}
	
/**
* @method dbFetchAll
* {@inheritDoc}
* @see DbAdapterInterface::dbFetchAll()
* @return array
*/
public function dbFetchAll($sql, $parameters = array()) 
{
  $statementHandle = $this->dbQuery($sql, $parameters);
  return $statementHandle -> fetchAll(PDO::FETCH_ASSOC);
}

/**
 * @method dbInsert
 * {@inheritDoc}
 * @see DbAdapterInterface::dbInsert()
 * @return $this->dbQuery()
 */
public function dbInsert($tablename, $parameters = array())
{
  $fields = array();
		
  $values = array();
		
   foreach ($parameters as $key => $value) {
			
    $fields[] = $this->quoteIdentifier($key);
			
    $values[] = '?';
			
   }
		
   $escapedTableName = $this->quoteIdentifier($tablename);
		
   $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", $escapedTableName, implode(', ', $fields), implode(', ', $values));
		
   return $this->dbQuery($sql, array_values($parameters));
		
}

/**
 * @method getLastInsertId
 * @access public
 * @return $this->_db->lastInsertId
 */
public function dbLastInsertId()
{
   return $this->_db->lastInsertId();
}

/**
 * @method dbUpdate
 * {@inheritDoc}
 * @see DbAdapterInterface::dbUpdate()
 * @return $statementHandle->rowCount()
 */
public function dbUpdate($tablename, $updateParameters = array(), $whereCondition = '', $whereParameters = array())
{
  $assignments = array();
		
  $parameters = array();
      	
   foreach ($updateParameters as $key => $value) {
			
    $placeHolder = strtolower($key);
	$assignments[] = sprintf("%s = %s", $this->quoteIdentifier($key), ":$placeHolder");
	$parameters[$placeHolder] = $value;
   
   }

    $escapedTableName = $this->quoteIdentifier($tablename);

    $sql = sprintf("UPDATE %s SET %s", $escapedTableName, implode(', ', $assignments));
		
    if ($whereCondition) {

    $sql .= " WHERE $whereCondition"; 
    $parameters = array_merge($parameters, $whereParameters);
			
	}
		
	$statementHandle = $this->dbQuery($sql, $parameters);
		
	return $statementHandle->rowCount();
		
}

/**
 * @method dbDelete
 * {@inheritDoc}
 * @see DbAdapterInterface::dbDelete()
 * @return $statementHandle->rowCount()
 */
public function dbDelete($tablename, $whereCondition = null, $whereParameters = array())
{
  $sql = sprintf("DELETE FROM %s ", $this->quoteIdentifier($tablename));

  $parameters = array();
		
  if ($whereCondition) {

    $sql .= "WHERE $whereCondition";
    $parameters = $whereParameters;
  }
		
  $statementHandle = $this->dbQuery($sql, $parameters);
		
  return $statementHandle -> rowCount();
		
}

/**
 * @method dbBeginTransaction
 * {@inheritDoc}
 * @see DbAdapterInterface::dbBeginTransaction()
 * @return $this
 */
public function dbBeginTransaction()
{
  return $this->_db->beginTransaction();
}

/**
 * @method dbCommit()
 * {@inheritDoc}
 * @see DbAdapterInterface::dbCommit()
 */
public function dbCommit()
{
  return $this->_db->commit();	
}

/**
 * @method dbRollBack()
 * {@inheritDoc}
 * @see DbAdapterInterface::dbRollBack()
 */
public function dbRollBack()
{
  return $this->_db->rollBack();
}

/**
 * @method dbNumRowsAffected
 * {@inheritDoc}
 * @see DbAdapterInterface::dbNumRowsAffected()
 * @return $this->_lastStatement->rowCount()
 */
public function dbNumRowsAffected()
{
   if (!$this->_lastStatement) {
    return null;
   }
		
   return $this->_lastStatement->rowCount();
   
}

/**
 * @method quoteIdentifier
 * @access private
 * @param string $identifier
 * @return string
 */
private function quoteIdentifier($identifier)
{
    return sprintf("'%s'", $identifier);
}
	
}