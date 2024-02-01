<?php

use App\Models\GiftCard;
use App\Models\User;

it('can user use a gift card', function () {
    $gf = GiftCard::factory()->create();

    $response = $this->post(route('gifts.submit', $gf->code), [
        'mobile' => $m = '9128177871',
    ]);

    $user = User::whereMobile($m)->first();
    // Make sure a new user with this number is created
    $this->assertNotnull($user);

    $gff = $gf->fresh();

    // Gift card is updated
    $this->assertEquals($gf->remaining_balance - $gf->quantity, $gff->remaining_balance);
    $this->assertEquals($gf->used_count + 1, $gff->used_count);

    // user wallet is updated
    $this->assertEquals($user->defaultWallet()->balance, $gf->quantity);

    $response->assertSuccessful();
});
