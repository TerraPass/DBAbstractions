<?php

namespace DBAbstractions;

use DBAbstractions\AbstractDBConnector;
use PDO;
use PDOException;

class PDOConnector extends AbstractDBConnector
{
    /**
     *  Underlying PDO connection object
     * @var PDO
     */
    private $_pdo;

    public function connect()
    {
        try
        {
            $this->_pdo = new PDO(
                'mysql:host='.$this->host.';dbname='.$this->database.';port='.$this->port.';charset='.$this->charset,
                $this->user,
                $this->password,
                array(
                    PDO::ATTR_PERSISTENT => $this->persistent
                )
            );
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            // charset= is ignored in PHP before 5.3.6
            if(PHP_VERSION_ID < 50306)
            {
                $this->_pdo->exec('set names '.$this->charset);
            }
        }
        catch(PDOException $e)
        {
            throw new Exception\DatabaseConnectionFailedException($e, -1, $e);
        }
    }

    public function disconnect()
    {
        if(!$this->persistent)
        {
            $this->_pdo = null;
        }
    }

    public function isConnected()
    {
        return ($this->_pdo === null);
    }
    
    public function prepareQuery($query)
    {
        if(!$this->isConnected())
        {
            $this->connect();
        }
        try
        {
            return new PDOPreparedStatement($this->_pdo->prepare($query));
        } 
        catch (PDOException $e)
        {
            throw new Exception\DatabaseQueryPreparationFailedException($query, $e, -1, $e);
        }
    }

    public function lastInsertId()
    {
        return $this->_pdo->lastInsertId();
    }

}