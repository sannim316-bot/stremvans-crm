@extends('layouts.dashboard')

@section('title','Reports')
@section('page-title','Executive Reports')

@section('content')

<x-page-header
title="Executive Reports"
subtitle="Overview of Stremvans Funds Management">

<a href="{{ route('reports.index') }}"
class="btn btn-stremvans">

Refresh Report

</a>

</x-page-header>

<div class="card-ui mb-4">

<form class="row g-3">

<div class="col-md-5">

<label>Start Date</label>

<input type="date"
class="form-control">

</div>

<div class="col-md-5">

<label>End Date</label>

<input type="date"
class="form-control">

</div>

<div class="col-md-2 d-grid">

<label>&nbsp;</label>

<button class="btn btn-stremvans">

Generate

</button>

</div>

</form>

</div>

<div class="row g-4">

<div class="col-md-6 col-xl-3">

<div class="stat-card gold">

<small>Total Investors</small>

<h2>{{ $clients }}</h2>

</div>

</div>

<div class="col-md-6 col-xl-3">

<div class="stat-card dark">

<small>Total AUM</small>

<h2>₦{{ number_format($aum,2) }}</h2>

</div>

</div>

<div class="col-md-6 col-xl-3">

<div class="stat-card dark">

<small>Transactions</small>

<h2>{{ $transactions }}</h2>

</div>

</div>

<div class="col-md-6 col-xl-3">

<div class="stat-card dark">

<small>Pending Compliance</small>

<h2>{{ $pendingKYC }}</h2>

</div>

</div>

</div>

<div class="card-ui mt-4">

<h4>Investment Trend</h4>

<div style="height:350px">

<canvas id="investmentChart"></canvas>

</div>

</div>

<script>

const ctx = document.getElementById('investmentChart');

new Chart(ctx,{

type:'line',

data:{

labels:['Jan','Feb','Mar','Apr','May','Jun'],

datasets:[{

label:'Monthly Investments',

data:[5000000,8200000,7000000,9100000,11500000,14200000],

borderColor:'#D6BB00',

backgroundColor:'rgba(214,187,0,.15)',

fill:true,

tension:.4

}]

},

options:{

responsive:true,

plugins:{

legend:{

display:false

}

}

}

});

</script>
@endsection