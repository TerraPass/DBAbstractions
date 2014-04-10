<?php

namespace DBAbstractions;

use DBAbstractions\IDBQuery;
use PDO;
use PDOException;
use PDOStatement;

class PDOPreparedStatement implements IDBQuery
{
    /**
     * Underlying PDOStatement object
     * @var \PDOStatement
     */
    private $_statement;
    
    /**
     * Statement parameters
     * @var array
     */
    private $_params;
    
    public function __construct(PDOStatement $statement)
    {
        $this->_statement = $statement;
    }

    public function execute(array $params = null)
    {
        if($params != null)
        {
            $this->setParameters($params);
        }
        try 
        {
            if($this->_params != null && count($this->_params) > 0)
            {
                $this->_statement->execute($this->_params);
            }
            else
            {
                $this->_statement->execute();
            }
            return new PDOQueryResult($this->_statement);
        }
        catch (PDOException $e)
        {
            if(isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062)
            {
                throw new Exception\DuplicateKeyException($e, $e->getCode(), $e);
            }
            else
            {
                throw new Exception\DatabaseQueryFailedException($this->_statement->queryString, $e, -1, $e);
            }
        }
        
    }

    public function setParameters(array $params)
    {
        $this->_params = $params;
        return $this;
    }
}