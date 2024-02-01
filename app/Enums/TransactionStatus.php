<?php

namespace App\Enums;

enum TransactionStatus
{
    case Pending;
    case Success;
    case Failure;
    case Cancelled;
}
