<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundNav extends Model
{
    protected $fillable = [
        'fund_id',
        'nav_price',
        'nav_date',
        'created_by',
    ];

    protected $casts = [
        'nav_date' => 'date',
    ];

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}