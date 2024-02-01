<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Exceptions\WalletIncreaseException;
use App\Params\WalletBalanceParam;
use App\Services\WalletService;

class UpdateWalletBalance
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private WalletService $walletSrv,
    )
    {
        //
    }

    /**
     * Handle the event.
     * @throws WalletIncreaseException
     */
    public function handle(TransactionCreated $event): void
    {
        $tx = $event->transaction;

        if ($tx->isDeposit()) {
            $this->walletSrv->increaseBalance(
                new WalletBalanceParam(
                    $tx->wallet_id,
                    $tx->quantity,
                )
            );
        }

        if ($tx->isWithdraw()) {
            $this->walletSrv->decreaseBalance(
                new WalletBalanceParam(
                    $tx->wallet_id,
                    $tx->quantity,
                )
            );
        }
    }
}
