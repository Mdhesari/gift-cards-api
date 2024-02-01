<?php

namespace App\Exceptions;

use Exception;

class WalletIncreaseException extends Exception
{
    protected $message = "Could not increase wallet balance.";
}
