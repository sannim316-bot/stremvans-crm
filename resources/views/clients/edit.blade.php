@extends('layouts.dashboard')

@section('title','Edit Client')
@section('page-title','Edit Client')

@section('content')

<div class="card shadow-sm border-0 rounded-4">

    <div class="card-body p-4">

        <h4 class="mb-4">Edit Investor Details</h4>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('clients.update', $client->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">First Name</label>
                    <input
                        type="text"
                        name="first_name"
                        class="form-control"
                        value="{{ old('first_name', $client->first_name) }}"
                        required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Last Name</label>
                    <input
                        type="text"
                        name="last_name"
                        class="form-control"
                        value="{{ old('last_name', $client->last_name) }}"
                        required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Other Name</label>
                    <input
                        type="text"
                        name="other_name"
                        class="form-control"
                        value="{{ old('other_name', $client->other_name) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Address</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $client->email) }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ old('phone', $client->phone) }}"
                        required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input
                        type="date"
                        name="date_of_birth"
                        class="form-control"
                        value="{{ old('date_of_birth', $client->date_of_birth) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender</label>

                    <select
                        name="gender"
                        class="form-select">

                        <option value="">Choose Gender</option>

                        <option value="Male" @selected(old('gender', $client->gender) == 'Male')>Male</option>

                        <option value="Female" @selected(old('gender', $client->gender) == 'Female')>Female</option>

                    </select>

                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Client Code</label>
                    <input
                        type="text"
                        name="client_code"
                        class="form-control"
                        value="{{ old('client_code', $client->client_code) }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Investment Type</label>

                    <select
                        name="investment_type"
                        class="form-select">

                        <option value="">Select Investment</option>

                        <option @selected(old('investment_type', $client->investment_type) == 'Mutual Fund')>Mutual Fund</option>

                        <option @selected(old('investment_type', $client->investment_type) == 'Fixed Income')>Fixed Income</option>

                        <option @selected(old('investment_type', $client->investment_type) == 'Equity Fund')>Equity Fund</option>

                        <option @selected(old('investment_type', $client->investment_type) == 'Dollar Fund')>Dollar Fund</option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Investment Amount</label>

                    <input
                        type="number"
                        name="investment_amount"
                        class="form-control"
                        value="{{ old('investment_amount', $client->investment_amount) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">KYC Status</label>

                    <select
                        name="kyc_status"
                        class="form-select">

                        <option @selected(old('kyc_status', $client->kyc_status) == 'Pending')>Pending</option>

                        <option @selected(old('kyc_status', $client->kyc_status) == 'Approved')>Approved</option>

                        <option @selected(old('kyc_status', $client->kyc_status) == 'Rejected')>Rejected</option>

                    </select>

                </div>

                <div class="col-md-8 mb-3">
                    <label class="form-label">Address</label>

                    <input
                        type="text"
                        name="address"
                        class="form-control"
                        value="{{ old('address', $client->address) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">City</label>

                    <input
                        type="text"
                        name="city"
                        class="form-control"
                        value="{{ old('city', $client->city) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">State</label>

                    <input
                        type="text"
                        name="state"
                        class="form-control"
                        value="{{ old('state', $client->state) }}">
                </div>

            </div>

            <div class="mt-3">

                <button class="btn btn-warning px-4">
                    Update Client
                </button>

            </div>

        </form>

    </div>

</div>

@endsection