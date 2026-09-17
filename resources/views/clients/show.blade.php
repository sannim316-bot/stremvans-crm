@extends('layouts.dashboard')

@section('title','Client Profile')
@section('page-title','Client Profile')

@section('content')

<div class="row g-4">

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center p-4">

                <div class="rounded-circle bg-warning text-dark mx-auto mb-3 d-flex align-items-center justify-content-center"
                     style="width:90px;height:90px;font-size:34px;font-weight:bold;">

                    {{ strtoupper(substr($client->first_name,0,1)) }}

                </div>

                <h4>{{ $client->first_name }} {{ $client->last_name }}</h4>

                <p class="text-muted">{{ $client->client_code }}</p>

                <hr>

                <p><strong>Email</strong><br>{{
                    
                      
                $client->email }}</p>

                <p><strong>Phone</strong><br>{{ $client->phone }}</p>

                <p><strong>Investment Type</strong><br>{{ $client->investment_type ?? 'Not Assigned' }}</p>

                <p>
                    <strong>KYC Status</strong><br>

                    @if($client->kyc_status=="Approved")
                        <span class="badge bg-success">Approved</span>
                    @elseif($client->kyc_status=="Rejected")
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif

                </p>

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="row g-3 mb-4">

            <div class="col-md-6">

                <div class="card border-0 rounded-4 shadow-sm bg-dark text-white">

                    <div class="card-body">

                        <small>Total Investments</small>

                        <h3>{{ $client->portfolios->count() }}</h3>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card border-0 rounded-4 shadow-sm bg-warning">

                    <div class="card-body">

                        <small>Total Amount Invested</small>

                        <h3>
                            ₦{{ number_format($client->portfolios->sum('amount_invested'),2) }}
                        </h3>

                    </div>

                </div>

            </div>

        </div>

        <div class="card border-0 rounded-4 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5>Investment Portfolio</h5>

                    <a href="{{ route('portfolios.create',['client'=>$client->id]) }}"
   class="btn btn-warning btn-sm">

    + Add Investment

</a>
<a href="{{ route('compliance.index',$client->id) }}"
   class="btn btn-dark btn-sm">

       Compliance

</a>
<a href="{{ route('reports.investor',$client->id) }}"
   class="btn btn-outline-dark btn-sm">

       Generate Statement

</a>
                </div>

                <table class="table align-middle">

                   <thead>
                            <tr>
                         <th>Fund</th>
                         <th>Amount</th>
                         <th>Units</th>
                         <th>Status</th>
                         <th>Actions</th>
                             </tr>
                  </thead>

                    <tbody>

                        @forelse($client->portfolios as $portfolio)

                       <tr>

    <td>{{ $portfolio->fund_name }}</td>

    <td>₦{{ number_format($portfolio->amount_invested,2) }}</td>

    <td>{{ $portfolio->units }}</td>

    <td>
        <span class="badge bg-success">
            {{ $portfolio->status }}
        </span>
    </td>

    <td>
        <a href="{{ route('transactions.index',$portfolio->id) }}"
        class="btn btn-outline-dark btn-sm">

        Transactions

        </a>
    </td>

</tr>

                        @empty

                        <tr>
                            <td colspan="5" class="text-center py-4">
    No investment has been added yet.
</td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection