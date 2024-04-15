<?php

namespace Bank\Exceptions;

use Exception;

class InvalidTypeException extends Exception
{
    protected $string = 'Invalid Type';
    protected $code = 422;
}
