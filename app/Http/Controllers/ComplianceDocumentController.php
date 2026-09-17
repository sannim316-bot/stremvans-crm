<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComplianceDocument;
use App\Models\Client;

class ComplianceDocumentController extends Controller
{
    public function index(Client $client)
    {
        $documents = $client->complianceDocuments;

        return view('compliance.index',
            compact('client','documents'));
    }

    public function create(Request $request)
    {
        $client = Client::findOrFail($request->client);

        return view('compliance.create',
            compact('client'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'client_id'=>'required',
            'document_type'=>'required',
            'document'=>'required|mimes:jpg,jpeg,png,pdf|max:5120'

        ]);

        $path = $request->file('document')
                        ->store('compliance','public');

        ComplianceDocument::create([

            'client_id'=>$request->client_id,
            'document_type'=>$request->document_type,
            'file_path'=>$path,
            'status'=>'Pending'

        ]);

        return redirect()
            ->route('compliance.index',$request->client_id)
            ->with('success','Document uploaded successfully.');
    }
}