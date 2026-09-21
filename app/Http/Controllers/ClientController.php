<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        $relationshipManagers = User::where('status', 'active')
            ->whereIn('role', ['relationship_officer', 'admin'])
            ->orderBy('name')
            ->get();

        return view('clients.create', compact('relationshipManagers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            // Personal
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:clients',
            'phone' => 'required|string|max:30',

            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:Male,Female',
            'nationality' => 'nullable|string|max:100',

            'residential_address' => 'nullable|string|max:1000',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',

            'occupation' => 'nullable|string|max:255',
            'employer' => 'nullable|string|max:255',

            // Investor Profile
            'client_category' =>
                'required|in:Retail,HNI,Corporate,Institutional',

            'risk_profile' =>
                'nullable|in:Conservative,Moderate,Aggressive',

            'investment_objective' =>
                'nullable|in:Capital Preservation,Income,Growth,Income and Growth',

            'relationship_manager_id' =>
                'nullable|exists:users,id',

            // Bank
            'bank_name' => 'nullable|string|max:255',

            'account_number' =>
                'nullable|digits:10',

            'account_name' =>
                'nullable|string|max:255',

            'bvn' =>
                'nullable|digits:11',

            // Next of Kin
            'next_of_kin_name' =>
                'nullable|string|max:255',

            'next_of_kin_relationship' =>
                'nullable|string|max:100',

            'next_of_kin_phone' =>
                'nullable|string|max:30',

            'next_of_kin_email' =>
                'nullable|email|max:255',

            'next_of_kin_address' =>
                'nullable|string|max:1000',

        ]);

        $validated['kyc_status'] = 'Pending';
        $validated['bank_verified'] = false;
        $validated['client_code'] = 'STM-' . strtoupper(Str::random(8));

        $client = Client::create($validated);

        ActivityLogger::log(

            'Create',

            'Clients',

            'Created investor '.$client->first_name.' '.$client->last_name.
            ' ('.$client->client_code.')'

        );

        \App\Helpers\NotificationHelper::sendToAdmins(
            'New Client Registered',
            $client->first_name.' '.$client->last_name.' was added as a new investor.',
            'success'
        );

        return redirect()
                ->route('clients.show', $client)
                ->with('success','Investor created successfully.');
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