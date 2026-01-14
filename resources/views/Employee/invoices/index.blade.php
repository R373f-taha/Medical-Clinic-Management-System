@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Invoices</h4>

        <a href="{{ route('employee.invoices.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Invoice
        </a>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="width:80px;">Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($invoices as $invoice)
                <tr>
                    <td>#{{ $invoice->id }}</td>

                    <td class="text-truncate" style="max-width:140px;">
                        {{ $invoice->patient->name }}
                    </td>

                    <td>
                        {{ $invoice->total_amount }}
                    </td>

                    <td>
                        @if($invoice->status === 'paid')
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-danger">Unpaid</span>
                        @endif
                    </td>

                    <td>
                        {{ $invoice->invoice_date }}
                    </td>

                    {{-- ACTION --}}
                    <td>
                        <a href="{{ route('employee.invoices.show', $invoice->id) }}">
                            <i class="fas fa-eye action-icon info" title="Show Invoice"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-muted py-3">
                        No invoices found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- STYLE --}}
<style>
.table {
    font-size: 0.85rem;
}

.table th, .table td {
    padding: 0.4rem;
    white-space: nowrap;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
}

.container-fluid {
    max-width: calc(100vw - 260px);
}

/* ICON STYLE (same as bookings) */
.action-icon {
    font-size: 1.1rem;
    cursor: pointer;
}

.action-icon.info {
    color: #0dcaf0;
}

.action-icon:hover {
    opacity: 0.7;
}

@media (max-width: 768px) {
    .container-fluid {
        max-width: 100vw;
    }
}
</style>
@endsection
