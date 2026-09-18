<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComplianceDocument;
use App\Models\Client;
use App\Helpers\ActivityLogger;

class ComplianceDocumentController extends Controller
{
    public function index(Client $client)
    {
        $documents = $client->complianceDocuments;

        return view('compliance.index',
            compact('client','documents'));
    }

    public function all()
    {
        $documents = ComplianceDocument::with('client')
                        ->latest()
                        ->paginate(15);

        return view('compliance.all', compact('documents'));
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

    public function approve(ComplianceDocument $document)
    {
        $document->update(['status' => 'Approved']);

        ActivityLogger::log(

            'Approve',

            'Compliance',

            'Approved '.$document->document_type.
            ' for '.$document->client->first_name

        );

        return redirect()
            ->route('compliance.index',$document->client_id)
            ->with('success','Document approved successfully.');
    }

    public function reject(ComplianceDocument $document)
    {
        $document->update(['status' => 'Rejected']);

        ActivityLogger::log(

            'Reject',

            'Compliance',

            'Rejected '.$document->document_type.
            ' for '.$document->client->first_name

        );

        return redirect()
            ->route('compliance.index',$document->client_id)
            ->with('success','Document rejected.');
    }
}