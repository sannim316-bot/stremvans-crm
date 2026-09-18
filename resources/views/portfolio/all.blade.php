@extends('layouts.dashboard')

@section('title','Portfolio Overview')
@section('page-title','Portfolio Overview')

@section('content')

<x-page-header
title="Portfolio Overview"
subtitle="All investments across every client."/>

<x-table-card>

<table class="table table-ui align-middle">

<thead>
<tr>
<th>Client</th>
<th>Fund</th>
<th>Type</th>
<th>Amount</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($portfolios as $portfolio)

<tr>
<td>{{ $portfolio->client->first_name }} {{ $portfolio->client->last_name }}</td>
<td>{{ $portfolio->fund_name }}</td>
<td>{{ $portfolio->investment_type }}</td>
<td>₦{{ number_format($portfolio->amount_invested,2) }}</td>
<td><span class="badge bg-success">{{ $portfolio->status }}</span></td>
<td>
<a href="{{ route('clients.show',$portfolio->client_id) }}" class="btn btn-outline-dark btn-sm">View Client</a>
</td>
</tr>

@empty

<tr>
<td colspan="6" class="text-center py-4">No investments yet.</td>
</tr>

@endforelse

</tbody>

</table>

</x-table-card>

@endsection