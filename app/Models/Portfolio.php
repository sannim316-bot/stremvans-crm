<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'client_id',
        'fund_name',
        'investment_type',
        'amount_invested',
        'units',
        'nav_price',
        'investment_date',
        'status',

        'maturity_date',
        'custodian_bank',
        'custodian_account_name',
        'current_nav_price',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}