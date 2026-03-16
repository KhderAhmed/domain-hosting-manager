<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'server_id',
        'username',
        'panel',
        'disk_usage',
        'bandwidth_usage'
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}