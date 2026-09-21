<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientNote;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class ClientNoteController extends Controller
{
    public function store(Request $request, Client $client)
    {
        $validated = $request->validate([
            'interaction_type' => 'required|in:Phone Call,Office Meeting,Virtual Meeting,Email,WhatsApp,Other',
            'interaction_date' => 'required|date',
            'note' => 'required|string|max:5000',
            'follow_up_date' => 'nullable|date|after_or_equal:interaction_date',
        ]);

        $validated['client_id'] = $client->id;
        $validated['user_id'] = auth()->id();

        $note = ClientNote::create($validated);

        ActivityLogger::log(
            'Create',
            'Client Notes',
            'Added '.$note->interaction_type.
            ' note for '.$client->first_name.' '.$client->last_name
        );

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Client note added successfully.');
    }


    public function destroy(ClientNote $note)
    {
        $client = $note->client;

        ActivityLogger::log(
            'Delete',
            'Client Notes',
            'Deleted relationship note for '.
            $client->first_name.' '.$client->last_name
        );

        $note->delete();

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Client note deleted.');
    }
}