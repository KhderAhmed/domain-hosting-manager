<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_name',
        'registrar',
        'purchase_date',
        'expiry_date',
        'auto_renew',
        'status'
    ];

    protected $dates = [
        'purchase_date',
        'expiry_date'
    ];

    // العلاقة مع DNS
    public function dnsRecords()
    {
        return $this->hasMany(DnsRecord::class);
    }

    // العلاقة مع SSL
    public function ssl()
    {
        return $this->hasOne(SslCertificate::class);
    }

    // العلاقة مع Uptime Monitor
    public function monitors()
    {
        return $this->hasMany(Monitor::class);
    }
}