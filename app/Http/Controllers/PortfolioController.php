<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Client;
use App\Models\Fund;
use App\Models\Transaction;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function all()
    {
        $portfolios = Portfolio::with('client')
                        ->latest()
                        ->paginate(15);

        return view('portfolio.all', compact('portfolios'));
    }

    public function create(Request $request)
    {
        $client = Client::findOrFail($request->client);

        $funds = Fund::where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('portfolio.create', compact('client', 'funds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',

            'fund_id' => 'required|exists:funds,id',

            'amount_invested' => 'required|numeric|min:0.01',

            'investment_date' => 'required|date|before_or_equal:today',

            'maturity_date' => 'nullable|date|after_or_equal:investment_date',

            'custodian_bank' => 'nullable|string|max:255',

            'custodian_account_name' => 'nullable|string|max:255',
        ]);

        $fund = Fund::where('status', 'Active')
            ->findOrFail($validated['fund_id']);

        if ((float) $fund->current_nav <= 0) {

            return back()
                ->withInput()
                ->withErrors([
                    'fund_id' => 'The selected fund does not have a valid NAV.'
                ]);
        }

        $units = round(
            (float) $validated['amount_invested']
            / (float) $fund->current_nav,
            4
        );

        DB::transaction(function () use ($validated, $fund, $units) {

            $portfolio = Portfolio::create([
                'client_id' => $validated['client_id'],
                'fund_id' => $fund->id,

                'fund_name' => $fund->name,
                'investment_type' => $fund->fund_type,

                'amount_invested' => $validated['amount_invested'],
                'units' => $units,
                'nav_price' => $fund->current_nav,
                'current_nav_price' => $fund->current_nav,

                'investment_date' => $validated['investment_date'],
                'maturity_date' => $validated['maturity_date'] ?? null,
                'custodian_bank' => $validated['custodian_bank'] ?? null,
                'custodian_account_name' => $validated['custodian_account_name'] ?? null,

                'status' => 'Active',
            ]);

            $transaction = Transaction::create([
                'portfolio_id' => $portfolio->id,
                'transaction_type' => 'Buy',
                'amount' => $validated['amount_invested'],
                'units' => $units,
                'nav_price' => $fund->current_nav,
                'transaction_date' => $validated['investment_date'],
                'reference' => 'STM-' . Str::upper(Str::random(12)),
                'remarks' => 'Opening investment',
            ]);

            ActivityLogger::log(
                'Create',
                'Portfolio',
                'Opened '.$fund->name.' investment for client ID '.
                $validated['client_id'].' - Transaction '.$transaction->reference
            );
        });

        return redirect()
            ->route('clients.show', $validated['client_id'])
            ->with('success', 'Investment created successfully.');
    }
}