<?php

namespace App\Services;

use App\Events\WalletDecreased;
use App\Events\WalletIncreased;
use App\Exceptions\WalletIncreaseException;
use App\Http\Resources\WalletResource;
use App\Models\Wallet;
use App\Params\WalletBalanceParam;

class WalletService
{
    /**
     * @throws WalletIncreaseException
     */
    public function increaseBalance(WalletBalanceParam $param): WalletResource
    {
        $wallet = Wallet::findOrFail($param->walletId);

        if (! $wallet->increaseBalance($param->quantity)) {

            throw new WalletIncreaseException;
        }

        event(new WalletIncreased($wallet));

        return new WalletResource([
            'wallet' => $wallet,
        ]);
    }

    /**
     * @throws WalletIncreaseException
     */
    public function decreaseBalance(WalletBalanceParam $param): WalletResource
    {
        $wallet = Wallet::findOrFail($param->walletId);

        if (! $wallet->decreaseBalance($param->quantity)) {

            throw new WalletIncreaseException;
        }

        event(new WalletDecreased($wallet));

        return new WalletResource([
            'wallet' => $wallet,
        ]);
    }
}
