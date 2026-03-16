<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'interval',
    ];

    public function domain()
    {
        return $this->belongsTo(\App\Models\Domain::class);
    }

    public function logs()
    {
        return $this->hasMany(\App\Models\ActivityLog::class);
    }
}
