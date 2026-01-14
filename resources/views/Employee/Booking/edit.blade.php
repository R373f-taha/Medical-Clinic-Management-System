@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Booking</h3>

    @can('manage appointments')
        <form method="POST" action="{{ route('employee.bookings.update', $booking->id) }}">
            @csrf
            @method('PUT')

            {{-- Appointment Date --}}
            <div class="mb-3">
                <label>Date</label>
                <input type="datetime-local" 
                       name="appointment_date" 
                       class="form-control @error('appointment_date') is-invalid @enderror"
                       value="{{ old('appointment_date', \Carbon\Carbon::parse($booking->appointment_date)->format('Y-m-d\TH:i')) }}">
                @error('appointment_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Reason --}}
            <div class="mb-3">
                <label>Reason</label>
                <textarea name="reason" 
                          class="form-control @error('reason') is-invalid @enderror">{{ old('reason', $booking->reason) }}</textarea>
                @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('employee.bookings.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    @else
        <div class="alert alert-danger">You do not have permission to edit bookings.</div>
    @endcan
</div>
@endsection
