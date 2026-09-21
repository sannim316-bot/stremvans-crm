@extends('layouts.dashboard')

@section('title', 'Add Investor')
@section('page-title', 'Investor Onboarding')

@section('content')

<div class="mb-4">
    <h3>New Investor</h3>
    <p class="text-muted">
        Complete the investor's profile and onboarding information.
    </p>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please correct the following:</strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('clients.store') }}">
    @csrf

    {{-- PERSONAL INFORMATION --}}
    <div class="card-ui mb-4">

        <h5 class="mb-1">Personal Information</h5>
        <p class="text-muted mb-4">
            Basic identification and contact details.
        </p>

        <div class="row g-3">

            <div class="col-md-4">
                <label class="form-label">First Name *</label>
                <input
                    type="text"
                    name="first_name"
                    value="{{ old('first_name') }}"
                    class="form-control"
                    required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Middle Name</label>
                <input
                    type="text"
                    name="middle_name"
                    value="{{ old('middle_name') }}"
                    class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Last Name *</label>
                <input
                    type="text"
                    name="last_name"
                    value="{{ old('last_name') }}"
                    class="form-control"
                    required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Date of Birth</label>
                <input
                    type="date"
                    name="date_of_birth"
                    value="{{ old('date_of_birth') }}"
                    class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Gender</label>

                <select name="gender" class="form-select">
                    <option value="">Select gender</option>
                    <option value="Male" @selected(old('gender') === 'Male')>
                        Male
                    </option>
                    <option value="Female" @selected(old('gender') === 'Female')>
                        Female
                    </option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Nationality</label>
                <input
                    type="text"
                    name="nationality"
                    value="{{ old('nationality', 'Nigerian') }}"
                    class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Email *</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone Number *</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="form-control"
                    required>
            </div>

            <div class="col-12">
                <label class="form-label">Residential Address</label>
                <textarea
                    name="residential_address"
                    class="form-control"
                    rows="2">{{ old('residential_address') }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">City</label>
                <input
                    name="city"
                    value="{{ old('city') }}"
                    class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">State</label>
                <input
                    name="state"
                    value="{{ old('state') }}"
                    class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Country</label>
                <input
                    name="country"
                    value="{{ old('country', 'Nigeria') }}"
                    class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Occupation</label>
                <input
                    name="occupation"
                    value="{{ old('occupation') }}"
                    class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Employer / Company</label>
                <input
                    name="employer"
                    value="{{ old('employer') }}"
                    class="form-control">
            </div>

        </div>
    </div>


    {{-- INVESTOR PROFILE --}}
    <div class="card-ui mb-4">

        <h5 class="mb-1">Investor Profile</h5>
        <p class="text-muted mb-4">
            Classification and investment preferences.
        </p>

        <div class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Client Category *</label>

                <select name="client_category" class="form-select" required>
                    <option value="">Select category</option>

                    @foreach([
                        'Retail',
                        'HNI',
                        'Corporate',
                        'Institutional'
                    ] as $category)

                        <option
                            value="{{ $category }}"
                            @selected(old('client_category') === $category)>

                            {{ $category }}

                        </option>

                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Risk Profile</label>

                <select name="risk_profile" class="form-select">

                    <option value="">Select risk profile</option>
                    <option value="Conservative">Conservative</option>
                    <option value="Moderate">Moderate</option>
                    <option value="Aggressive">Aggressive</option>

                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Investment Objective</label>

                <select name="investment_objective" class="form-select">

                    <option value="">Select objective</option>
                    <option value="Capital Preservation">
                        Capital Preservation
                    </option>
                    <option value="Income">Income</option>
                    <option value="Growth">Growth</option>
                    <option value="Income and Growth">
                        Income & Growth
                    </option>

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Relationship Manager</label>

                <select name="relationship_manager_id" class="form-select">

                    <option value="">Select relationship manager</option>

                    @foreach($relationshipManagers as $manager)

                        <option
                            value="{{ $manager->id }}"
                            @selected(old('relationship_manager_id') == $manager->id)>

                            {{ $manager->name }}

                        </option>

                    @endforeach

                </select>
            </div>

        </div>
    </div>


    {{-- BANK DETAILS --}}
    <div class="card-ui mb-4">

        <h5 class="mb-1">Bank Details</h5>

        <p class="text-muted mb-4">
            Investor's nominated settlement account.
        </p>

        <div class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Bank Name</label>

                <input
                    type="text"
                    name="bank_name"
                    value="{{ old('bank_name') }}"
                    class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Account Number</label>

                <input
                    type="text"
                    name="account_number"
                    value="{{ old('account_number') }}"
                    maxlength="10"
                    class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Account Name</label>

                <input
                    type="text"
                    name="account_name"
                    value="{{ old('account_name') }}"
                    class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">BVN</label>

                <input
                    type="text"
                    name="bvn"
                    value="{{ old('bvn') }}"
                    maxlength="11"
                    class="form-control">
            </div>

        </div>

        <div class="alert alert-light border mt-3 mb-0">
            NUBAN verification will be connected to Dojah after this form is saving correctly.
        </div>

    </div>


    {{-- NEXT OF KIN --}}
    <div class="card-ui mb-4">

        <h5 class="mb-1">Next of Kin</h5>

        <p class="text-muted mb-4">
            Emergency and beneficiary contact information.
        </p>

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Full Name</label>

                <input
                    name="next_of_kin_name"
                    value="{{ old('next_of_kin_name') }}"
                    class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Relationship</label>

                <input
                    name="next_of_kin_relationship"
                    value="{{ old('next_of_kin_relationship') }}"
                    class="form-control"
                    placeholder="e.g. Spouse, Parent, Sibling">
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>

                <input
                    name="next_of_kin_phone"
                    value="{{ old('next_of_kin_phone') }}"
                    class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>

                <input
                    type="email"
                    name="next_of_kin_email"
                    value="{{ old('next_of_kin_email') }}"
                    class="form-control">
            </div>

            <div class="col-12">
                <label class="form-label">Address</label>

                <textarea
                    name="next_of_kin_address"
                    class="form-control"
                    rows="2">{{ old('next_of_kin_address') }}</textarea>
            </div>

        </div>
    </div>


    {{-- SUBMIT --}}
    <div class="d-flex justify-content-between align-items-center">

        <a href="{{ route('clients.index') }}"
           class="btn btn-outline-secondary">
            Cancel
        </a>

        <button type="submit" class="btn btn-stremvans">
            Create Investor
        </button>

    </div>

</form>

@endsection