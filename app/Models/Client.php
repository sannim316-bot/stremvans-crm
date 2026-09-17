<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [

        'first_name',
        'last_name',
        'other_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'client_code',
        'investment_type',
        'investment_amount',
        'kyc_status',
        'address',
        'city',
        'state'

    ];

public function complianceDocuments()
{
    return $this->hasMany(ComplianceDocument::class);
}
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }
}