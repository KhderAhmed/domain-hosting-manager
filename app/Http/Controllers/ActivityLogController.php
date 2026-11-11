<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $logs = $user->is_admin
            ? ActivityLog::with('user')->orderByDesc('created_at')->get()
            : ActivityLog::with('user')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Logs/Index', [
            'logs' => $logs,
        ]);
    }
}
