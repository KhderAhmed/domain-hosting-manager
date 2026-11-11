<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Server;
use App\Models\HostingAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class HostingAccountController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', HostingAccount::class);

        $user = auth()->user();

        $accounts = $user->is_admin
            ? HostingAccount::with(['domain', 'server'])->latest()->get()
            : HostingAccount::with(['domain', 'server'])
            ->whereHas('domain', fn($q) => $q->where('user_id', $user->id))
            ->latest()
            ->get();

        return Inertia::render('Hosting/Index', [
            'accounts' => $accounts,
        ]);
    }

    public function create()
    {
        Gate::authorize('create', HostingAccount::class);

        $user = auth()->user();

        $domains = $user->is_admin
            ? Domain::all()
            : Domain::where('user_id', $user->id)->get();

        return Inertia::render('Hosting/Create', [
            'domains' => $domains,
            'servers' => Server::all(),
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', HostingAccount::class);

        $user = $request->user();

        $data = $request->validate([
            'domain_id' => [
                'required',
                Rule::exists('domains', 'id')->when(
                    ! $user->is_admin,
                    fn($q) => $q->where('user_id', $user->id)
                ),
            ],
            'server_id' => ['required', 'exists:servers,id'],
            'username' => ['nullable', 'string', 'max:255'],
            'panel' => ['nullable', 'string', 'max:255'],
            'disk_usage' => ['nullable', 'integer', 'min:0'],
            'bandwidth_usage' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,suspended'],
        ]);

        $hosting = HostingAccount::create($data);

        activity_log('created hosting', 'HostingAccount', $hosting->id);

        return redirect()->route('hosting.index')
            ->with('success', 'Hosting account created');
    }

    public function edit(HostingAccount $hosting)
    {
        Gate::authorize('update', $hosting);

        $user = auth()->user();

        $domains = $user->is_admin
            ? Domain::all()
            : Domain::where('user_id', $user->id)->get();

        return Inertia::render('Hosting/Edit', [
            'hosting' => $hosting->load(['domain', 'server']),
            'domains' => $domains,
            'servers' => Server::all(),
        ]);
    }

    public function update(Request $request, HostingAccount $hosting)
    {
        Gate::authorize('update', $hosting);

        $user = $request->user();

        $data = $request->validate([
            'domain_id' => [
                'required',
                Rule::exists('domains', 'id')->when(
                    ! $user->is_admin,
                    fn($q) => $q->where('user_id', $user->id)
                ),
            ],
            'server_id' => ['required', 'exists:servers,id'],
            'username' => ['nullable', 'string', 'max:255'],
            'panel' => ['nullable', 'string', 'max:255'],
            'disk_usage' => ['nullable', 'integer', 'min:0'],
            'bandwidth_usage' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,suspended'],
        ]);

        $hosting->update($data);

        activity_log('updated hosting', 'HostingAccount', $hosting->id);

        return redirect()->route('hosting.index')
            ->with('success', 'Hosting account updated');
    }

    public function destroy(HostingAccount $hosting)
    {
        Gate::authorize('delete', $hosting);

        activity_log('deleted hosting', 'HostingAccount', $hosting->id);

        $hosting->delete();

        return redirect()->route('hosting.index')
            ->with('success', 'Hosting account deleted');
    }
}
