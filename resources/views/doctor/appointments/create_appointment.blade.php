@extends('doctor.layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:800px; margin:auto; background:#fff; border-radius:8px;
                box-shadow:0 2px 8px rgba(0,0,0,0.1); padding:30px;">

        <!-- Header -->
        <h2 style="color:#ff7a00; margin-bottom:25px;">
            Add New Appointment
        </h2>

        <!-- Form -->
        <form action="{{ route('doctor.appointments.store') }}" method="POST">
            @csrf

            <!-- Patient -->
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:6px;">Patient</label>
                <select name="patient_id" required
                        style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;">
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">
                            Patient #{{ $patient->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Appointment Date -->
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:6px;">Appointment Date</label>
                <input type="datetime-local" name="appointment_date" required
                        style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;">
            </div>

            <!-- Status -->
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:6px;">Status</label>
                <select name="status" required
                        style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;">
                    <option value="scheduled">Scheduled</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Reason -->
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:6px;">Reason</label>
                <textarea name="reason" rows="3"
                            style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;"></textarea>
            </div>

            <!-- Notes -->
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:6px;">Notes</label>
                <textarea name="notes" rows="3"
                            style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc;"></textarea>
            </div>

            <!-- Buttons -->
            <div style="display:flex; gap:10px;">
                <button type="submit"
                        style="background-color:#ff7a00; color:#fff; padding:10px 20px;
                                border:none; border-radius:6px; cursor:pointer;">
                    Save Appointment
                </button>

                <a href="{{ route('doctor.appointments.doctorAppointments') }}"
                    style="background-color:#6c757d; color:#fff; padding:10px 20px;
                            text-decoration:none; border-radius:6px;">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>
@endsection
