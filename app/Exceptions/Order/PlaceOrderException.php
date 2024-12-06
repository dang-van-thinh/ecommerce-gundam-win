<?php

namespace App\Exceptions\Order;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class PlaceOrderException extends Exception
{
    public function __construct($message = '', $code = '404') {
        parent::__construct($message,$code);
    }
}
