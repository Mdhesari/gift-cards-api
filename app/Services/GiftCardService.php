<?php

namespace App\Services;

use App\Models\GiftCard;
use App\Params\GiftCardParam;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GiftCardService
{
    public function submit(GiftCardParam $param)
    {
        try {
            return DB::transaction(function () use ($param) {
                $user = Auth::user();

                $giftCard = GiftCard::lockForUpdate()->code($param->code)->first();
                if (! $giftCard) {
                    throw new ModelNotFoundException('Gift card not found.');
                }

                if ($giftCard->isFull()) {
                    throw new \Exception('Gift card fully utilized.');
                }

                $userAlreadyUsed = $user->giftCards()->where('gift_card_id', $giftCard->id)->exists();
                if ($userAlreadyUsed) {
                    throw new \Exception('You have already used this gift card.');
                }

                // Assign the gift to the user with the specified quantity
                $user->giftCards()->attach($giftCard->id, ['quantity' => $giftCard->quantity]);

                // Update remaining balance and users_used on the gift card
                $giftCard->update([
                    'remaining_balance' => $giftCard->remaining_balance - $giftCard->quantity,
                ]);

                // Deposit the specified quantity into the user's account
                // (Assuming you have a 'wallet' relationship on the User model)
//                $user->wallet()->increment('balance', $giftCard->quantity);

                // Notify the user
                // ...

                return 'Gift successfully submitted.';
            });
        } catch (\Exception $e) {
            // Handle exceptions, log errors, etc.
            return 'Failed to submit gift card. '.$e->getMessage();
        }
    }
}
