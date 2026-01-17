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
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Appointment</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="width:90px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>#{{ $invoice->id }}</td>

                        {{-- Patient --}}
                        <td>
                            {{ $invoice->patient->user->name ?? '---' }}
                        </td>

                        {{-- Appointment --}}
                        <td>
                            {{ $invoice->appointment->appointment_date->format('Y-m-d H:i') ?? '-' }}
                        </td>

                        {{-- Total --}}
                        <td>
                            {{ number_format($invoice->total_amount, 2) }} $
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($invoice->status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-danger">Unpaid</span>
                            @endif
                        </td>

                        {{-- Date --}}
                        <td>
                            {{ $invoice->invoice_date }}
                        </td>

                        {{-- Action --}}
                        <td>
                            <a href="{{ route('employee.invoices.show', $invoice->id) }}"
                               class="text-info me-2" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted py-3">
                            No invoices found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
