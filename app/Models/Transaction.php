<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'type', 'status', 'quantity', 'wallet_id', 'user_id',
    ];

    public function wallet(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function isDeposit(): bool
    {
        return $this->type === TransactionType::Deposit->name;
    }

    public function isWithdraw(): bool
    {
        return $this->type === TransactionType::Withdraw->name;
    }
}
