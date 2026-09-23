@extends('layouts.dashboard')

@section('title', 'Funds')
@section('page-title', 'Fund Management')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif


<x-page-header
    title="Funds"
    subtitle="Manage investment products and NAV">

    <a href="{{ route('funds.create') }}"
       class="btn btn-stremvans">
        + Create Fund
    </a>

</x-page-header>


<div class="card-ui">

    <div class="table-responsive">

        <table class="table table-ui align-middle">

            <thead>
                <tr>
                    <th>Fund</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Currency</th>
                    <th>Current NAV</th>
                    <th>NAV Date</th>
                    <th>Investors</th>
                    <th>Update NAV</th>
                </tr>
            </thead>

            <tbody>

            @forelse($funds as $fund)

                <tr>

                    <td>
                        <strong>
                            {{ $fund->name }}
                        </strong>
                    </td>

                    <td>
                        {{ $fund->code }}
                    </td>

                    <td>
                        {{ $fund->fund_type }}
                    </td>

                    <td>
                        {{ $fund->currency }}
                    </td>

                    <td>
                        {{ $fund->currency === 'NGN'
                            ? '₦'
                            : '$' }}

                        {{ number_format(
                            $fund->current_nav,
                            4
                        ) }}
                    </td>

                    <td>
                        {{ $fund->nav_date
                            ? $fund->nav_date->format('d M Y')
                            : '—' }}
                    </td>

                    <td>
                        {{ $fund->portfolios_count }}
                    </td>

                    <td>

                        <form method="POST"
                              action="{{ route(
                                  'funds.nav.update',
                                  $fund
                              ) }}">

                            @csrf

                            <div class="d-flex gap-2">

                                <input
                                    type="number"
                                    step="0.000001"
                                    name="nav_price"
                                    class="form-control"
                                    style="width:130px"
                                    value="{{ $fund->current_nav }}"
                                    required>

                                <input
                                    type="date"
                                    name="nav_date"
                                    class="form-control"
                                    style="width:150px"
                                    value="{{ now()->format('Y-m-d') }}"
                                    required>

                                <button
                                    class="btn btn-sm btn-dark">

                                    Update

                                </button>

                            </div>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8"
                        class="text-center text-muted py-4">

                        No investment funds created yet.

                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection