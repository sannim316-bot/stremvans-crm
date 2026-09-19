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
        'state',

        'middle_name',
        'nationality',
        'residential_address',
        'country',
        'occupation',
        'employer',

        'client_category',
        'risk_profile',
        'investment_objective',

        'bank_name',
        'bank_code',
        'account_name',
        'account_number',
        'bvn',
        'bank_verified',

        'next_of_kin_name',
        'next_of_kin_relationship',
        'next_of_kin_phone',
        'next_of_kin_email',
        'next_of_kin_address',

        'relationship_manager_id',

        'kyc_approved_at',
        'kyc_approved_by',

    ];

    public function complianceDocuments()
    {
        return $this->hasMany(ComplianceDocument::class);
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function relationshipManager()
    {
        return $this->belongsTo(
            User::class,
            'relationship_manager_id'
        );
    }
    public function notes()
{
    return $this->hasMany(ClientNote::class);
}

    public function kycApprovedBy()
    {
        return $this->belongsTo(
            User::class,
            'kyc_approved_by'
        );
    }
}