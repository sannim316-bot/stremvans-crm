@extends('layouts.dashboard')

@section('title','New Transaction')
@section('page-title','Portfolio Transaction')

@section('content')

<div class="card-ui">

<h4 class="mb-4">
New Portfolio Transaction
</h4>

<form action="{{ route('transactions.store') }}" method="POST">

@csrf

<input type="hidden"
name="portfolio_id"
value="{{ request('portfolio') }}">

<div class="row">

<div class="col-md-6 mb-3">

<label>Transaction Type</label>

<select
name="transaction_type"
class="form-select"
required>

<option>Buy</option>

<option>Redeem</option>

<option>Dividend</option>

<option>Bonus Units</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Amount</label>

<input
type="number"
name="amount"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Units</label>

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

<label>Transaction Date</label>

<input
type="date"
name="transaction_date"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Remarks</label>

<input
type="text"
name="remarks"
class="form-control"
placeholder="Optional remarks">

</div>

</div>

<button class="btn btn-stremvans">

Save Transaction

</button>

</form>

</div>

@endsection