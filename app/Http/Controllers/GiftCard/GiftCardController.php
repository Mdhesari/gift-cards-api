<?php

namespace App\Http\Controllers\GiftCard;

use App\Exceptions\GiftCardAlreadyUsed;
use App\Exceptions\GiftCardIsFull;
use App\Http\Controllers\Controller;
use App\Http\Requests\GiftCardSubmitRequest;
use App\Models\GiftCard;
use App\Params\GiftCardParam;
use App\Services\GiftCardService;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class GiftCardController extends Controller
{
    public function __construct(
        private GiftCardService $giftCardSrv
    )
    {
        //
    }

    /**
     * @throws ValidationException
     */
    public function submit(GiftCardSubmitRequest $req, GiftCard $giftCard)
    {
        try {

            $res = $this->giftCardSrv->submit(
                new GiftCardParam($giftCard->code, $req->mobile)
            );

            return response()->json($res, Response::HTTP_OK);
        } catch (GiftCardAlreadyUsed | GiftCardIsFull $e) {

            throw ValidationException::withMessages([
                'gift_card' => $e->getMessage(),
            ]);
        }
    }
}
