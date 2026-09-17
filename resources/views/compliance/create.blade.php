@extends('layouts.dashboard')

@section('title','Upload Document')
@section('page-title','Upload Compliance Document')

@section('styles')
<style>

.upload-box{

border:2px dashed #D6BB00;
border-radius:20px;
padding:50px;
text-align:center;
background:#FFFDF5;
cursor:pointer;
transition:.3s;

}

.upload-box:hover{

background:#FFF8DB;

}

</style>
@endsection

@section('content')

<div class="card border-0 rounded-4 shadow-sm">

<div class="card-body p-4">

<h4 class="mb-4">
Upload KYC / Compliance Document
</h4>

<form action="{{ route('compliance.store') }}"
method="POST"
enctype="multipart/form-data">

@csrf

<input type="hidden"
name="client_id"
value="{{ $client->id }}">

<div class="mb-3">

<label class="form-label">
Document Type
</label>

<select
name="document_type"
class="form-select"
required>

<option value="">Select Document</option>

<option>Passport</option>

<option>NIN</option>

<option>BVN</option>

<option>Signature</option>

<option>Proof of Address</option>

<option>AOD Form</option>

</select>

</div>

<label class="upload-box d-block">

<i class="bi bi-cloud-arrow-up display-4 text-warning"></i>

<h5 class="mt-3">
Click to Upload
</h5>

<p class="text-muted">
PDF, JPG, PNG (Max 5MB)
</p>

<input
type="file"
name="document"
hidden
required>

</label>

<div class="mt-4">

<button class="btn btn-warning px-4">

Upload Document

</button>

</div>

</form>

</div>

</div>

@endsection