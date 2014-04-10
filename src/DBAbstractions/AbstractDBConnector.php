<?php

namespace DBAbstractions;

abstract class AbstractDBConnector
{
    // Format of configuration file
    /**
     * Passed to indicate that configuration is in PHP
     */
    const CONFIG_PHP    = 0;
    /**
     * Passed to indicate that configuration is in JSON
     */
    const CONFIG_JSON   = 1;
    
    private static $properties_to_serialize = array(
        'host',
        'port',
        'user',
        'password',
        'database'
    );
    
    // Database configuration
    protected $host;
    protected $port;
    protected $user;
    protected $password;
    protected $database;
    protected $persistent;
    protected $charset;

    /**
     * Construct a connector from specified database configuration
     * 
     * @param type $database_config_file Path to file to load configuration from
     * @param type $config_format CONFIG_PHP or CONFIG_JSON, depending on configuration format
     * @throws \InvalidArgumentException If specified configuration file doesn't exist
     */
    public function __construct($database_config_file, $config_format = AbstractDBConnector::CONFIG_JSON)
    {
        if(!file_exists($database_config_file))
        {
            throw new \InvalidArgumentException("Configuration file $database_config_file does not exist");
        }
        $config = null;
        if($config_format == AbstractDBConnector::CONFIG_PHP)
        {
            $config = (require "$database_config_file");
        }
        else
        {
            $config = json_decode(file_get_contents($database_config_file), true);
        }
        if($config == null)
        {
            throw new ConfigurationParsingFailedException("Failed to parse configuration from $database_config_file");
        }
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->user = $config['user'];
        $this->password = $config['password'];
        $this->database = $config['database'];
        $this->charset = $config['charset'];
        $this->persistent = $config['persistent'];
    }
    
    public function __sleep()
    {
        $this->disconnect();
        return AbstractDBConnector::$properties_to_serialize;
    }
    
    /**
     * Establish connection to the database
     * 
     * @throws DBAbstractions\DatabaseConnectionFailedException
     */
    public abstract function connect();
    
    /**
     * Close connection to the database.
     * Overriding methods MUST NOT throw on repeated calls.
     */
    public abstract function disconnect();

    /**
     * Check whether connection to DB is currently established
     * 
     * @return boolean TRUE if connection has been established, FALSE otherwise
     */
    public abstract function isConnected();


    /**
     * Prepare and return a parametrizable query.
     * 
     * @param string $query Query string
     * @return DBAbstractions\IDBQuery Prepared query
     */
    public abstract function prepareQuery($query);
    
    /**
     * @return integer Last inserted object's id
     */
    public abstract function lastInsertId();
}