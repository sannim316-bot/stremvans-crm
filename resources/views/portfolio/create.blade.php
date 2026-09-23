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

<div class="row g-3">

<div class="col-md-6">

    <label class="form-label">
        Investment Fund *
    </label>

    <select
        name="fund_id"
        id="fundSelect"
        class="form-select"
        required>

        <option value="">
            Select investment fund
        </option>

        @foreach($funds as $fund)

            <option
                value="{{ $fund->id }}"
                data-nav="{{ $fund->current_nav }}"
                data-currency="{{ $fund->currency }}"
                data-type="{{ $fund->fund_type }}"
                @selected(old('fund_id') == $fund->id)>

                {{ $fund->name }}
                —
                {{ $fund->currency }}
                {{ number_format($fund->current_nav, 4) }}

            </option>

        @endforeach

    </select>

</div>

<div class="col-md-6">

    <label class="form-label">
        Investment Amount *
    </label>

    <input
        type="number"
        name="amount_invested"
        id="investmentAmount"
        step="0.01"
        min="0.01"
        value="{{ old('amount_invested') }}"
        class="form-control"
        required>

</div>

<div class="col-12">

    <div
        id="investmentPreview"
        class="card-ui mt-2"
        style="display:none;">

        <div class="row">

            <div class="col-md-3">
                <small class="text-muted">FUND TYPE</small>
                <h6 id="previewType">—</h6>
            </div>

            <div class="col-md-3">
                <small class="text-muted">CURRENT NAV</small>
                <h6 id="previewNav">—</h6>
            </div>

            <div class="col-md-3">
                <small class="text-muted">INVESTMENT</small>
                <h6 id="previewAmount">—</h6>
            </div>

            <div class="col-md-3">
                <small class="text-muted">ESTIMATED UNITS</small>
                <h6 id="previewUnits">—</h6>
            </div>

        </div>

    </div>

</div>

<div class="col-md-4">

<label class="form-label">Investment Date *</label>

<input
type="date"
name="investment_date"
value="{{ old('investment_date', now()->format('Y-m-d')) }}"
class="form-control"
required>

</div>

<div class="col-md-4">

<label class="form-label">Maturity Date</label>

<input
type="date"
name="maturity_date"
value="{{ old('maturity_date') }}"
class="form-control">

</div>

<div class="col-md-4">

<label class="form-label">Custodian Bank</label>

<input
type="text"
name="custodian_bank"
value="{{ old('custodian_bank') }}"
class="form-control">

</div>

<div class="col-md-6">

<label class="form-label">Custodian Account Name</label>

<input
type="text"
name="custodian_account_name"
value="{{ old('custodian_account_name') }}"
class="form-control">

</div>

</div>

<button class="btn btn-warning px-4 mt-3">

Save Investment

</button>

</form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const fundSelect = document.getElementById('fundSelect');
    const amountInput = document.getElementById('investmentAmount');
    const preview = document.getElementById('investmentPreview');

    function updatePreview() {

        const option = fundSelect.options[fundSelect.selectedIndex];

        if (!option || !option.value) {
            preview.style.display = 'none';
            return;
        }

        const nav = parseFloat(option.dataset.nav) || 0;
        const amount = parseFloat(amountInput.value) || 0;
        const currency = option.dataset.currency;
        const type = option.dataset.type;

        let symbol = currency;
        if (currency === 'NGN') symbol = '₦';
        if (currency === 'USD') symbol = '$';

        document.getElementById('previewType').textContent = type;

        document.getElementById('previewNav').textContent =
            symbol + nav.toLocaleString(undefined, {
                minimumFractionDigits: 4,
                maximumFractionDigits: 6
            });

        document.getElementById('previewAmount').textContent =
            symbol + amount.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

        const units = nav > 0 ? amount / nav : 0;

        document.getElementById('previewUnits').textContent =
            units.toLocaleString(undefined, {
                minimumFractionDigits: 4,
                maximumFractionDigits: 4
            });

        preview.style.display = 'block';
    }

    fundSelect.addEventListener('change', updatePreview);
    amountInput.addEventListener('input', updatePreview);

    updatePreview();

});
</script>

@endsection