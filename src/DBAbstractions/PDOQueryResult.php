<?php

namespace DBAbstractions;

use DBAbstractions\IDBQueryResult;
use PDOStatement;
use PDO;

class PDOQueryResult implements IDBQueryResult
{
    /**
     * Underlying PDOStatement object
     * @var \PDOStatement 
     */
    private $_statement;

    public function __construct(PDOStatement $statement)
    {
        $this->_statement = $statement;
    }
    
    public function getNumberOfRows()
    {
        return $this->_statement->rowCount();
    }

    public function getResultSetAssoc()
    {
        return $this->_statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isSelectResult()
    {
        throw new Exception\NotImplementedException('PDOQueryResult::isSelectResult()');
    }
}
