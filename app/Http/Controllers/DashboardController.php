<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Portfolio;
use App\Models\Transaction;
use App\Models\ComplianceDocument;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();

        $activeInvestments = Portfolio::where('status','Active')->count();

        $aum = Transaction::where('transaction_type','Buy')->sum('amount')
             - Transaction::where('transaction_type','Redeem')->sum('amount');

        $pendingKYC = ComplianceDocument::where('status','Pending')->count();

        $monthlyInvestments = Transaction::selectRaw("
                MONTH(transaction_date) as month,
                SUM(amount) as total
            ")
            ->where('transaction_type','Buy')
            ->groupByRaw('MONTH(transaction_date)')
            ->orderByRaw('MONTH(transaction_date)')
            ->get();

        $uploadedDocuments = ComplianceDocument::count();

        $approvedDocuments = ComplianceDocument::where('status','Approved')->count();

        $completionRate = $uploadedDocuments > 0
            ? round(($approvedDocuments / $uploadedDocuments) * 100)
            : 0;

        $recentTransactions = Transaction::latest()
                                ->take(5)
                                ->with('portfolio.client')
                                ->get();

        return view('dashboard.index', compact(
            'totalClients',
            'activeInvestments',
            'aum',
            'pendingKYC',
            'monthlyInvestments',
            'completionRate',
            'recentTransactions'
        ));
    }
}