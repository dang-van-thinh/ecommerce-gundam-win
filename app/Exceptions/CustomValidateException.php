<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class CustomValidateException extends Exception
{
    public function __construct($message = '', $code = '404') {
        parent::__construct($message,$code);
    }
}