<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Portfolio;
use App\Models\Transaction;
use App\Models\ComplianceDocument;
use App\Models\ClientNote;

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

        $upcomingFollowUps = ClientNote::with(['client', 'user'])
            ->whereNotNull('follow_up_date')
            ->where('follow_up_date', '>=', now())

            ->when(
                auth()->user()->role === 'relationship_officer',
                function ($query) {
                    $query->where('user_id', auth()->id());
                }
            )

            ->orderBy('follow_up_date')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalClients',
            'activeInvestments',
            'aum',
            'pendingKYC',
            'monthlyInvestments',
            'completionRate',
            'recentTransactions',
            'upcomingFollowUps'
        ));
    }
}