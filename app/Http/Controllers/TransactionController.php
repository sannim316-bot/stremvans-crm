<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ActivityLogger;

class TransactionController extends Controller
{
    public function index(Portfolio $portfolio)
    {
        return view('transactions.index', compact('portfolio'));
    }

    public function create(Request $request)
    {
        $portfolio = Portfolio::findOrFail($request->portfolio);

        return view('transactions.create', compact('portfolio'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'portfolio_id'=>'required',
            'transaction_type'=>'required',
            'amount'=>'required|numeric',
            'units'=>'required|numeric',
            'nav_price'=>'required|numeric',
            'transaction_date'=>'required|date'

        ]);

        Transaction::create([

            'portfolio_id'=>$request->portfolio_id,
            'transaction_type'=>$request->transaction_type,
            'amount'=>$request->amount,
            'units'=>$request->units,
            'nav_price'=>$request->nav_price,
            'transaction_date'=>$request->transaction_date,
            'remarks'=>$request->remarks,

            'reference'=>'STM-'.Str::upper(Str::random(10))

        ]);

        ActivityLogger::log(

            'Create',

            'Transactions',

            'Recorded '.$request->transaction_type.
            ' transaction of ₦'.number_format($request->amount,2)

        );

        return redirect()
            ->route('transactions.index',$request->portfolio_id)
            ->with('success','Transaction saved successfully.');
    }
}