<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PaymentMethod extends Model
{
    use HasUuids;


    protected $table = 'payment_methods';
    protected $fillable = [
        'account_id',
        'name',
        'type',
        'is_active_method',
    ];
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function transictions(): HasMany
    {
        return $this->hasMany(Transictions::class);
    }
}
