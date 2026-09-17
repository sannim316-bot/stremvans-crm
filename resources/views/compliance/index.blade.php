@extends('layouts.dashboard')

@section('title','Compliance Center')
@section('page-title','Client Compliance')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3>{{ $client->first_name }} {{ $client->last_name }}</h3>
        <p class="text-muted mb-0">
            Compliance & KYC Documents
        </p>
    </div>

    <a href="{{ route('compliance.create',['client'=>$client->id]) }}"
       class="btn btn-warning">

       + Upload Document

    </a>

</div>

<div class="row g-4">

@foreach($documents as $doc)

<div class="col-md-6 col-lg-4">

<div class="card border-0 shadow-sm rounded-4 h-100">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-3">

<h6>{{ $doc->document_type }}</h6>

@if($doc->status=="Approved")

<span class="badge bg-success">
Approved
</span>

@elseif($doc->status=="Rejected")

<span class="badge bg-danger">
Rejected
</span>

@else

<span class="badge bg-warning text-dark">
Pending
</span>

@endif

</div>

<p class="text-muted small">
Uploaded {{ $doc->created_at->diffForHumans() }}
</p>

<a href="{{ asset('storage/'.$doc->file_path) }}"
target="_blank"
class="btn btn-outline-dark btn-sm w-100">

View Document

</a>

</div>

</div>

</div>

@endforeach

</div>

@endsection