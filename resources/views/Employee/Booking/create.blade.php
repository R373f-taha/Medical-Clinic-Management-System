@extends('layouts.app')

@section('content')
<h3>Create Booking</h3>

<form method="POST" action="{{ route('employee.bookings.store') }}">
    @csrf

    <input type="hidden" name="status" value="hold">

    <div class="mb-3">
        <label>Patient</label>
        <select name="patient_id" class="form-control">
            @foreach($patients as $p)
                <option value="{{ $p->id }}">{{ $p->user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Doctor</label>
        <select name="doctor_id" class="form-control">
            @foreach($doctors as $d)
                <option value="{{ $d->id }}">{{ $d->user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Date</label>
        <input type="datetime-local" name="appointment_date" class="form-control">
    </div>

    <div class="mb-3">
        <label>Reason</label>
        <textarea name="reason" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Save</button>
</form>
@endsection
