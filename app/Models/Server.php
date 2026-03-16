<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip_address',
        'provider',
        'location',
        'status'
    ];

    // علاقة مع الدومينات إذا ربطت مع Hosting
   public function hostingAccounts()
{
    return $this->hasMany(HostingAccount::class);
}
}