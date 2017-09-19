<?php

namespace App\Exceptions;

use Exception;

abstract class StandardizedErrorResponseException extends Exception
{

    /**
     * Send back a HTTP 500 status code by default
     * @var int
     */
    protected $code = 500;
}
