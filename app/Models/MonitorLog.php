<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitor_id',
        'status',
        'response_time_ms',
        'status_code',
        'error_message',
    ];

    public function monitor(): BelongsTo
    {
        return $this->belongsTo(Monitor::class);
    }
}