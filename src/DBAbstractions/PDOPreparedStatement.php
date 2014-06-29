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
        $this->_params = array();
    }

    public function execute(array $params = null)
    {
        if($params === null)
        {
            $params = $this->_params;
        }
        else
        {
            $params = array_merge($this->_params, $params);
        }
        try 
        {
            if($params != null && count($params) > 0)
            {
                $this->_statement->execute($params);
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

    public function clearParameters()
    {
        $this->_params = array();
        return $this;
    }
}