<?php

use App\Models\GiftCard;
use App\Models\User;
use App\Params\GiftCardParam;
use App\Services\GiftCardService;

it('can user get wallet details', function () {
    $user = User::factory()->create([
        'mobile' => $m = '9128177871',
    ]);

    $gf = GiftCard::factory()->create();

    app(GiftCardService::class)->submit(
        new GiftCardParam(
            $gf->code,
            $m,
        )
    );

    $response = $this->get(route('wallets.details', $m));

    $response->dump()->assertSuccessful()->assertJson([
        'data' => [
            'balance' => $user->defaultWallet()->balance,
        ]
    ]);
});
