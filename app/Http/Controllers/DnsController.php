<?php

namespace App\Http\Controllers;

use App\Models\DnsRecord;
use App\Models\Domain;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DnsController extends Controller
{
  public function index()
  {
    $records = DnsRecord::with('domain')->latest()->get();

    return Inertia::render('DNS/Index', [
      'records' => $records
    ]);
  }

  public function create()
  {
    return Inertia::render('DNS/Create', [
      'domains' => Domain::all()
    ]);
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'domain_id' => ['required', 'exists:domains,id'],
      'type' => ['required', 'string'],
      'name' => ['required', 'string'],
      'value' => ['required', 'string'],
      'ttl' => ['nullable', 'integer']
    ]);

    $data['ttl'] = $data['ttl'] ?? 3600;

    DnsRecord::create($data);

    return redirect()->route('dns.index')
      ->with('success', 'DNS created');
  }

  public function edit(DnsRecord $dns)
  {
    return Inertia::render('DNS/Edit', [
      'dns' => $dns,
      'domains' => Domain::all()
    ]);
  }

  public function update(Request $request, DnsRecord $dns)
  {
    $data = $request->validate([
      'domain_id' => ['required', 'exists:domains,id'],
      'type' => ['required', 'string'],
      'name' => ['required', 'string'],
      'value' => ['required', 'string'],
      'ttl' => ['nullable', 'integer']
    ]);

    $dns->update($data);

    return redirect()->route('dns.index')
      ->with('success', 'DNS updated');
  }

  public function destroy(DnsRecord $dns)
  {
    $dns->delete();

    return redirect()->route('dns.index')
      ->with('success', 'DNS deleted');
  }
}
