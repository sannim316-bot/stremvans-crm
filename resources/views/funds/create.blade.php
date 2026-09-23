@extends('layouts.dashboard')

@section('title', 'Create Fund')
@section('page-title', 'Create Fund')

@section('content')

<div class="card-ui">

    <h5 class="mb-4">
        New Investment Fund
    </h5>

    @if($errors->any())

        <div class="alert alert-danger">

            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach

        </div>

    @endif

    <form method="POST"
          action="{{ route('funds.store') }}">

        @csrf

        <div class="row g-3">

            <div class="col-md-6">

                <label class="form-label">
                    Fund Name
                </label>

                <input
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control"
                    required>

            </div>


            <div class="col-md-3">

                <label class="form-label">
                    Fund Code
                </label>

                <input
                    name="code"
                    value="{{ old('code') }}"
                    class="form-control"
                    placeholder="e.g. STM-FIF"
                    required>

            </div>


            <div class="col-md-3">

                <label class="form-label">
                    Currency
                </label>

                <select
                    name="currency"
                    class="form-select"
                    required>

                    <option value="NGN">
                        NGN
                    </option>

                    <option value="USD">
                        USD
                    </option>

                </select>

            </div>


            <div class="col-md-4">

                <label class="form-label">
                    Fund Type
                </label>

                <select
                    name="fund_type"
                    class="form-select"
                    required>

                    <option value="">
                        Select type
                    </option>

                    <option value="Mutual Fund">
                        Mutual Fund
                    </option>

                    <option value="Fixed Income">
                        Fixed Income
                    </option>

                    <option value="Equity Fund">
                        Equity Fund
                    </option>

                    <option value="Dollar Fund">
                        Dollar Fund
                    </option>

                    <option value="Other">
                        Other
                    </option>

                </select>

            </div>


            <div class="col-md-4">

                <label class="form-label">
                    Opening NAV
                </label>

                <input
                    type="number"
                    step="0.000001"
                    name="current_nav"
                    value="{{ old('current_nav') }}"
                    class="form-control"
                    required>

            </div>


            <div class="col-md-4">

                <label class="form-label">
                    NAV Date
                </label>

                <input
                    type="date"
                    name="nav_date"
                    value="{{ old(
                        'nav_date',
                        now()->format('Y-m-d')
                    ) }}"
                    class="form-control"
                    required>

            </div>

        </div>


        <div class="mt-4">

            <a href="{{ route('funds.index') }}"
               class="btn btn-outline-secondary">
                Cancel
            </a>

            <button
                class="btn btn-stremvans">

                Create Fund

            </button>

        </div>

    </form>

</div>

@endsection