<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:0',
    ];

    public function increase(float $qua)
    {
        return $this->update([
            'balance' => intval($this->balance) + $qua,
        ]);
    }
}
