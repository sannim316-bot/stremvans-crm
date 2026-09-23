<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $fillable = [
        'name',
        'code',
        'fund_type',
        'currency',
        'current_nav',
        'nav_date',
        'status',
    ];

    protected $casts = [
        'nav_date' => 'date',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function navHistory()
    {
        return $this->hasMany(FundNav::class);
    }
}