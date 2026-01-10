@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between">
            <span>Invoices Management</span>
            <a href="{{ route('employee.invoices.create') }}" class="btn btn-sm btn-primary">
                Add New Invoice
            </a>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>#{{ $invoice->id }}</td>
                        <td>{{ $invoice->patient->user->name }}</td>
                        <td>{{ $invoice->total_amount }}</td>
                        <td>
                            <span class="badge {{ $invoice->status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                {{ $invoice->status }}
                            </span>
                        </td>
                        <td>{{ $invoice->invoice_date }}</td>
                        <td>
                            <a href="{{ route('employee.invoices.show', $invoice->id) }}"
                               class="btn btn-info btn-sm">
                               Show
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
