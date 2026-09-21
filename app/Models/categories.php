<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    //
    use HasUuids;
    protected $fillable = [
        'account_id',
        'name',
        'slug',
        'description',
        'max_budget',
        'budget_period',
        'category_image',
        'category_color',
        'type',
    ];

    public function transactions():HasMany
    {
        return $this->hasMany(Transictions::class);
    }
    public function account():BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }
}
