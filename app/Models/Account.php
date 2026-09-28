<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasUuids;
    protected $fillable = [
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function transictions()
    {
        return $this->hasMany(Transiction::class);
    }
}
