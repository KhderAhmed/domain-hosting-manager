<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Domain;
use App\Models\Server;
use App\Models\Monitor;

class DashboardController extends Controller
{
    public function index()
    {
        $domains = Domain::count();

        $servers = Server::count();

        $expiring = Domain::whereDate(
            'expiry_date',
            '<=',
            now()->addDays(30)
        )->count();

        $down = Monitor::where('last_status','down')->count();

        return Inertia::render('Dashboard',[
            'stats'=>[
                'domains'=>$domains,
                'servers'=>$servers,
                'expiring'=>$expiring,
                'down'=>$down
            ]
        ]);
    }
}
