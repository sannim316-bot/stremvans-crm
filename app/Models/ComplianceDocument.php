<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplianceDocument extends Model
{
    protected $fillable = [
        'client_id',
        'document_type',
        'file_path',
        'status',
        'remarks'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}