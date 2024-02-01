<?php

namespace App\Services;

use App\Exceptions\GiftCardAlreadyUsedException;
use App\Exceptions\GiftCardDecreaseException;
use App\Exceptions\GiftCardFullyUtilizedException;
use App\Exceptions\WalletIncreaseException;
use App\Http\Resources\GiftCardResponse;
use App\Models\GiftCard;
use App\Models\User;
use App\Params\GiftCardParam;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class GiftCardService
{
    public function submit(GiftCardParam $param)
    {
        return DB::transaction(function () use ($param) {
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

            if (! $user->defaultWallet()->increaseBalance($giftCard->quantity)) {

                throw new WalletIncreaseException;
            }

            return new GiftCardResponse([]);
        });
    }
}
