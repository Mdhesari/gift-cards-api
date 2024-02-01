<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletDetailResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletDetailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        // in order to load all cols
        $wallet = $user->defaultWallet()->fresh();

        return response()->json(
            new WalletDetailResource([
                'data' => [
                    'balance'      => $wallet->balance,
                    'transactions' => $wallet->transactions ?: [], //Todo: for large transaction it's better to paginate
                ]
            ]),
            Response::HTTP_OK
        );
    }
}
