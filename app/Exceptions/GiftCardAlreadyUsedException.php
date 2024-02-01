<?php

namespace App\Exceptions;

use Exception;

class GiftCardAlreadyUsedException extends Exception
{
    protected $message = 'You have already used this gift card.';
}
