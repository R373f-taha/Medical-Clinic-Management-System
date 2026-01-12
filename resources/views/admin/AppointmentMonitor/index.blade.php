@extends('layouts.app') 

@section('content')
<div class="container mt-4">
    @can('manage appointments')
    <h1>Appointments</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3 align-middle">
            <thead class="table-dark">
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
                        @can('manage appointments')
                        <form action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                              method="POST"
                              style="display:inline"
                              onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                            @csrf
                            @method('DELETE')
                            <i class="fas fa-trash action-icon danger"
                               title="Delete"
                               style="font-size:1.5rem; cursor:pointer; color:#dc3545;"
                               onclick="this.closest('form').submit()"></i>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endcan
</div>

<style>
.table th, .table td {
    white-space: nowrap;
    text-align: center;
    vertical-align: middle;
    font-size: 0.9rem;
}

.table-responsive {
    overflow-x: auto;
}

.action-icon.danger:hover {
    color: #a71d2a; /* تغيير لون عند المرور */
    transform: scale(1.2); /* تكبير بسيط عند المرور */
    transition: 0.2s;
}
</style>
@endsection
