<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Events\TransactionCreated;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Params\DepositParam;

class TransactionService
{
    public function deposit(DepositParam $param): TransactionResource
    {
        $tx = Transaction::create([
            'wallet_id' => $param->walletId,
            'user_id'   => $param->userId,
            'quantity'  => $param->quantity,
            'type'      => TransactionType::Deposit->name,
            'status'    => $param->status->name,
        ]);

        event(new TransactionCreated($tx));

        return new TransactionResource([
            'transaction' => $tx,
        ]);
    }
}
