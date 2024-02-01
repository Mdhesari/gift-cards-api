<?php

use App\Exceptions\GiftCardAlreadyUsedException;
use App\Exceptions\GiftCardFullyUtilizedException;
use App\Models\GiftCard;
use App\Models\User;
use App\Params\GiftCardParam;
use App\Services\GiftCardService;

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

it('user cannot submit an invalid or already-used gift card', function () {
    $gf = GiftCard::factory()->create([
        'max_users'  => 10,
        'used_count' => 10,
    ]);

    $response = $this->post(route('gifts.submit', $gf->code), [
        'mobile' => $m = '9128177871',
    ]);

    $response->assertBadRequest()->assertJson([
        'error' => (new GiftCardFullyUtilizedException)->getMessage(),
    ]);
});

it('user cannot submit a gift card twice', function () {
    $gf = GiftCard::factory()->create();

    app(GiftCardService::class)->submit(new GiftCardParam(
        $gf->code,
        $m = '9128177871',
    ));

    $response = $this->post(route('gifts.submit', $gf->code), [
        'mobile' => $m,
    ]);

    $response->assertBadRequest()->assertJson([
        'error' => (new GiftCardAlreadyUsedException)->getMessage(),
    ]);
});
