<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServerController extends Controller
{

    public function index()
    {
        return Inertia::render('Servers/Index', [
            'servers' => Server::latest()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Servers/Create');
    }

    public function edit(Server $server)
    {
        return Inertia::render('Servers/Edit', [
            'servers' => $server,
        ]);
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required',
            'ip_address' => 'required',
            'provider' => 'nullable',
            'location' => 'nullable'
        ]);

        Server::create($data);

        return redirect()->route('servers.index');
    }
    public function update(Request $request, Server $server)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'ip_address' => ['required', 'string'],
            'provider' => ['required', 'string'],
            'location' => ['required', 'string'],
            'status' => ['required', 'in:online,offline'],

        ]);

        $server->update($data);

        return redirect()->route('servers.index')
            ->with('success', 'Servers updated');
    }

    public function destroy(Server $server)
    {
        $server->delete();

        return redirect()->route('servers.index')
            ->with('success', 'Servers deleted');
    }
    public function usage(Server $server)
    {
        $server->load('hostingAccounts.domain');

        $totalDisk = $server->hostingAccounts->sum('disk_usage');
        $totalBandwidth = $server->hostingAccounts->sum('bandwidth_usage');

        return Inertia::render('Servers/Usage', [
            'server' => $server,
            'totalDisk' => $totalDisk,
            'totalBandwidth' => $totalBandwidth,
            'accounts' => $server->hostingAccounts
        ]);
    }
}
