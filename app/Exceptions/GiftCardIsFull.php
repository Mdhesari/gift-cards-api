<?php

namespace App\Exceptions;

use Exception;

class GiftCardIsFull extends Exception
{
    protected $message = 'Gift card fully utilized.';
}
