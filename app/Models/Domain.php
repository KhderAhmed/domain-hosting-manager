<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'domain_name',
        'registrar',
        'purchase_date',
        'expiry_date',
        'auto_renew',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'expiry_date'   => 'date',
            'auto_renew'    => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dnsRecords(): HasMany
    {
        return $this->hasMany(DnsRecord::class);
    }

    public function ssl(): HasOne
    {
        return $this->hasOne(SslCertificate::class);
    }

    public function monitors(): HasMany
    {
        return $this->hasMany(Monitor::class);
    }
}