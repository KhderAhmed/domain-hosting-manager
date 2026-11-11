<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ServerController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Server::class);

        return Inertia::render('Servers/Index', [
            'servers' => Server::with('user')->latest()->get(),
        ]);
    }

    public function create()
    {
        Gate::authorize('create', Server::class);

        return Inertia::render('Servers/Create');
    }

    public function edit(Server $server)
    {
        Gate::authorize('update', $server);

        return Inertia::render('Servers/Edit', [
            'servers' => $server,
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Server::class);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ip_address' => ['required', 'ip'],
            'provider' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $data['user_id'] = $request->user()->id;

        $server = Server::create($data);

        activity_log('created server', 'Server', $server->id);

        return redirect()->route('servers.index')
            ->with('success', 'Server created');
    }

    public function update(Request $request, Server $server)
    {
        Gate::authorize('update', $server);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ip_address' => ['required', 'ip'],
            'provider' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:online,offline'],
        ]);

        $server->update($data);

        activity_log('updated server', 'Server', $server->id);

        return redirect()->route('servers.index')
            ->with('success', 'Server updated');
    }

    public function destroy(Server $server)
    {
        Gate::authorize('delete', $server);

        activity_log('deleted server', 'Server', $server->id);

        $server->delete();

        return redirect()->route('servers.index')
            ->with('success', 'Server deleted');
    }

    public function usage(Server $server)
    {
        Gate::authorize('view', $server);

        $server->load('hostingAccounts.domain');

        return Inertia::render('Servers/Usage', [
            'server' => $server,
            'totalDisk' => $server->hostingAccounts->sum('disk_usage'),
            'totalBandwidth' => $server->hostingAccounts->sum('bandwidth_usage'),
            'accounts' => $server->hostingAccounts,
        ]);
    }
}
