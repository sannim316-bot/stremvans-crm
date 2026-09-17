@extends('layouts.dashboard')

@section('title','Add Client')
@section('page-title','Add New Client')

@section('content')

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-body p-4">

        <h4 class="mb-4">New Investor Registration</h4>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('clients.store') }}" method="POST">

            @csrf

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">First Name</label>
                    <input
                        type="text"
                        name="first_name"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Last Name</label>
                    <input
                        type="text"
                        name="last_name"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Other Name</label>
                    <input
                        type="text"
                        name="other_name"
                        class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Address</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input
                        type="date"
                        name="date_of_birth"
                        class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender</label>

                    <select
                        name="gender"
                        class="form-select">

                        <option value="">Choose Gender</option>

                        <option value="Male">Male</option>

                        <option value="Female">Female</option>

                    </select>

                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Client Code</label>
                    <input
                        type="text"
                        name="client_code"
                        class="form-control"
                        placeholder="STM0001"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Investment Type</label>

                    <select
                        name="investment_type"
                        class="form-select">

                        <option value="">Select Investment</option>

                        <option>Mutual Fund</option>

                        <option>Fixed Income</option>

                        <option>Equity Fund</option>

                        <option>Dollar Fund</option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Investment Amount</label>

                    <input
                        type="number"
                        name="investment_amount"
                        class="form-control"
                        placeholder="500000">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">KYC Status</label>

                    <select
                        name="kyc_status"
                        class="form-select">

                        <option>Pending</option>

                        <option>Approved</option>

                        <option>Rejected</option>

                    </select>

                </div>

                <div class="col-md-8 mb-3">
                    <label class="form-label">Address</label>

                    <input
                        type="text"
                        name="address"
                        class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">City</label>

                    <input
                        type="text"
                        name="city"
                        class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">State</label>

                    <input
                        type="text"
                        name="state"
                        class="form-control">
                </div>

            </div>

            <div class="mt-3">

                <button class="btn btn-warning px-4">
                    Save Client
                </button>

            </div>

        </form>

    </div>

</div>

@endsection