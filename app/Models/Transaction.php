<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'portfolio_id',
        'transaction_type',
        'amount',
        'units',
        'nav_price',
        'transaction_date',
        'reference',
        'remarks',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}