<?php

namespace DBAbstractions\Exception;

class NotImplementedException extends \Exception
{
    public function __construct($feature_name, $code = 0, $previous = null)
    {
        $message = $feature_name.' is not implemented yet.';
        
        parent::__construct($message, $code, $previous);
    }
}