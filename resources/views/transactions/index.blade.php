@extends('layouts.dashboard')

@section('title','Transactions')
@section('page-title','Transaction History')

@section('content')

<x-table-card>

<div class="d-flex justify-content-between mb-4">

<h4>Portfolio Transactions</h4>

<a href="{{ route('transactions.create',['portfolio'=>$portfolio->id]) }}"
class="btn btn-stremvans">

New Transaction

</a>

</div>

<table class="table table-ui align-middle">

<thead>

<tr>

<th>Reference</th>

<th>Type</th>

<th>Amount</th>

<th>Units</th>

<th>Date</th>

</tr>

</thead>

<tbody>

@foreach($portfolio->transactions as $transaction)

<tr>

<td>{{ $transaction->reference }}</td>

<td>

<x-status-badge :status="$transaction->transaction_type"/>

</td>

<td>₦{{ number_format($transaction->amount,2) }}</td>

<td>{{ $transaction->units }}</td>

<td>{{ $transaction->transaction_date }}</td>

</tr>

@endforeach

</tbody>

</table>

</x-table-card>

@endsection