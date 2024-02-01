<?php

namespace App\Services;

use App\Enums\TransactionStatus;
use App\Exceptions\GiftCardAlreadyUsedException;
use App\Exceptions\GiftCardDecreaseException;
use App\Exceptions\GiftCardFullyUtilizedException;
use App\Http\Resources\GiftCardResponse;
use App\Models\GiftCard;
use App\Models\User;
use App\Params\DepositParam;
use App\Params\GiftCardParam;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class GiftCardService
{
    public function __construct(
        private TransactionService $transactionSrv
    )
    {
        //
    }

    public function submit(GiftCardParam $param)
    {
        $transactionSrv = $this->transactionSrv;

        // Race condition management and do it sequentially to avoid incorrectness of the system.
        DB::transaction(function () use ($param, $transactionSrv) {
            // TODO: mobile could be stored in a more structured way like if we want to only store iranian numbers substr(-10) will work. in order to have numbers start with 9
            $user = User::firstOrCreate([
                'mobile' => $param->mobile,
            ]);

            // avoids simultaneous conflicts
            $giftCard = GiftCard::lockForUpdate()->code($param->code)->first();
            if (! $giftCard) {

                throw new ModelNotFoundException('Gift card not found.');
            }

            if ($giftCard->isFull()) {

                throw new GiftCardFullyUtilizedException();
            }

            $userAlreadyUsed = $user->giftCards()->where('gift_card_id', $giftCard->id)->exists();
            if ($userAlreadyUsed) {

                throw new GiftCardAlreadyUsedException();
            }

            $user->useGiftCard($giftCard);

            if (! $giftCard->decreaseBalance($giftCard->quantity)) {

                throw new GiftCardDecreaseException;
            }

            if (! $giftCard->increaseUsed()) {

                throw new GiftCardDecreaseException;
            }

            $transactionSrv->deposit(new DepositParam(
                $user->id,
                $user->defaultWallet()->id,
                $giftCard->quantity,
                TransactionStatus::Success, // Todo: may admin verify the transaction first in future but for now it's ok
            ));
        });

        return new GiftCardResponse([]);
    }
}
