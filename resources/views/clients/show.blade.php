@extends('layouts.dashboard')

@section('title', 'Investor Profile')
@section('page-title', 'Investor Profile')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card-ui mb-4">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

        <div>
            <div class="d-flex align-items-center gap-3">

                <div class="avatar">
                    {{ strtoupper(substr($client->first_name, 0, 1)) }}
                </div>

                <div>
                    <h3 class="mb-1">
                        {{ $client->first_name }}
                        {{ $client->middle_name }}
                        {{ $client->last_name }}
                    </h3>

                    <div class="text-muted">
                        {{ $client->client_code }}

                        @if($client->client_category)
                            • {{ $client->client_category }}
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <div>
            <span class="status
                {{ $client->kyc_status === 'Approved'
                    ? 'status-approved'
                    : ($client->kyc_status === 'Rejected'
                        ? 'status-rejected'
                        : 'status-pending') }}">

                KYC {{ $client->kyc_status ?? 'Pending' }}

            </span>
        </div>

    </div>

</div>

<div class="row g-3 mb-4">

    <div class="col-lg-3 col-md-6">
        <div class="card-ui h-100">
            <small class="text-muted">TOTAL INVESTED</small>

            <h4 class="mt-2 mb-0">
                ₦{{ number_format($totalInvested, 2) }}
            </h4>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-ui h-100">
            <small class="text-muted">CURRENT VALUE</small>

            <h4 class="mt-2 mb-0">
                ₦{{ number_format($currentValue, 2) }}
            </h4>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-ui h-100">
            <small class="text-muted">TOTAL UNITS</small>

            <h4 class="mt-2 mb-0">
                {{ number_format($totalUnits, 4) }}
            </h4>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card-ui h-100">
            <small class="text-muted">GAIN / LOSS</small>

            <h4 class="mt-2 mb-0
                {{ $gainLoss >= 0 ? 'text-success' : 'text-danger' }}">

                {{ $gainLoss >= 0 ? '+' : '-' }}₦
                {{ number_format(abs($gainLoss), 2) }}

            </h4>
        </div>
    </div>

</div>

<ul class="nav nav-tabs mb-4" id="clientTabs" role="tablist">

    <li class="nav-item">
        <button class="nav-link active"
                data-bs-toggle="tab"
                data-bs-target="#overview"
                type="button">
            Overview
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#bank"
                type="button">
            Bank
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#portfolio"
                type="button">
            Portfolio
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#kyc"
                type="button">
            KYC
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#transactions"
                type="button">
            Transactions
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#statements"
                type="button">
            Statements
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link"
                data-bs-toggle="tab"
                data-bs-target="#notes"
                type="button">
            Notes
        </button>
    </li>

</ul>

<div class="tab-content">

