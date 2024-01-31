<?php

use App\Models\GiftCard;

it('can user use giftcard', function () {
    $gf = GiftCard::factory()->create();

    $response = $this->post(route('gifts.submit', $gf->code), [
        'mobile' => '09128177871',
    ]);

    $response->dump()->assertSuccessful();
});
