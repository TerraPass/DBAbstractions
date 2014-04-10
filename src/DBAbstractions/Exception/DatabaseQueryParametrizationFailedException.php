<?php

namespace DBAbstractions\Exception;

class DatabaseQueryParametrizationFailedException extends \Exception
{
    public function __construct($query = null, $code = 0, $previous = null)
    {    
        $message = "Failed to parametrize database query";
        if($query != null)
        {
            $message .= "($query)";
        }
        
        parent::__construct($message, $code, $previous);
    }
}

