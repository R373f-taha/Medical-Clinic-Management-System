@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Add New Invoice</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('employee.invoices.index') }}">Invoices</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0 text-primary"><i class="fas fa-file-invoice-dollar me-2"></i>Invoice Information</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('employee.invoices.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Patient <span class="text-danger">*</span></label>
                                <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select a patient</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                    @endforeach
                                </select>
                                @error('patient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Related Appointment <span class="text-danger">*</span></label>
                                <select name="appointment_id" class="form-select @error('appointment_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select an appointment</option>
                                    @foreach($appointments as $app)
                                        <option value="{{ $app->id }}">Appointment #{{ $app->id }} - {{ $app->appointment_date }}</option>
                                    @endforeach
                                </select>
                                @error('appointment_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold">Total Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="total_amount" class="form-control" step="0.01" required placeholder="0.00">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold">Tax</label>
                                <div class="input-group">
                                    <span class="input-group-text">%</span>
                                    <input type="number" name="tax" class="form-control" value="0" step="0.01">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold">Discount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="discount" class="form-control" value="0" step="0.01">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Payment Method</label>
                                <select name="payment_method" class="form-select">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="online">Online</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="unpaid" class="text-danger">Unpaid</option>
                                    <option value="paid" class="text-secondary">Paid</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold">Invoice Date</label>
                                <input type="date" name="invoice_date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('employee.invoices.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 shadow">
                                <i class="fas fa-save me-1"></i> Save Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
