@extends('layouts.dashboard')

@section('title','Activity Logs')
@section('page-title','System Activity Log')

@section('content')

<x-page-header
title="Activity Logs"
subtitle="Track every action performed inside the CRM."/>

<x-table-card>

<table class="table table-ui align-middle">

<thead>

<tr>

<th>Date</th>

<th>User</th>

<th>Module</th>

<th>Action</th>

<th>Description</th>

</tr>

</thead>

<tbody>

@foreach($logs as $log)

<tr>

<td>{{ $log->created_at->format('d M Y • h:i A') }}</td>

<td>{{ $log->user->name ?? 'System' }}</td>

<td>{{ $log->module }}</td>

<td>{{ $log->action }}</td>

<td>{{ $log->description }}</td>

</tr>

@endforeach

</tbody>

</table>

</x-table-card>

@endsection