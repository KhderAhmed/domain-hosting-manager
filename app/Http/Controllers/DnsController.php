<?php

namespace App\Http\Controllers;

use App\Models\DnsRecord;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DnsController extends Controller
{
  public function index()
  {
    Gate::authorize('viewAny', DnsRecord::class);

    $user = auth()->user();

    $records = $user->is_admin
      ? DnsRecord::with('domain')->latest()->get()
      : DnsRecord::with('domain')
      ->whereHas('domain', fn($q) => $q->where('user_id', $user->id))
      ->latest()
      ->get();

    return Inertia::render('DNS/Index', [
      'records' => $records,
    ]);
  }

  public function create()
  {
    Gate::authorize('create', DnsRecord::class);

    $user = auth()->user();

    $domains = $user->is_admin
      ? Domain::all()
      : Domain::where('user_id', $user->id)->get();

    return Inertia::render('DNS/Create', [
      'domains' => $domains,
    ]);
  }

  public function store(Request $request)
  {
    Gate::authorize('create', DnsRecord::class);

    $user = $request->user();

    $data = $request->validate([
      'domain_id' => [
        'required',
        Rule::exists('domains', 'id')->when(
          ! $user->is_admin,
          fn($q) => $q->where('user_id', $user->id)
        ),
      ],
      'type' => ['required', 'string', 'in:A,AAAA,CNAME,MX,TXT,NS,SRV'],
      'name' => ['required', 'string', 'max:255'],
      'value' => ['required', 'string'],
      'ttl' => ['nullable', 'integer', 'min:60', 'max:86400'],
    ]);

    $data['ttl'] = $data['ttl'] ?? 3600;

    $record = DnsRecord::create($data);

    activity_log('created dns', 'DnsRecord', $record->id);

    return redirect()->route('dns.index')
      ->with('success', 'DNS created');
  }

  public function edit(DnsRecord $dns)
  {
    Gate::authorize('update', $dns);

    $user = auth()->user();

    $domains = $user->is_admin
      ? Domain::all()
      : Domain::where('user_id', $user->id)->get();

    return Inertia::render('DNS/Edit', [
      'dns' => $dns->load('domain'),
      'domains' => $domains,
    ]);
  }

  public function update(Request $request, DnsRecord $dns)
  {
    Gate::authorize('update', $dns);

    $user = $request->user();

    $data = $request->validate([
      'domain_id' => [
        'required',
        Rule::exists('domains', 'id')->when(
          ! $user->is_admin,
          fn($q) => $q->where('user_id', $user->id)
        ),
      ],
      'type' => ['required', 'string', 'in:A,AAAA,CNAME,MX,TXT,NS,SRV'],
      'name' => ['required', 'string', 'max:255'],
      'value' => ['required', 'string'],
      'ttl' => ['nullable', 'integer', 'min:60', 'max:86400'],
    ]);

    $dns->update($data);

    activity_log('updated dns', 'DnsRecord', $dns->id);

    return redirect()->route('dns.index')
      ->with('success', 'DNS updated');
  }

  public function destroy(DnsRecord $dns)
  {
    Gate::authorize('delete', $dns);

    activity_log('deleted dns', 'DnsRecord', $dns->id);

    $dns->delete();

    return redirect()->route('dns.index')
      ->with('success', 'DNS deleted');
  }
}
