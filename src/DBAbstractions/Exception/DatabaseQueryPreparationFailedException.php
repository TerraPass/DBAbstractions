<?php

namespace DBAbstractions\Exception;

class DatabaseQueryPreparationFailedException extends \Exception
{
    /**
     * 
     * @param string $query Failed query
     * @param string $error Error message
     * @param integer $code
     * @param \Exception $previous
     */
    public function __construct($query, $error = null, $code = 0, $previous = null)
    {    
        $message = "Failed to prepare query \'$query\'";
        if($error != null)
        {
            $message .= ': '.$error;
        }
        
        parent::__construct($message, $code, $previous);
    }
}

