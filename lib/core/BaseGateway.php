<?php
/**
 * abstract class BaseGateway
 * Reference:
 * https://speakerdeck.com/hhamon/database-design-patterns-with-php-53
 * http://martinfowler.com/eaaCatalog/tableDataGateway.html
 *
 * @author maoelana noermoehammad
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
     * Error exception
     * @var string
     */
    protected $error;
    
    /**
     *
     * constructor
     * @param string $adapter
     * @throws Exception
     */
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
    
    abstract protected function findTableName();
    abstract protected function findObjectName();
    abstract protected function findOrderFields();
    
    protected function findPrimaryKeyName()
    {
        return "ID";
    }
    
    public function findAll($sort = null)
    {
        $sql = $this->getSelectStatement();
        
        if (!is_null($sort)) {
            
            $sql .= ' ORDER BY ' . $sort;
            
        }
        
        return $this->transformRecordToObject($this->databaseAdapter->dbFetchAll());
        
    }
    
    public function findAllSorted($asc)
    {
        
        $sql = $this->getSelectStatement() . ' ORDER BY ' . $this->findOrderFields();
        if (!$asc) {
            $sql .= " DESC";
        }
        
        return $this->transformRecordToObject($this->databaseAdapter->dbFetchAll());
        
    }
    
    public function findBy($whereClause, $parameter = [], $sort = null)
    {
        $sql = $this->getSelectStatement() . ' WHERE ' . $whereClause;
        if (!is_null($sort)) {
            $sql .= ' ORDER BY ' . $sort;
        }
        
        $result = $this->databaseAdapter->dbFetchAll($sql, $parameter);
        return $this->transformRecordToObject($result);
        
    }
    
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
    
    protected function transformRowToObject($result)
    {
        $className = $this->findObjectName();
        return new $className($result, false);
    }
    
}