<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Inertia\Inertia;
use Illuminate\Http\Request;
class ActivityLogController extends Controller
{

 public function index(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Logs/Index', [
            'logs' => $logs
        ]);

    }

}