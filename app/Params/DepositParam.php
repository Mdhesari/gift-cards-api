<?php

namespace App\Params;

use App\Enums\TransactionStatus;

class DepositParam
{
    public function __construct(
        public readonly int $userId,
        public readonly string $walletId,
        public readonly float|int $quantity,
        public readonly TransactionStatus $status,
    )
    {
        //
    }
}
