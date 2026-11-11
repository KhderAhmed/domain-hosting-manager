<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MonitorController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Monitor::with([
            'domain',
            'logs' => fn($q) => $q->latest(),
        ]);

        if (! $user->is_admin) {
            $query->whereHas('domain', fn($q) => $q->where('user_id', $user->id));
        }

        $monitors = $query->get();

        $downCount = $monitors->filter(
            fn($m) => $m->logs->first()?->status === 'down'
        )->count();

        $upCount = $monitors->count() - $downCount;

        return Inertia::render('Monitors/Index', [
            'monitors' => $monitors,
            'upCount' => $upCount,
            'downCount' => $downCount,
        ]);
    }
}
