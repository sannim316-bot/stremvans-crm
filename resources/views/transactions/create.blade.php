@extends('layouts.dashboard')

@section('title','New Transaction')
@section('page-title','Portfolio Transaction')

@section('content')

<div class="card-ui mb-4">

    <div class="row">

        <div class="col-md-4">

            <small class="text-muted">
                INVESTOR
            </small>

            <h6>
                {{ $portfolio->client->first_name }}
                {{ $portfolio->client->last_name }}
            </h6>

        </div>

        <div class="col-md-4">

            <small class="text-muted">
                FUND
            </small>

            <h6>
                {{ $portfolio->fund_name }}
            </h6>

        </div>

        <div class="col-md-4">

            <small class="text-muted">
                AVAILABLE UNITS
            </small>

            <h6>
                {{ number_format(
                    $portfolio->current_units,
                    4
                ) }}
            </h6>

        </div>

    </div>

</div>

<div class="card-ui">

<h4 class="mb-4">
New Portfolio Transaction
</h4>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
id="transactionType"
class="form-select"
required>

<option value="">Select transaction</option>
<option value="Buy">Buy</option>
<option value="Redeem">Redeem</option>
<option value="Dividend">Dividend</option>
<option value="Bonus Units">Bonus Units</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Amount</label>

<input
type="number"
step="0.01"
name="amount"
id="transactionAmount"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Units</label>

<input
type="number"
step="0.0001"
name="units"
id="transactionUnits"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>NAV Price</label>

<input
type="number"
step="0.0001"
name="nav_price"
id="transactionNav"
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

<script>
document.addEventListener('DOMContentLoaded', function () {

    const type =
        document.getElementById('transactionType');

    const units =
        document.getElementById('transactionUnits');

    const nav =
        document.getElementById('transactionNav');

    const amount =
        document.getElementById('transactionAmount');

    function calculateAmount() {

        if (
            type.value !== 'Buy' &&
            type.value !== 'Redeem'
        ) {
            amount.readOnly = false;
            return;
        }

        const unitValue =
            parseFloat(units.value) || 0;

        const navValue =
            parseFloat(nav.value) || 0;

        amount.value =
            (unitValue * navValue).toFixed(2);

        amount.readOnly = true;
    }

    type.addEventListener(
        'change',
        calculateAmount
    );

    units.addEventListener(
        'input',
        calculateAmount
    );

    nav.addEventListener(
        'input',
        calculateAmount
    );

});
</script>

@endsection