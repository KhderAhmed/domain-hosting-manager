<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\DomainRequest;
use Illuminate\Support\Facades\Gate;

class DomainController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $domains = $user->is_admin
            ? Domain::with('user')->latest()->get()
            : $user->domains()->latest()->get();

        return Inertia::render('Domains/Index', [
            'domains' => $domains,
        ]);
    }

    public function store(DomainRequest $request)
    {
        $domain = $request->user()->domains()->create($request->validated());

        activity_log('created domain', 'Domain', $domain->id);

        return redirect()->route('domains.index');
    }

    public function show(Domain $domain)
    {
        Gate::authorize('view', $domain);

        return Inertia::render('Domains/Show', [
            'domain' => $domain->load('dnsRecords', 'ssl'),
        ]);
    }

    public function edit(Domain $domain)
    {
        Gate::authorize('update', $domain);

        return Inertia::render('Domains/Edit', ['domains' => $domain]);
    }

    public function update(DomainRequest $request, Domain $domain)
    {
        Gate::authorize('update', $domain);

        $domain->update($request->validated());
        activity_log('updated domain', 'Domain', $domain->id);

        return redirect()->route('domains.index')->with('success', 'Domain updated');
    }

    public function destroy(Domain $domain)
    {
        Gate::authorize('delete', $domain);

        activity_log('deleted domain', 'Domain', $domain->id);
        $domain->delete();

        return redirect()->route('domains.index')->with('success', 'Domain deleted');
    }

    public function create()
    {
        return Inertia::render('Domains/Create');
    }
}
