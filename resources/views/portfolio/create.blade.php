@extends('layouts.dashboard')

@section('title','Add Investment')
@section('page-title','Add Investment')

@section('content')

<div class="card border-0 rounded-4 shadow-sm">

<div class="card-body p-4">

<h4 class="mb-4">
Assign Investment
</h4>

<form action="{{ route('portfolios.store') }}" method="POST">

@csrf

<input type="hidden"
       name="client_id"
       value="{{ request('client') }}">

<div class="row">

<div class="col-md-6 mb-3">

<label>Fund Name</label>

<input
type="text"
name="fund_name"
class="form-control"
placeholder="Stremvans Equity Growth Fund"
required>

</div>

<div class="col-md-6 mb-3">

<label>Investment Type</label>

<select
name="investment_type"
class="form-select">

<option>Mutual Fund</option>
<option>Fixed Income</option>
<option>Equity Fund</option>
<option>Dollar Fund</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Amount Invested</label>

<input
type="number"
name="amount_invested"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Units Purchased</label>

<input
type="number"
step="0.0001"
name="units"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>NAV Price</label>

<input
type="number"
step="0.01"
name="nav_price"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Investment Date</label>

<input
type="date"
name="investment_date"
class="form-control"
required>

</div>

</div>

<button class="btn btn-warning px-4">

Save Investment

</button>

</form>

</div>

</div>

@endsection