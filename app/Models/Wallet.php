<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:0',
    ];

    public function increaseBalance(float $qua): bool|int
    {
        return $this->increment('balance', $qua);
    }

    public function decreaseBalance(float $qua): bool|int
    {
        return $this->decrement('balance', $qua);
    }
}
