<?php

namespace Bank\Exceptions;

use Exception;

class InvalidAmountException extends Exception
{
    protected $string = 'Amount is 0 or less than 0';
    protected $code = 422;
}
