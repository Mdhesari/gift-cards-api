<?php

namespace App\Exceptions;

use Exception;

class GiftCardDecreaseException extends Exception
{
    protected $message = "Gift card decrease error.";
}
