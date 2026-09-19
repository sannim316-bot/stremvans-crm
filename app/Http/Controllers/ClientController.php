<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $clients = Client::when($search,function($query) use ($search){

            $query->where('first_name','LIKE',"%{$search}%")
                  ->orWhere('last_name','LIKE',"%{$search}%")
                  ->orWhere('client_code','LIKE',"%{$search}%");

        })->latest()->paginate(10);

        return view('clients.index', compact('clients','search'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:clients',
            'phone' => 'required',
            'client_code' => 'required|unique:clients'

        ]);

        $client = Client::create([

            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'other_name' => $request->other_name,

            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,

            'client_code' => $request->client_code,
            'investment_type' => $request->investment_type,
            'investment_amount' => $request->investment_amount,

            'kyc_status' => $request->kyc_status,

            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,

        ]);

        ActivityLogger::log(

            'Create',

            'Clients',

            'Created investor '.$client->first_name.' '.$client->last_name

        );
        \App\Helpers\NotificationHelper::sendToAdmins(
    'New Client Registered',
    $client->first_name.' '.$client->last_name.' was added as a new investor.',
    'success'
);

        return redirect()
                ->route('clients.create')
                ->with('success','Client created successfully.');
    }

    public function show(Client $client)
    {
        $client->load('portfolios');

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $client->update($request->all());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}