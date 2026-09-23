<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Client;
use App\Models\Fund;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ActivityLogger;

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
            'investment_date' => 'required|date',
        ]);

        $fund = Fund::where('status', 'Active')
            ->findOrFail($validated['fund_id']);

        if ($fund->current_nav <= 0) {

            return back()
                ->withInput()
                ->withErrors([
                    'fund_id' => 'This fund does not currently have a valid NAV.'
                ]);
        }

        $units = $validated['amount_invested'] / $fund->current_nav;

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
            'status' => 'Active',
        ]);

        Transaction::create([
            'portfolio_id' => $portfolio->id,
            'transaction_type' => 'Buy',
            'amount' => $validated['amount_invested'],
            'units' => $units,
            'nav_price' => $fund->current_nav,
            'transaction_date' => $validated['investment_date'],
            'reference' => 'STM-' . Str::upper(Str::random(10)),
            'remarks' => 'Opening investment',
        ]);

        ActivityLogger::log(
            'Create',
            'Portfolio',
            'Opened '.$fund->name.' portfolio for '.
            $portfolio->client->first_name.' '.$portfolio->client->last_name
        );

        return redirect()
            ->route('clients.show', $validated['client_id'])
            ->with('success', 'Investment created successfully.');
    }
}