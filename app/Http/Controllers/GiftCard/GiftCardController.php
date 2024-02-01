<?php

namespace App\Http\Controllers\GiftCard;

use App\Exceptions\GiftCardAlreadyUsedException;
use App\Exceptions\GiftCardFullyUtilizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\GiftCardSubmitRequest;
use App\Params\GiftCardParam;
use App\Services\GiftCardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GiftCardController extends Controller
{
    public function __construct(
        private GiftCardService $giftCardSrv
    )
    {
        //
    }

    /**
     * @param GiftCardSubmitRequest $req
     * @param $giftCardCode
     * @return JsonResponse
     */
    public function submit(GiftCardSubmitRequest $req, $giftCardCode): JsonResponse
    {
        try {

            $res = $this->giftCardSrv->submit(
                new GiftCardParam($giftCardCode, $req->mobile)
            );

            return response()->json($res, Response::HTTP_OK);
        } catch (GiftCardAlreadyUsedException | GiftCardFullyUtilizedException $e) {

            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function statistics(Request $req, $giftCardId)
    {
        $res = $this->giftCardSrv->getStatistics($giftCardId);

        return response()->json($res, Response::HTTP_OK);
    }
}
