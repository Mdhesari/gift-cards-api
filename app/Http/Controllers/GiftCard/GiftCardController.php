<?php

namespace App\Http\Controllers\GiftCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GiftCardSubmitRequest;
use App\Services\GiftCardService;

class GiftCardController extends Controller
{
    public function __construct(
        private GiftCardService $giftCardSrv
    )
    {
        //
    }

    public function submit(GiftCardSubmitRequest $req)
    {
        $this->giftCardSrv->submit();
    }
}
