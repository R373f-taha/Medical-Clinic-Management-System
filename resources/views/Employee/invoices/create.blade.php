@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex justify-content-between align-items-center">
                <h4>Add New Invoice</h4>
                <a href="{{ route('employee.invoices.index') }}" class="btn btn-light">Back</a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('employee.invoices.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Patient --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Patient *</label>
                        <select name="patient_id" class="form-select" required>
                            <option value="">Select patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}"
                                    {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user->name ?? 'Unnamed Patient' }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="text-danger mt-1" style="font-size:0.875em;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Appointment --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Appointment *</label>
                        <select name="appointment_id" class="form-select" required>
                            <option value="">Select appointment</option>
                            @foreach($appointments as $appointment)
                                <option value="{{ $appointment->id }}"
                                    {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                    #{{ $appointment->id }} |
                                    {{ $appointment->appointment_date->format('Y-m-d H:i') }}
                                </option>
                            @endforeach
                        </select>
                        @error('appointment_id')
                            <div class="text-danger mt-1" style="font-size:0.875em;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Subtotal --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Subtotal *</label>
                        <input type="number" name="subtotal" class="form-control"
                               value="{{ old('subtotal') }}" required>
                        @error('subtotal')
                            <div class="text-danger mt-1" style="font-size:0.875em;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tax --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tax (%)</label>
                        <input type="number" name="tax" class="form-control" value="{{ old('tax', 0) }}">
                        @error('tax')
                            <div class="text-danger mt-1" style="font-size:0.875em;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Discount --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount</label>
                        <input type="number" name="discount" class="form-control" value="{{ old('discount', 0) }}">
                        @error('discount')
                            <div class="text-danger mt-1" style="font-size:0.875em;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Payment Method --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                            <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                        @error('payment_method')
                            <div class="text-danger mt-1" style="font-size:0.875em;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1" style="font-size:0.875em;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Invoice Date --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Invoice Date</label>
                        <input type="date" name="invoice_date" class="form-control"
                               value="{{ old('invoice_date', now()->toDateString()) }}">
                        @error('invoice_date')
                            <div class="text-danger mt-1" style="font-size:0.875em;">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="text-end">
                    <button class="btn btn-primary px-4">Save Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
