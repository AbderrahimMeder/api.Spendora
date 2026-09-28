<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialAccount extends Model
{
    use HasUuids;
    protected $table = 'account_financail';

    protected $fillable = [
        'account_id',
        'name',
        'type',
        'balance',
        'currency',
        'active',
        // zid les colonnes dyalk hna
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

}