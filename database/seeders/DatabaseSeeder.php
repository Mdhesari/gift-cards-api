<?php

namespace Database\Seeders;

use App\Models\GiftCard;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        GiftCard::factory()->count(3)->create([
            'remaining_balance' => 1000,
            'max_users'         => (1000 / $qua = 10),
            'used_count'        => 0,
            'quantity'          => $qua,
        ]);
    }
}
