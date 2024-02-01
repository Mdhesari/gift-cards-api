<?php

use App\Models\GiftCard;
use App\Params\GiftCardParam;
use App\Services\GiftCardService;

it('can get gift card statistics', function () {
    $gf = GiftCard::factory()->create();

    app(GiftCardService::class)->submit(
        new GiftCardParam(
            $gf->code,
            '9128177871',
        )
    );

    $response = $this->get(route('gifts.statistics', $gf->id));

    $gf->refresh();

    $response->assertSuccessful()->assertJson([
        'data' => [
            'remaining_balance' => $gf->remaining_balance,
            'remaining_users'   => $gf->max_users - $gf->used_count,
            'max_users'         => $gf->max_users,
        ]
    ])->assertJsonStructure([
        'data' => [
            'users',
        ]
    ]);
});
