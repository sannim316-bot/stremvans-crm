@extends('layouts.dashboard')

@section('title','Investor Statement')
@section('page-title','Investor Statement')

@section('content')

<div class="card-ui">

<div class="mb-4">

<a href="{{ route('reports.download',$client->id) }}"
class="btn btn-stremvans">

Download PDF Statement

</a>

</div>

<div class="d-flex justify-content-between mb-4">

<div>

<h3>{{ $client->first_name }} {{ $client->last_name }}</h3>

<p>{{ $client->client_code }}</p>

</div>

<div>

<span class="badge bg-dark">
Statement
</span>

</div>

</div>

<hr>

<div class="row mb-4">

<div class="col-md-6">

<p><strong>Email</strong></p>

<p>{{ $client->email }}</p>

</div>

<div class="col-md-6">

<p><strong>Phone</strong></p>

<p>{{ $client->phone }}</p>

</div>

</div>

<h4 class="mb-3">
Investment Portfolio
</h4>

<table class="table table-ui">

<thead>

<tr>

<th>Fund</th>

<th>Amount</th>

<th>Units</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($client->portfolios as $portfolio)

<tr>

<td>{{ $portfolio->fund_name }}</td>

<td>₦{{ number_format($portfolio->amount_invested,2) }}</td>

<td>{{ $portfolio->units }}</td>

<td>{{ $portfolio->status }}</td>

</tr>

@endforeach

</tbody>

</table>

<h4 class="mt-5 mb-3">
Recent Transactions
</h4>

<table class="table table-ui">

<thead>

<tr>

<th>Date</th>

<th>Reference</th>

<th>Type</th>

<th>Amount</th>

</tr>

</thead>

<tbody>

@foreach($client->portfolios as $portfolio)

@foreach($portfolio->transactions as $transaction)

<tr>

<td>{{ $transaction->transaction_date }}</td>

<td>{{ $transaction->reference }}</td>

<td>{{ $transaction->transaction_type }}</td>

<td>₦{{ number_format($transaction->amount,2) }}</td>

</tr>

@endforeach

@endforeach

</tbody>

</table>

</div>

@endsection