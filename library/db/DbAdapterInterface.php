<?php
/**
 * Interface DbAdapterInterface	
 * The Database Adapter Interface to describe the functionality
 * that any database adapter will need.
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version 1.0
 * @since Since Release 1.0
 *
 */

interface DbAdapterInterface
{
/**
* setup database connection
* 
* @method setDbConnection
* @param array $values
*/
function setDbConnection($values = array());
	
/**
* close database connection
* 
* @method closeDbConnection
*/
function closeDbConnection();
	
/**
* Executes an SQL Query 
* 
* @method dbQuery
* @param string $sql
* @param array $parameters
*/
function dbQuery($sql, $parameters = array());
	
/**
* Retrieve a single field value
* 
* @method dbFetchField
* @param string $sql
* @param array $parameters
*/
function dbFetchField($sql, $parameters = array());
	
/**
* Retrieve a row
* 
* @method dbFetchRow
* @param string $sql
* @param array $parameters
*/
function dbFetchRow($sql, $parameters = array());
	
/**
* Retrieve an array of rows
* 
* @param string $sql
* @param array $parameters
*/
function dbFetchAll($sql, $parameters = array());
	
/**
* Create new record into a table
* 
* @method dbInsert
* @param string $tablename
* @param array $parameters
*/
function dbInsert($tablename, $parameters = array());
	
/**
* get the last insert Id
* 
* @method dbLastInsertId
*/
function dbLastInsertId();
	
/**
* Update an existing record from table
* and executes an UPDATE statement
* 
* @method dbUpdate
* @param string $tablename
* @param array $updateParameters
* @param string $whereCondition
* @param array $whereParameters
*/
function dbUpdate($tablename, $updateParameters = array(), $whereCondition = '', $whereParameters = array());
	
/**
* Delete existing record from table
* and executes DELETE statement
* 
* @method dbDelete
* @param string $tablename
* @param string $whereCondition
* @param array $whereParameters
*/
function dbDelete($tablename, $whereCondition = null, $whereParameters = array());
	
/**
* Retrieve the number of rows affected by the last SQL statement
* 
* @method dbNumRowsAffected
*/
function dbNumRowsAffected();
	
/**
* Begins a transaction
* 
* @method dbBeginTransaction
*/
function dbBeginTransaction();
	
/**
* Commits current transaction
* 
* @method dbCommit
*/
function dbCommit();
	
/**
* Rolls back current transaction
* 
* @method dbRollBack
*/
function dbRollBack();
	
}