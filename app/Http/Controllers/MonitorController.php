<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use App\Models\Domain;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MonitorController extends Controller
{
    public function index()
    {
        $monitors = Monitor::with([
            'domain',
            'logs' => function ($q) {
                $q->latest();
            }
        ])->get();

        $downCount = $monitors->filter(fn($m) => $m->logs->first()?->status == 'down')->count();
        $upCount = $monitors->count() - $downCount;

        return Inertia::render('Monitors/Index', [
            'monitors' => $monitors,
            'upCount' => $upCount,
            'downCount' => $downCount
        ]);
    }
}
