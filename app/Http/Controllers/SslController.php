<?php

namespace App\Http\Controllers;

use App\Models\SslCertificate;
use App\Models\Domain;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SslController extends Controller
{
    // عرض كل الشهادات
    public function index()
    {
        $certs = SslCertificate::with('domain')->get()->map(function ($cert) {

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
            'certs' => $certs
        ]);
    }

    // صفحة إضافة شهادة جديدة
    public function create()
    {
        $domains = Domain::all();
        return Inertia::render('SSL/Create', [
            'domains' => $domains
        ]);
    }

    // تخزين شهادة جديدة
    public function store(Request $request)
    {
        $data = $request->validate([
            'domain_id' => 'required|exists:domains,id',
            'issuer' => 'required|string',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date',
            'status' => 'required|in:valid,expired',
        ]);

        SslCertificate::create($data);

        return redirect()->route('ssl.index');
    }

    // صفحة تعديل شهادة
    public function edit(SslCertificate $ssl)
    {
        $domains = Domain::all();
        return Inertia::render('SSL/Edit', [
            'ssl' => $ssl,
            'domains' => $domains
        ]);
    }

    // تحديث الشهادة
    public function update(Request $request, SslCertificate $ssl)
    {
        $data = $request->validate([
            'domain_id' => 'required|exists:domains,id',
            'issuer' => 'required|string',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date',
            'status' => 'required|in:valid,expired',
        ]);

        $ssl->update($data);

        return redirect()->route('ssl.index');
    }

    // حذف الشهادة
    public function destroy(SslCertificate $ssl)
    {
        $ssl->delete();
        return redirect()->route('ssl.index');
    }
}
