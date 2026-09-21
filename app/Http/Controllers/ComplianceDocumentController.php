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

        \App\Helpers\NotificationHelper::sendToAdmins(
            'New Compliance Document',
            'A '.$request->document_type.' was uploaded and needs approval.',
            'warning'
        );

        return redirect()
            ->route('compliance.index',$request->client_id)
            ->with('success','Document uploaded successfully.');
    }

    public function approve(Request $request, ComplianceDocument $document)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);

        $document->update([
            'status' => 'Approved',
            'remarks' => $request->remarks,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $this->updateClientKycStatus($document->client);

        ActivityLogger::log(
            'Approve',
            'Compliance',
            'Approved '.$document->document_type.
            ' for '.$document->client->first_name.' '.
            $document->client->last_name
        );

        return back()->with(
            'success',
            'Document approved successfully.'
        );
    }

    public function reject(Request $request, ComplianceDocument $document)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $document->update([
            'status' => 'Rejected',
            'remarks' => $request->remarks,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $this->updateClientKycStatus($document->client);

        ActivityLogger::log(
            'Reject',
            'Compliance',
            'Rejected '.$document->document_type.
            ' for '.$document->client->first_name.' '.
            $document->client->last_name
        );

        return back()->with(
            'success',
            'Document rejected.'
        );
    }

    private function updateClientKycStatus(Client $client)
    {
        $requiredDocuments = [
            'Passport',
            'NIN',
            'Signature',
            'Proof of Address',
        ];

        $documents = $client
            ->complianceDocuments()
            ->whereIn('document_type', $requiredDocuments)
            ->get()
            ->groupBy('document_type');

        $hasRejected = collect($requiredDocuments)
            ->contains(function ($type) use ($documents) {

                if (!$documents->has($type)) {
                    return false;
                }

                $latest = $documents[$type]
                    ->sortByDesc('created_at')
                    ->first();

                return $latest->status === 'Rejected';
            });

        if ($hasRejected) {

            $client->update([
                'kyc_status' => 'Rejected',
                'kyc_approved_at' => null,
                'kyc_approved_by' => null,
            ]);

            return;
        }

        $allApproved = collect($requiredDocuments)
            ->every(function ($type) use ($documents) {

                if (!$documents->has($type)) {
                    return false;
                }

                $latest = $documents[$type]
                    ->sortByDesc('created_at')
                    ->first();

                return $latest->status === 'Approved';
            });

        if ($allApproved) {

            $client->update([
                'kyc_status' => 'Approved',
                'kyc_approved_at' => now(),
                'kyc_approved_by' => auth()->id(),
            ]);

        } else {

            $client->update([
                'kyc_status' => 'Pending',
                'kyc_approved_at' => null,
                'kyc_approved_by' => null,
            ]);
        }
    }
}