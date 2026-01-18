@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg p-4" id="printableArea">

        <div class="row mb-4">
            <div class="col-md-6">
                <h4 class="text-primary">Medical Clinic</h4>
                <div>Phone: 123456789</div>
                <div>Address: Main Street</div>
            </div>

            <div class="col-md-6 text-end">
                <h3>Invoice #{{ $invoice->id }}</h3>
                <div>Date: {{ $invoice->invoice_date }}</div>
                <div>Status: <strong>{{ ucfirst($invoice->status) }}</strong></div>
            </div>
        </div>

        <hr>

        <div class="mb-4">
            <h6>Patient Information</h6>
            <p>
                <strong>Name:</strong>
                {{ $invoice->patient->user->name ?? '---' }} <br>
                <strong>Appointment:</strong>
                {{ $invoice->appointment->appointment_date->format('Y-m-d H:i') }}
            </p>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Medical Service</td>
                    <td class="text-end">{{ number_format($invoice->subtotal, 2) }} $</td>
                </tr>
            </tbody>
        </table>

        <div class="row justify-content-end">
            <div class="col-md-4">
                <table class="table">
                    <tr>
                        <td>Tax (%)</td>
                        <td class="text-end">{{ $invoice->tax }}%</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td class="text-end">- {{ number_format($invoice->discount, 2) }} $</td>
                    </tr>
                    <tr class="table-info">
                        <td><strong>Total</strong></td>
                        <td class="text-end">
                            <strong>{{ number_format($invoice->total_amount, 2) }} $</strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-dark">
                Print Invoice
            </button>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print { display: none; }
    body { background: #fff; }
}
</style>
@endsection
