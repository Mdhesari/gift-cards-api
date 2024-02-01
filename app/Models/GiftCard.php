<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftCard extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'code',
        'remaining_balance',
        'max_users',
        'used_count',
        'quantity',
    ];

    public static function scopeCode($query, $code)
    {
        return $query->whereCode($code);
    }

    public function decreaseBalance(float|int $qua): bool|int
    {
        return $this->decrement('remaining_balance', $qua);
    }

    public function increaseUsed(int $count = 1): bool|int
    {
        return $this->increment('used_count', $count);
    }

    public function isFull(): bool
    {
        return $this->used_count >= $this->max_users;
    }
}
