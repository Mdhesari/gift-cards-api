<?php

namespace App\Exceptions;

use Exception;

class GiftCardAlreadyUsed extends Exception
{
    protected $message = 'You have already used this gift card.';
}
