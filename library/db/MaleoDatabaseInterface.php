<?php
/**
 * Interface MaleoDatabaseInterface
 * The Database Adapter Interface to describe the functionality
 * that any database adapter will need.
 * Reference:
 * http://www.devshed.com/c/a/PHP/PHP-Service-Layers-Database-Adapters/
 * 
 * @author Maleo developer community
 * @copyright 2017 contributors
 * @license MIT
 * @version Beta
 * @since Since Release Beta
 *
 */

interface MaleoDatabaseInterface
{
/**
* setup database connection
* 
* @param array $values
*/
function setDbConnection(array $values = array());
	
/**
* close database connection
*/
function closeDbConnection();
	
/**
* Executes an SQL Query 
*
* @param string $sql
* @param array $parameters
*/
function dbQuery($sql, array $parameters = array());
	
/**
* Retrieve a single field value
* 
* @param string $sql
* @param array $parameters
*/
function dbFetchField($sql, array $parameters = array());
	
/**
* Retrieve a row
* 
* @param string $sql
* @param array $parameters
*/
function dbFetchRow($sql, array $parameters = array());
	
/**
* Retrieve an array of rows
* 
* @param string $sql
* @param array $parameters
*/
function dbFetchAll($sql, array $parameters = array());
	
/**
* Insert new record into a table
* 
* @param string $tablename
* @param array $parameters
*/
function dbInsert($tablename, array $parameters = array());
	
/**
* get the last insert Id
*/
function dbLastInsertId();
	
/**
* Update an existing record from table
* and executes an UPDATE statement
* 
* @param string $tablename
* @param array $updateParameters
* @param string $whereCondition
* @param array $whereParameters
*/
function dbUpdate($tablename, array $updateParameters = array(), $whereCondition = '', array $whereParameters = array());
	
/**
* Delete existing record from table
* and executes DELETE statement
* 
* @param string $tablename
* @param string $whereCondition
* @param array $whereParameters
*/
function dbDelete($tablename, $whereCondition = null, array $whereParameters = array());
	
/**
* Retrieve the number of rows affected by the last SQL statement
* 
*/
function dbNumRowsAffected();
	
/**
* Begins a transaction
* 
*/
function dbBeginTransaction();
	
/**
* Commits current transaction
* 
*/
function dbCommit();
	
/**
* Rolls back current transaction
* 
*/
function dbRollBack();
	
}