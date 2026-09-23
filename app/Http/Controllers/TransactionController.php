<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Transaction;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
        $validated = $request->validate([
            'portfolio_id' => 'required|exists:portfolios,id',

            'transaction_type' =>
                'required|in:Buy,Redeem,Dividend,Bonus Units',

            'amount' => 'required|numeric|min:0',

            'units' => 'required|numeric|min:0',

            'nav_price' => 'required|numeric|min:0',

            'transaction_date' => 'required|date',

            'remarks' => 'nullable|string|max:2000',
        ]);

        $portfolio = Portfolio::with('transactions')
            ->findOrFail($validated['portfolio_id']);

        if (
            in_array(
                $validated['transaction_type'],
                ['Buy', 'Redeem', 'Bonus Units']
            )
            && $validated['units'] <= 0
        ) {
            throw ValidationException::withMessages([
                'units' => 'Units must be greater than zero for this transaction.',
            ]);
        }

        if ($validated['transaction_type'] === 'Redeem') {

            if ($validated['units'] > $portfolio->current_units) {

                throw ValidationException::withMessages([
                    'units' =>
                        'Redemption exceeds available units. ' .
                        'Current available units: ' .
                        number_format($portfolio->current_units, 4),
                ]);
            }
        }

        if ($validated['transaction_type'] === 'Dividend') {
            $validated['units'] = 0;
        }

        if (
            in_array(
                $validated['transaction_type'],
                ['Buy', 'Redeem']
            )
        ) {

            $validated['amount'] =
                round(
                    $validated['units'] *
                    $validated['nav_price'],
                    2
                );
        }

        if ($validated['transaction_type'] === 'Bonus Units') {

            $validated['amount'] = 0;
        }

        DB::transaction(function () use (
            $validated,
            $portfolio
        ) {

            $transaction = Transaction::create([
                'portfolio_id' => $portfolio->id,

                'transaction_type' =>
                    $validated['transaction_type'],

                'amount' =>
                    $validated['amount'],

                'units' =>
                    $validated['units'],

                'nav_price' =>
                    $validated['nav_price'],

                'transaction_date' =>
                    $validated['transaction_date'],

                'remarks' =>
                    $validated['remarks'] ?? null,

                'reference' =>
                    'STM-' . Str::upper(Str::random(10)),
            ]);

            ActivityLogger::log(
                'Create',
                'Transactions',
                'Recorded ' .
                $transaction->transaction_type .
                ' transaction ' .
                $transaction->reference .
                ' for ' .
                $portfolio->client->first_name .
                ' ' .
                $portfolio->client->last_name
            );

            \App\Helpers\NotificationHelper::sendToAdmins(
                'New Transaction Recorded',
                'A '.$transaction->transaction_type.' transaction of ₦'.number_format($transaction->amount,2).' was recorded.',
                'info'
            );
        });

        return redirect()
            ->route('transactions.index', $portfolio)
            ->with(
                'success',
                'Transaction recorded successfully.'
            );
    }
}