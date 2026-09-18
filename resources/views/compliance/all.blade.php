@extends('layouts.dashboard')

@section('title','Compliance Center')
@section('page-title','Compliance Overview')

@section('content')

<x-page-header
title="Compliance Overview"
subtitle="All KYC documents across every investor."/>

<x-table-card>

<table class="table table-ui align-middle">

<thead>

<tr>
<th>Client</th>
<th>Document</th>
<th>Status</th>
<th>Uploaded</th>
<th>Actions</th>
</tr>

</thead>

<tbody>

@forelse($documents as $doc)

<tr>

<td>{{ $doc->client->first_name }} {{ $doc->client->last_name }}</td>

<td>{{ $doc->document_type }}</td>

<td><x-status-badge :status="$doc->status"/></td>

<td>{{ $doc->created_at->format('d M Y') }}</td>

<td class="d-flex gap-2">

<a href="{{ route('compliance.index',$doc->client_id) }}"
class="btn btn-outline-dark btn-sm">

View Client

</a>

</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center py-4">No documents uploaded yet.</td>
</tr>

@endforelse

</tbody>

</table>

</x-table-card>

@endsection