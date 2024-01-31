<?php

namespace App\Services;

use App\Exceptions\GiftCardAlreadyUsed;
use App\Exceptions\GiftCardIsFull;
use App\Http\Resources\GiftCardResponse;
use App\Models\GiftCard;
use App\Params\GiftCardParam;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GiftCardService
{
    public function submit(GiftCardParam $param)
    {
        return DB::transaction(function () use ($param) {
            $user = Auth::user();

            $giftCard = GiftCard::lockForUpdate()->code($param->code)->first();
            if (! $giftCard) {
                throw new ModelNotFoundException('Gift card not found.');
            }

            if ($giftCard->isFull()) {
                throw new GiftCardIsFull();
            }

            $userAlreadyUsed = $user->giftCards()->where('gift_card_id', $giftCard->id)->exists();
            if ($userAlreadyUsed) {
                throw new GiftCardAlreadyUsed();
            }

            $user->useGiftCard($giftCard);
            $giftCard->decrease();
            $user->defaultWallet()->increase($giftCard->quantity);

            return new GiftCardResponse([]);
        });
    }
}
