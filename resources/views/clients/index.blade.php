@extends('layouts.dashboard')

@section('title','Clients')
@section('page-title','Client Management')

@section('content')

<x-table-card>

<x-page-header
title="Client Management"
subtitle="Manage all registered investors.">

<a href="{{ route('clients.create') }}"
class="btn btn-stremvans">

+ Add Client

</a>

</x-page-header>
<form action="{{ route('clients.index') }}" method="GET" class="mb-3">

<div class="input-group">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by client name or code...">

<button class="btn btn-dark">
<i class="bi bi-search"></i>
Search
</button>

</div>

</form>
<table class="table table-ui align-middle table-hover">

<thead>
<tr>
<th>Client Code</th>
<th>Client</th>
<th>Phone</th>
<th>Investment</th>
<th>KYC</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($clients as $client)

<tr>

<td>
<strong>{{ $client->client_code }}</strong>
</td>

<td>

<div>
<a href="{{ route('clients.show',$client->id) }}"
   class="text-decoration-none fw-bold text-dark">

    {{ $client->first_name }} {{ $client->last_name }}

</a>

<br>

<small class="text-muted">
    {{ $client->email }}
</small>

</div>

</td>

<td>{{ $client->phone }}</td>

<td>
₦{{ number_format($client->investment_amount,2) }}
</td>

<td>

<x-status-badge :status="$client->kyc_status"/>

</td>

<td class="d-flex gap-2">

<a href="{{ route('clients.edit',$client->id) }}"
class="btn btn-sm btn-outline-primary">

<i class="bi bi-pencil-square"></i>

</a>

<form action="{{ route('clients.destroy',$client->id) }}"
method="POST">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-outline-danger"
onclick="return confirm('Delete this client?')">

<i class="bi bi-trash"></i>

</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center py-4">
No clients found.
</td>
</tr>

@endforelse

</tbody>

</table>

<div class="mt-4">

{{ $clients->links() }}

</div>

</x-table-card>

@endsection