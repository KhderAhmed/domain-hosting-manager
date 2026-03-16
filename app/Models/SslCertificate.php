<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SslCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'issuer',
        'valid_from',
        'valid_to',
        'status'
    ];

    protected $dates = [
        'valid_from',
        'valid_to'
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
    
}