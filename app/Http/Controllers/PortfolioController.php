<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Client;
use Illuminate\Http\Request;
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

        return view('portfolio.create', compact('client'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'client_id'=>'required',
            'fund_name'=>'required',
            'investment_type'=>'required',
            'amount_invested'=>'required|numeric',
            'units'=>'required|numeric',
            'nav_price'=>'required|numeric',
            'investment_date'=>'required|date'

        ]);

        Portfolio::create($validated);

        ActivityLogger::log(

            'Create',

            'Portfolio',

            'Created portfolio for Client ID '.$request->client_id

        );

        return redirect()
                ->route('clients.show',$request->client_id)
                ->with('success','Investment added successfully.');
    }
}