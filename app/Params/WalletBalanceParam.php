<?php

namespace App\Params;

class WalletBalanceParam
{
    public function __construct(
        public readonly string $walletId,
        public readonly float|int $quantity,
    )
    {
        //
    }
}
