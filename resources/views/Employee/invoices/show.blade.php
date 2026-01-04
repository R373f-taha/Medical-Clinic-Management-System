@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card border-0 shadow-lg p-5" id="printableArea">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h3 class="text-primary">Clinic Logo</h3>
                <div>Address: Health Street, City</div>
                <div>Phone: +123 456 789</div>
            </div>
            <div class="col-sm-6 text-end">
                <h2 class="fw-bold">Medical Invoice</h2>
                <div>Reference #: #{{ $invoice->id }}</div>
                <div>Issue Date: {{ $invoice->invoice_date }}</div>
            </div>
        </div>

        <hr>

        <div class="row mb-4">
            <div class="col-sm-6">
                <h6 class="mb-3 text-muted">To Patient:</h6>
                <div><strong>{{ $invoice->patient->name }}</strong></div>
                <div>Phone: {{ $invoice->patient->phone ?? '---' }}</div>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Medical Checkup Service - Appointment #{{ $invoice->appointment_id }}</td>
                    <td class="text-end">{{ number_format($invoice->total_amount, 2) }} $</td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-lg-4 col-sm-5 ms-auto">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td class="left"><strong>Tax</strong></td>
                            <td class="text-end">{{ $invoice->tax }}%</td>
                        </tr>
                        <tr>
                            <td class="left"><strong>Discount</strong></td>
                            <td class="text-end">-{{ $invoice->discount }} $</td>
                        </tr>
                        <tr class="table-info">
                            <td class="left"><strong>Grand Total</strong></td>
                            <td class="text-end"><strong>{{ number_format($invoice->total_amount, 2) }} $</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4 no-print text-center">
            <button onclick="window.print()" class="btn btn-dark btn-lg">Print Invoice (PDF)</button>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    body { background: white; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>
@endsection
