<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\FundNav;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FundController extends Controller
{
    public function index()
    {
        $funds = Fund::withCount('portfolios')
            ->orderBy('name')
            ->get();

        return view('funds.index', compact('funds'));
    }

    public function create()
    {
        return view('funds.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:funds,name',
            'code' => 'required|string|max:50|unique:funds,code',
            'fund_type' => 'required|in:Mutual Fund,Fixed Income,Equity Fund,Dollar Fund,Other',
            'currency' => 'required|in:NGN,USD',
            'current_nav' => 'required|numeric|min:0',
            'nav_date' => 'required|date|before_or_equal:today',
        ]);

        DB::transaction(function () use ($validated) {

            $fund = Fund::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'fund_type' => $validated['fund_type'],
                'currency' => $validated['currency'],
                'current_nav' => $validated['current_nav'],
                'nav_date' => $validated['nav_date'],
                'status' => 'Active',
            ]);

            FundNav::create([
                'fund_id' => $fund->id,
                'nav_price' => $validated['current_nav'],
                'nav_date' => $validated['nav_date'],
                'created_by' => auth()->id(),
            ]);

            ActivityLogger::log('Create', 'Funds', 'Created fund '.$fund->name);
        });

        return redirect()
            ->route('funds.index')
            ->with('success', 'Fund created successfully.');
    }

    public function updateNav(Request $request, Fund $fund)
    {
        $validated = $request->validate([
            'nav_price' => 'required|numeric|min:0',
            'nav_date' => 'required|date|before_or_equal:today',
        ]);

        if ($fund->nav_date && $validated['nav_date'] < $fund->nav_date->format('Y-m-d')) {
            return back()->withErrors([
                'nav_date' => 'NAV date cannot be earlier than the current NAV date.'
            ]);
        }

        DB::transaction(function () use ($validated, $fund) {

            FundNav::updateOrCreate(
                [
                    'fund_id' => $fund->id,
                    'nav_date' => $validated['nav_date'],
                ],
                [
                    'nav_price' => $validated['nav_price'],
                    'created_by' => auth()->id(),
                ]
            );

            $fund->update([
                'current_nav' => $validated['nav_price'],
                'nav_date' => $validated['nav_date'],
            ]);

            ActivityLogger::log('Update NAV', 'Funds', 'Updated NAV for '.$fund->name.' to '.$validated['nav_price']);
        });

        return back()->with('success', 'Fund NAV updated successfully.');
    }
}