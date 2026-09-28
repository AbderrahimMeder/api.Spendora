<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\categories;
class Transictions extends Model
{
    use HasUuids;
    protected $table = 'transactions';

    protected $fillable = [
        'account_id',
        'amount',
        'title',
        'type',
        'category_id',
        'description',
        'date',
        'currency',
        'payment_method_id',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
    public function categories():BelongsTo
    {
        return $this->belongsTo(categories::class,'category_id');
    }
    public function payment_methods():BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
}