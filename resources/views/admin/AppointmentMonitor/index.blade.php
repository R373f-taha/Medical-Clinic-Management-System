@extends('layouts.app') <!-- الملف الرئيسي للادمن -->

@section('content')
<div class="container mt-4">
    <h1>Appointments</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Appointment Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->id }}</td>
                <td>{{ $appointment->patient->user->name ?? '-' }}</td>
                <td>{{ $appointment->doctor->user->name ?? '-' }}</td>
                <td>{{ $appointment->reason ?? '-' }}</td>
                <td>{{ ucfirst($appointment->status) ?? '-' }}</td>
                <td>{{ $appointment->appointment_date->format('Y-m-d H:i') }}</td>
                <td>
                    <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
