<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DomainController extends Controller
{

    public function index()
    {
        $domains = Domain::latest()->get();

        return Inertia::render('Domains/Index', [
            'domains' => $domains
        ]);
    }

    public function create()
    {
        return Inertia::render('Domains/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'domain_name' => 'required',
            'registrar' => 'nullable',
            'expiry_date' => 'required|date'
        ]);

        $domain = Domain::create($data);

        activity_log(
            'created domain',
            'Domain',
            $domain->id
        );

        return redirect()->route('domains.index');
    }

    public function show(Domain $domain)
    {
        return Inertia::render('Domains/Show', [
            'domain' => $domain->load('dnsRecords', 'ssl')
        ]);
    }

    public function edit(Domain $domain)
    {
        return Inertia::render('Domains/Edit', [
            'domains' => $domain,
        ]);
    }
    public function update(Request $request, Domain $domain)
    {
        $data = $request->validate([
            'domain_name' => ['required', 'string'],
            'registrar' => ['required', 'string'],
            'expiry_date' => ['required', 'string'],


        ]);

        $domain->update($data);

        return redirect()->route('domains.index')
            ->with('success', 'Domains updated');
    }
    public function destroy(Domain $domain)
    {
        $domain->delete();

        return redirect()->route('domains.index')->with('success', 'Domain deleted');
    }
}
