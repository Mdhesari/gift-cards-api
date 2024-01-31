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
        'users_used',
        'quantity',
    ];

    public static function scopeCode($query, $code)
    {
        return $query->whereCode($code);
    }

    public function decrease()
    {
        return $this->update([
            'remaining_balance' => $this->remaining_balance - $this->quantity,
        ]);
    }

    public function isFull(): bool
    {
        return $this->users_used >= $this->max_users;
    }
}
