@extends('layouts.dashboard')

@section('title','Dashboard')

@section('page-title','Dashboard Overview')

@section('styles')
<style>

.card-box{
    border:none;
    border-radius:18px;
    padding:25px;
    color:white;
    overflow:hidden;
    position:relative;
}

.card-box i{
    position:absolute;
    right:20px;
    top:20px;
    font-size:30px;
    opacity:.25;
}

.card-box h6{
    font-size:13px;
    text-transform:uppercase;
    letter-spacing:1px;
}

.card-box h2{
    margin-top:12px;
    font-weight:700;
}

.gold-card{
    background:linear-gradient(135deg,#A38100,#E8D34D);
    color:#222;
}

.dark-card{
    background:#1C1F26;
}

.table-card{
    background:white;
    border-radius:18px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.table-card h5{
    margin-bottom:20px;
    font-weight:700;
}

.badge-pending{
    background:#FFF4D0;
    color:#8A6700;
    padding:7px 12px;
    border-radius:20px;
}

.badge-approved{
    background:#D8F8E8;
    color:#0A7A42;
    padding:7px 12px;
    border-radius:20px;
}

</style>
@endsection

@section('content')

<div class="row g-4 mb-4">

<div class="col-md-6 col-xl-3">

<div class="stat-card gold">

<i class="bi bi-people-fill"></i>

<small>Total Clients</small>

<h2>{{ $totalClients }}</h2>

<p class="mb-0">Registered Investors</p>

</div>

</div>

<div class="col-md-6 col-xl-3">

<div class="stat-card dark">

<i class="bi bi-wallet2"></i>

<small>AUM</small>

<h2>₦{{ number_format($aum,2) }}</h2>

<p class="mb-0">Assets Under Management</p>

</div>

</div>

<div class="col-md-6 col-xl-3">

<div class="stat-card dark">

<i class="bi bi-bar-chart-line"></i>

<small>Active Portfolios</small>

<h2>{{ $activeInvestments }}</h2>

<p class="mb-0">Running Investments</p>

</div>

</div>

<div class="col-md-6 col-xl-3">

<div class="stat-card dark">

<i class="bi bi-shield-check"></i>

<small>Pending KYC</small>

<h2>{{ $pendingKYC }}</h2>
<p class="mb-0">Awaiting Approval</p>

</div>

</div>

</div>
<x-table-card>

<h5>Recent Transactions</h5>

<table class="table table-ui align-middle">

<thead>
<tr>
<th>Client</th>
<th>Type</th>
<th>Amount</th>
<th>Date</th>
</tr>
</thead>

<tbody>

@forelse($recentTransactions as $transaction)

<tr>
<td>{{ $transaction->portfolio->client->first_name }} {{ $transaction->portfolio->client->last_name }}</td>
<td><x-status-badge :status="$transaction->transaction_type"/></td>
<td>₦{{ number_format($transaction->amount,2) }}</td>
<td>{{ $transaction->transaction_date }}</td>
</tr>

@empty

<tr>
<td colspan="4" class="text-center py-4">No transactions yet.</td>
</tr>

@endforelse

</tbody>

</table>

</x-table-card>

@endsection