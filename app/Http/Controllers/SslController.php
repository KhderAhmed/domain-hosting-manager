<?php

namespace App\Http\Controllers;

use App\Models\SslCertificate;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SslController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', SslCertificate::class);

        $user = auth()->user();

        $query = SslCertificate::with('domain');

        if (! $user->is_admin) {
            $query->whereHas('domain', fn ($q) => $q->where('user_id', $user->id));
        }

        $certs = $query->get()->map(function ($cert) {
            $cert->days_left = (int) now()->diffInDays($cert->valid_to, false);

            if ($cert->days_left <= 0) {
                $cert->status = 'expired';
            } elseif ($cert->days_left <= 15) {
                $cert->status = 'expiring_soon';
            } else {
                $cert->status = 'valid';
            }

            return $cert;
        });

        return Inertia::render('SSL/Index', [
            'certs' => $certs,
        ]);
    }

    public function create()
    {
        Gate::authorize('create', SslCertificate::class);

        $user = auth()->user();

        $domains = $user->is_admin
            ? Domain::all()
            : Domain::where('user_id', $user->id)->get();

        return Inertia::render('SSL/Create', [
            'domains' => $domains,
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', SslCertificate::class);

        $user = $request->user();

        $data = $request->validate([
            'domain_id' => [
                'required',
                Rule::exists('domains', 'id')->when(
                    ! $user->is_admin,
                    fn ($q) => $q->where('user_id', $user->id)
                ),
            ],
            'issuer' => ['required', 'string', 'max:255'],
            'valid_from' => ['required', 'date'],
            'valid_to' => ['required', 'date', 'after:valid_from'],
            'status' => ['required', 'in:valid,expired'],
        ]);

        $ssl = SslCertificate::create($data);

        activity_log('created ssl', 'SslCertificate', $ssl->id);

        return redirect()->route('ssl.index');
    }

    public function edit(SslCertificate $ssl)
    {
        Gate::authorize('update', $ssl);

        $user = auth()->user();

        $domains = $user->is_admin
            ? Domain::all()
            : Domain::where('user_id', $user->id)->get();

        return Inertia::render('SSL/Edit', [
            'ssl' => $ssl->load('domain'),
            'domains' => $domains,
        ]);
    }

    public function update(Request $request, SslCertificate $ssl)
    {
        Gate::authorize('update', $ssl);

        $user = $request->user();

        $data = $request->validate([
            'domain_id' => [
                'required',
                Rule::exists('domains', 'id')->when(
                    ! $user->is_admin,
                    fn ($q) => $q->where('user_id', $user->id)
                ),
            ],
            'issuer' => ['required', 'string', 'max:255'],
            'valid_from' => ['required', 'date'],
            'valid_to' => ['required', 'date', 'after:valid_from'],
            'status' => ['required', 'in:valid,expired'],
        ]);

        $ssl->update($data);

        activity_log('updated ssl', 'SslCertificate', $ssl->id);

        return redirect()->route('ssl.index');
    }

    public function destroy(SslCertificate $ssl)
    {
        Gate::authorize('delete', $ssl);

        activity_log('deleted ssl', 'SslCertificate', $ssl->id);

        $ssl->delete();

        return redirect()->route('ssl.index');
    }
}