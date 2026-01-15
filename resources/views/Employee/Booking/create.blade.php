@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create Booking</h3>

    @can('manage appointments')
        <form method="POST" action="{{ route('employee.bookings.store') }}">
            @csrf

            {{-- Patient --}}
            <div class="mb-3">
                <label>Patient</label>
                <select name="patient_id" 
                        class="form-control @error('patient_id') is-invalid @enderror">
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->user->name }}
                        </option>
                    @endforeach
                </select>
                @error('patient_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Doctor --}}
            <div class="mb-3">
                <label>Doctor</label>
                <select name="doctor_id" 
                        class="form-control @error('doctor_id') is-invalid @enderror">
                    @foreach($doctors as $d)
                        <option value="{{ $d->id }}" {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                            {{ $d->user->name }}
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Appointment Date --}}
            <div class="mb-3">
                <label>Date</label>
                <input type="datetime-local" 
                       name="appointment_date" 
                       class="form-control @error('appointment_date') is-invalid @enderror"
                       value="{{ old('appointment_date') }}">
                @error('appointment_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Reason --}}
            <div class="mb-3">
                <label>Reason</label>
                <textarea name="reason" 
                          class="form-control @error('reason') is-invalid @enderror">{{ old('reason') }}</textarea>
                @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary">Save</button>
            <a href="{{ route('employee.bookings.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    @else
        <div class="alert alert-danger">You do not have permission to create bookings.</div>
    @endcan
</div>
@endsection
