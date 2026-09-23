@extends('layouts.dashboard')

@section('title','Add Investment')
@section('page-title','Add Investment')

@section('content')

<div class="card-ui">

<h4 class="mb-4">
Assign Investment
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

<form action="{{ route('portfolios.store') }}" method="POST">

@csrf

<input type="hidden"
       name="client_id"
       value="{{ $client->id }}">

<div class="row">

<div class="col-md-6 mb-3">

    <label class="form-label">
        Investment Fund
    </label>

    <select
        name="fund_id"
        class="form-select"
        required>

        <option value="">
            Select fund
        </option>

        @foreach($funds as $fund)

            <option value="{{ $fund->id }}">

                {{ $fund->name }}
                —
                {{ $fund->currency }}
                {{ number_format($fund->current_nav, 4) }}

            </option>

        @endforeach

    </select>

</div>

<div class="col-md-6 mb-3">

<label>Amount Invested</label>

<input
type="number"
step="0.01"
name="amount_invested"
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

@endsection