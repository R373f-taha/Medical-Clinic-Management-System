@extends('layouts.app')

@section('content')
<h3>Edit Booking</h3>

<form method="POST" action="{{ route('employee.bookings.update', $booking->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Date</label>
        <input type="datetime-local"
               name="appointment_date"
               value="{{ \Carbon\Carbon::parse($booking->appointment_date)->format('Y-m-d\TH:i') }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Reason</label>
        <textarea name="reason" class="form-control">{{ $booking->reason }}</textarea>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="hold" {{ $booking->status=='hold'?'selected':'' }}>Hold</option>
            <option value="scheduled" {{ $booking->status=='scheduled'?'selected':'' }}>Scheduled</option>
            <option value="cancelled" {{ $booking->status=='cancelled'?'selected':'' }}>Cancelled</option>
            <option value="completed" {{ $booking->status=='completed'?'selected':'' }}>Completed</option>
        </select>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('employee.bookings.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
