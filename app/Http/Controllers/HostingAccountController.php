<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Server;
use App\Models\HostingAccount;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HostingAccountController extends Controller
{

    public function index()
    {
        $accounts = HostingAccount::with(['domain','server'])->get();

        return Inertia::render('Hosting/Index',[
            'accounts'=>$accounts
        ]);
    }

    public function create()
    {
        return Inertia::render('Hosting/Create',[
            'domains'=>Domain::all(),
            'servers'=>Server::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'domain_id'=>'required|exists:domains,id',
            'server_id'=>'required|exists:servers,id',
            'username'=>'nullable|string',
            'panel'=>'nullable|string',
            'disk_usage'=>'nullable|integer',
            'bandwidth_usage'=>'nullable|integer',
            'status'=>'required|in:active,suspended'
        ]);

        HostingAccount::create($data);

        return redirect()->route('hosting.index');
    }

    public function edit(HostingAccount $hosting)
    {
        return Inertia::render('Hosting/Edit',[
            'hosting'=>$hosting,
            'domains'=>Domain::all(),
            'servers'=>Server::all()
        ]);
    }

    public function update(Request $request, HostingAccount $hosting)
    {
        $data = $request->validate([
            'domain_id'=>'required|exists:domains,id',
            'server_id'=>'required|exists:servers,id',
            'username'=>'nullable|string',
            'panel'=>'nullable|string',
            'disk_usage'=>'nullable|integer',
            'bandwidth_usage'=>'nullable|integer',
            'status'=>'required|in:active,suspended'
        ]);

        $hosting->update($data);

        return redirect()->route('hosting.index');
    }

    public function destroy(HostingAccount $hosting)
    {
        $hosting->delete();

        return redirect()->route('hosting.index');
    }
}