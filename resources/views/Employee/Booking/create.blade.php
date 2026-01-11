@extends('layouts.app')

@section('content')
<h3>Create Booking</h3>

<form method="POST" action="{{ route('employee.bookings.store') }}">
    @csrf

    <div class="mb-3">
        <label>Patient</label>
        <select name="patient_id" class="form-control">
            @foreach($patients as $p)
                <option value="{{ $p->id }}"
                    {{ old('patient_id') == $p->id ? 'selected' : '' }}>
                    {{ $p->user->name }}
                </option>
            @endforeach
        </select>
        @error('patient_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Doctor</label>
        <select name="doctor_id" class="form-control">
            @foreach($doctors as $d)
                <option value="{{ $d->id }}"
                    {{ old('doctor_id') == $d->id ? 'selected' : '' }}>
                    {{ $d->user->name }}
                </option>
            @endforeach
        </select>
        @error('doctor_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Date</label>
        <input type="datetime-local"
               name="appointment_date"
               value="{{ old('appointment_date') }}"
               class="form-control">
        @error('appointment_date')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Reason</label>
        <textarea name="reason" class="form-control">{{ old('reason') }}</textarea>
        @error('reason')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="{{ route('employee.bookings.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
