<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Portfolio;
use App\Models\Transaction;
use App\Models\ComplianceDocument;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $clients = Client::count();

        $aum = Portfolio::with('transactions')
            ->where('status', 'Active')
            ->get()
            ->sum(function ($portfolio) {

                return $portfolio->current_value;

            });

        $transactions = Transaction::count();

        $pendingKYC = ComplianceDocument::where('status','Pending')->count();

        return view('reports.index',compact(
            'clients',
            'aum',
            'transactions',
            'pendingKYC'
        ));
    }

    public function investorStatement(Client $client)
    {
        $client->load([
            'portfolios.transactions',
            'complianceDocuments'
        ]);

        return view('reports.investor',compact('client'));
    }

    public function downloadStatement(Client $client)
    {
        $client->load([
            'portfolios.transactions',
            'complianceDocuments'
        ]);

        $pdf = Pdf::loadView('reports.investor-pdf',[
            'client'=>$client
        ]);

        return $pdf->download(
            'STM-Statement-'.$client->client_code.'.pdf'
        );
    }
}