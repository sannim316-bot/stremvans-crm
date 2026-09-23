<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'client_id',
        'fund_id',
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

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getCurrentUnitsAttribute()
    {
        if ($this->relationLoaded('transactions')) {
            $transactions = $this->transactions;
        } else {
            $transactions = $this->transactions()->get();
        }

        $buyUnits = $transactions
            ->where('transaction_type', 'Buy')
            ->sum('units');

        $bonusUnits = $transactions
            ->where('transaction_type', 'Bonus Units')
            ->sum('units');

        $redeemedUnits = $transactions
            ->where('transaction_type', 'Redeem')
            ->sum('units');

        return $buyUnits + $bonusUnits - $redeemedUnits;
    }

    public function getNetContributionsAttribute()
    {
        if ($this->relationLoaded('transactions')) {
            $transactions = $this->transactions;
        } else {
            $transactions = $this->transactions()->get();
        }

        $buys = $transactions
            ->where('transaction_type', 'Buy')
            ->sum('amount');

        $redemptions = $transactions
            ->where('transaction_type', 'Redeem')
            ->sum('amount');

        return $buys - $redemptions;
    }

    public function getCurrentNavAttribute()
    {
        if ($this->fund) {
            return (float) $this->fund->current_nav;
        }

        if ($this->current_nav_price !== null) {
            return (float) $this->current_nav_price;
        }

        return (float) $this->nav_price;
    }

    public function getCurrentValueAttribute()
    {
        return $this->current_units * $this->current_nav;
    }
}