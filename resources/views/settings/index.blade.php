@extends('layouts.dashboard')

@section('title','Settings')
@section('page-title','System Settings')

@section('content')

<x-page-header
title="System Settings"
subtitle="Company and application configuration."/>

<x-table-card>

<h5 class="mb-4">Company Information</h5>

<div class="row mb-3">
<div class="col-md-6">
<p><strong>Company Name</strong></p>
<p>Stremvans Funds Management Limited</p>
</div>
<div class="col-md-6">
<p><strong>Support Email</strong></p>
<p>support@stremvans.com</p>
</div>
</div>

<div class="row mb-3">
<div class="col-md-6">
<p><strong>Logged in as</strong></p>
<p>{{ auth()->user()->name }}</p>
</div>
<div class="col-md-6">
<p><strong>Role</strong></p>
<p>{{ ucfirst(str_replace('_',' ', auth()->user()->role)) }}</p>
</div>
</div>

<p class="text-muted small mt-4">More settings (logo upload, SMTP configuration, etc.) coming soon.</p>

</x-table-card>

@endsection