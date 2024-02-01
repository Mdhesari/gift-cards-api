<?php

namespace App\Exceptions;

use Exception;

class GiftCardFullyUtilizedException extends Exception
{
    protected $message = 'Gift card fully utilized.';
}
