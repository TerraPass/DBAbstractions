<?php

namespace DBAbstractions\Exception;

class DatabaseConnectionFailedException extends \Exception
{
    public function __construct($error, $code = 0, $previous = null)
    {    
        $message = "Failed to connect to the database: $error";
        
        parent::__construct($message, $code, $previous);
    }
}