<div class="tab-pane fade show active" id="overview">

    <div class="row g-4">

        <div class="col-lg-6">

            <div class="card-ui h-100">

                <h5 class="mb-4">Personal Information</h5>

                <table class="table">

                    <tr>
                        <th>Client Code</th>
                        <td>{{ $client->client_code }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $client->email ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td>{{ $client->phone ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Date of Birth</th>
                        <td>{{ $client->date_of_birth ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Gender</th>
                        <td>{{ $client->gender ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Nationality</th>
                        <td>{{ $client->nationality ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Occupation</th>
                        <td>{{ $client->occupation ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td>{{ $client->residential_address ?? '—' }}</td>
                    </tr>

                </table>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card-ui h-100">

                <h5 class="mb-4">Investment Profile</h5>

                <table class="table">

                    <tr>
                        <th>Client Category</th>
                        <td>{{ $client->client_category ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Risk Profile</th>
                        <td>{{ $client->risk_profile ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Investment Objective</th>
                        <td>{{ $client->investment_objective ?? '—' }}</td>
                    </tr>

                    <tr>
                        <th>Relationship Manager</th>
                        <td>
                            {{ optional($client->relationshipManager)->name ?? 'Unassigned' }}
                        </td>
                    </tr>

                    <tr>
                        <th>KYC Status</th>
                        <td>{{ $client->kyc_status ?? 'Pending' }}</td>
                    </tr>

                </table>

            </div>

        </div>


        <div class="col-12">

            <div class="card-ui">

                <h5 class="mb-4">Next of Kin</h5>

                <div class="row">

                    <div class="col-md-3">
                        <small class="text-muted">NAME</small>
                        <p>{{ $client->next_of_kin_name ?? '—' }}</p>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">RELATIONSHIP</small>
                        <p>{{ $client->next_of_kin_relationship ?? '—' }}</p>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">PHONE</small>
                        <p>{{ $client->next_of_kin_phone ?? '—' }}</p>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">EMAIL</small>
                        <p>{{ $client->next_of_kin_email ?? '—' }}</p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="tab-pane fade" id="bank">

    <div class="card-ui">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h5 class="mb-1">Settlement Bank Account</h5>
                <small class="text-muted">
                    Verify the investor's nominated bank account.
                </small>
            </div>

            <span
                id="bankVerificationBadge"
                class="status {{ $client->bank_verified
                    ? 'status-approved'
                    : 'status-pending' }}">

                {{ $client->bank_verified
                    ? 'Verified'
                    : 'Not Verified' }}

            </span>

        </div>

        <div id="bankMessage"></div>

        <div class="row g-3">

            <div class="col-md-4">

                <label class="form-label">Bank</label>

                <select
                    id="bankName"
                    class="form-select">

                    <option value="">
                        Select Bank
                    </option>

                    <option value="Access Bank"
                            data-code="044">
                        Access Bank
                    </option>

                    <option value="First Bank"
                            data-code="011">
                        First Bank
                    </option>

                    <option value="GTBank"
                            data-code="058">
                        GTBank
                    </option>

                    <option value="UBA"
                            data-code="033">
                        UBA
                    </option>

                    <option value="Zenith Bank"
                            data-code="057">
                        Zenith Bank
                    </option>

                </select>

            </div>

            <div class="col-md-4">

                <label class="form-label">
                    Account Number
                </label>

                <input
                    type="text"
                    id="bankAccountNumber"
                    maxlength="10"
                    value="{{ $client->account_number }}"
                    class="form-control"
                    placeholder="10-digit NUBAN">

            </div>

            <div class="col-md-4">

                <label class="form-label">
                    Account Name
                </label>

                <input
                    type="text"
                    id="bankAccountName"
                    value="{{ $client->account_name }}"
                    class="form-control"
                    readonly>

            </div>

        </div>

        @if(in_array(
            auth()->user()->role,
            ['admin', 'relationship_officer']
        ))

            <button
                type="button"
                id="verifyBankButton"
                class="btn btn-stremvans mt-4">

                Verify Account

            </button>

        @endif

    </div>

</div>



<div class="tab-pane fade" id="portfolio">

    <div class="card-ui">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h5 class="mb-0">Investment Portfolio</h5>

            <a href="{{ route('portfolios.create', ['client' => $client->id]) }}"
               class="btn btn-stremvans">

                + Add Investment

            </a>

        </div>

        <div class="table-responsive">

            <table class="table table-ui align-middle">

                <thead>
                    <tr>
                        <th>Fund</th>
                        <th>Type</th>
                        <th>Units</th>
                        <th>NAV</th>
                        <th>Current Value</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                @forelse($client->portfolios as $portfolio)

                    <tr>

                        <td>{{ $portfolio->fund_name }}</td>

                        <td>{{ $portfolio->investment_type }}</td>

                        <td>
                            {{ number_format(
                                $portfolio->current_units,
                                4
                            ) }}
                        </td>

                        <td>
                            ₦{{ number_format(
                                $portfolio->current_nav,
                                4
                            ) }}
                        </td>

                        <td>
                            <strong>
                                ₦{{ number_format(
                                    $portfolio->current_value,
                                    2
                                ) }}
                            </strong>
                        </td>

                        <td>{{ $portfolio->status }}</td>

                        <td>
                            <a href="{{ route(
                                'transactions.index',
                                $portfolio->id
                            ) }}">
                                Transactions
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7"
                            class="text-center text-muted py-4">

                            No investments yet.

                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<div class="tab-pane fade" id="kyc">

    <div class="card-ui">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h5 class="mb-1">Compliance Documents</h5>

                <small class="text-muted">
                    Current KYC status:
                    {{ $client->kyc_status ?? 'Pending' }}
                </small>
            </div>

            <a href="{{ route(
                'compliance.create',
                ['client' => $client->id]
            ) }}"
               class="btn btn-stremvans">

                Upload Document

            </a>

        </div>

        <table class="table table-ui">

            <thead>
                <tr>
                    <th>Document</th>
                    <th>Status</th>
                    <th>Uploaded</th>
                    <th>Reviewed By</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            @forelse($client->complianceDocuments as $document)

                <tr>

                    <td>
                        <strong>{{ $document->document_type }}</strong>
                    </td>

                    <td>
                        <x-status-badge :status="$document->status"/>
                    </td>

                    <td>
                        {{ $document->created_at->format('d M Y') }}
                    </td>

                    <td>
                        {{ optional($document->reviewer)->name ?? '—' }}

                        @if($document->reviewed_at)
                            <br>
                            <small class="text-muted">
                                {{ $document->reviewed_at->format('d M Y') }}
                            </small>
                        @endif
                    </td>

                    <td>
                        {{ $document->remarks ?? '—' }}
                    </td>

                    <td>

                        @if(in_array(auth()->user()->role, ['admin', 'compliance']))

                            <button
                                class="btn btn-sm btn-success"
                                data-bs-toggle="modal"
                                data-bs-target="#approveDocument{{ $document->id }}">
                                Approve
                            </button>

                            <button
                                class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#rejectDocument{{ $document->id }}">
                                Reject
                            </button>

                        @else

                            <span class="text-muted">
                                View only
                            </span>

                        @endif

                    </td>

                </tr>

                <div class="modal fade"
                     id="approveDocument{{ $document->id }}"
                     tabindex="-1">

                    <div class="modal-dialog">

                        <form
                            method="POST"
                            action="{{ route('compliance.approve', $document) }}">

                            @csrf
                            @method('PATCH')

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">
                                        Approve {{ $document->document_type }}
                                    </h5>

                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <label class="form-label">
                                        Remarks
                                    </label>

                                    <textarea
                                        name="remarks"
                                        class="form-control"
                                        rows="3"
                                        placeholder="Optional compliance remarks"></textarea>

                                </div>

                                <div class="modal-footer">

                                    <button type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal">
                                        Cancel
                                    </button>

                                    <button type="submit"
                                            class="btn btn-success">
                                        Approve Document
                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <div class="modal fade"
                     id="rejectDocument{{ $document->id }}"
                     tabindex="-1">

                    <div class="modal-dialog">

                        <form
                            method="POST"
                            action="{{ route('compliance.reject', $document) }}">

                            @csrf
                            @method('PATCH')

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">
                                        Reject {{ $document->document_type }}
                                    </h5>

                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <div class="alert alert-warning">
                                        Please state why this document is being rejected.
                                    </div>

                                    <label class="form-label">
                                        Rejection Reason *
                                    </label>

                                    <textarea
                                        name="remarks"
                                        class="form-control"
                                        rows="4"
                                        required></textarea>

                                </div>

                                <div class="modal-footer">

                                    <button type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal">
                                        Cancel
                                    </button>

                                    <button type="submit"
                                            class="btn btn-danger">
                                        Reject Document
                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            @empty

                <tr>
                    <td colspan="6"
                        class="text-center text-muted py-4">

                        No KYC documents uploaded.

                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="tab-pane fade" id="transactions">

    <div class="card-ui">

        <h5 class="mb-4">
            Transaction History
            <small class="text-muted">
                ({{ $transactionCount }})
            </small>
        </h5>

        <div class="table-responsive">

            <table class="table table-ui">

                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Fund</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Units</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

                @forelse(
                    $client->portfolios->flatMap->transactions
                    ->sortByDesc('transaction_date')
                    as $transaction
                )

                    <tr>

                        <td>{{ $transaction->reference }}</td>

                        <td>
                            {{ $transaction->portfolio->fund_name }}
                        </td>

                        <td>{{ $transaction->transaction_type }}</td>

                        <td>
                            ₦{{ number_format($transaction->amount, 2) }}
                        </td>

                        <td>{{ number_format($transaction->units, 4) }}</td>

                        <td>
                            {{ $transaction->transaction_date }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6"
                            class="text-center text-muted py-4">

                            No transactions recorded.

                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<div class="tab-pane fade" id="statements">

    <div class="card-ui">

        <h5>Investor Statements</h5>

        <p class="text-muted">
            Generate an up-to-date investment statement for this investor.
        </p>

        <a href="{{ route('reports.investor', $client->id) }}"
           class="btn btn-outline-dark">

            View Statement

        </a>

        <a href="{{ route('reports.download', $client->id) }}"
           class="btn btn-stremvans">

            Download PDF

        </a>

    </div>

</div>

<div class="tab-pane fade" id="notes">

    <div class="card-ui">

        <h5 class="mb-4">Relationship Notes</h5>

        <form method="POST"
              action="{{ route('clients.notes.store', $client) }}"
              class="mb-5">

            @csrf

            <div class="row g-3">

                <div class="col-md-4">

                    <label class="form-label">
                        Interaction Type
                    </label>

                    <select name="interaction_type"
                            class="form-select"
                            required>

                        <option value="">Select type</option>

                        <option value="Phone Call">
                            Phone Call
                        </option>

                        <option value="Office Meeting">
                            Office Meeting
                        </option>

                        <option value="Virtual Meeting">
                            Virtual Meeting
                        </option>

                        <option value="Email">
                            Email
                        </option>

                        <option value="WhatsApp">
                            WhatsApp
                        </option>

                        <option value="Other">
                            Other
                        </option>

                    </select>

                </div>


                <div class="col-md-4">

                    <label class="form-label">
                        Interaction Date
                    </label>

                    <input
                        type="datetime-local"
                        name="interaction_date"
                        value="{{ old('interaction_date', now()->format('Y-m-d\TH:i')) }}"
                        class="form-control"
                        required>

                </div>


                <div class="col-md-4">

                    <label class="form-label">
                        Next Follow-up
                    </label>

                    <input
                        type="datetime-local"
                        name="follow_up_date"
                        value="{{ old('follow_up_date') }}"
                        class="form-control">

                </div>


                <div class="col-12">

                    <label class="form-label">
                        Notes
                    </label>

                    <textarea
                        name="note"
                        rows="4"
                        class="form-control"
                        placeholder="Enter discussion, investor request, action required, etc."
                        required>{{ old('note') }}</textarea>

                </div>


                <div class="col-12">

                    <button type="submit"
                            class="btn btn-stremvans">

                        Save Note

                    </button>

                </div>

            </div>

        </form>

        <hr class="mb-4">

        @forelse(
            $client->notes->sortByDesc('interaction_date')
            as $note
        )

            <div class="border-bottom pb-3 mb-3">

                <div class="d-flex justify-content-between">

                    <strong>
                        {{ $note->interaction_type ?? 'Note' }}
                    </strong>

                    <small class="text-muted">
                        {{ optional($note->interaction_date)
                            ? \Carbon\Carbon::parse($note->interaction_date)
                                ->format('d M Y h:i A')
                            : '' }}
                    </small>

                </div>

                <p class="mt-2 mb-2">
                    {{ $note->note }}
                </p>

                <small class="text-muted">
    By {{ optional($note->user)->name ?? 'System' }}
</small>

@if(
    auth()->user()->role === 'admin' ||
    auth()->id() === $note->user_id
)

<form method="POST"
      action="{{ route('clients.notes.destroy', $note) }}"
      class="mt-2"
      onsubmit="return confirm('Delete this note?')">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-sm btn-outline-danger">
        Delete
    </button>

</form>

@endif

@if($note->follow_up_date)

                    <div class="mt-2">
                        <strong>Follow-up:</strong>
                        {{ \Carbon\Carbon::parse(
                            $note->follow_up_date
                        )->format('d M Y h:i A') }}
                    </div>

                @endif

            </div>

        @empty

            <p class="text-muted">
                No relationship notes recorded yet.
            </p>

        @endforelse

    </div>

</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('verifyBankButton');

    if (!button) {
        return;
    }

    button.addEventListener('click', async function () {

        const bankSelect =
            document.getElementById('bankName');

        const selected =
            bankSelect.options[bankSelect.selectedIndex];

        const bankName = selected.value;

        const bankCode =
            selected.getAttribute('data-code');

        const accountNumber =
            document.getElementById('bankAccountNumber').value.trim();

        const message =
            document.getElementById('bankMessage');

        if (!bankName || !bankCode) {

            message.innerHTML =
                '<div class="alert alert-danger">' +
                'Please select a bank.' +
                '</div>';

            return;
        }

        if (!/^\d{10}$/.test(accountNumber)) {

            message.innerHTML =
                '<div class="alert alert-danger">' +
                'Enter a valid 10-digit account number.' +
                '</div>';

            return;
        }

        button.disabled = true;
        button.innerText = 'Verifying...';

        message.innerHTML =
            '<div class="alert alert-info">' +
            'Checking account details...' +
            '</div>';

        try {

            const response = await fetch(
                "{{ route('clients.bank.verify', $client) }}",
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN':
                            "{{ csrf_token() }}"
                    },

                    body: JSON.stringify({
                        bank_name: bankName,
                        bank_code: bankCode,
                        account_number: accountNumber
                    })
                }
            );

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(
                    data.message || 'Verification failed.'
                );
            }

            document.getElementById(
                'bankAccountName'
            ).value = data.account_name;

            const badge =
                document.getElementById(
                    'bankVerificationBadge'
                );

            badge.className =
                'status status-approved';

            badge.innerText = 'Verified';

            message.innerHTML =
                '<div class="alert alert-success">' +
                data.message +
                '</div>';

        } catch (error) {

            message.innerHTML =
                '<div class="alert alert-danger">' +
                error.message +
                '</div>';

        } finally {

            button.disabled = false;
            button.innerText = 'Verify Account';

        }

    });

});
</script>

@endsection