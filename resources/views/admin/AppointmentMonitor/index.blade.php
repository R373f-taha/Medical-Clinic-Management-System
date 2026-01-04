@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Appointment Monitoring</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $appointment->patient->name ?? '-' }}
                    </td>

                    <td>
                        {{ $appointment->doctor->name ?? '-' }}
                    </td>

                    <td>
                        {{ $appointment->appointment_date }}
                    </td>

                    <td>
                        <span class="badge 
                            @if($appointment->status === 'scheduled') bg-warning
                            @elseif($appointment->status === 'completed') bg-success
                            @else bg-danger
                            @endif
                        ">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>

                    <td>
                        {{ $appointment->reason ?? '-' }}
                    </td>

                    <td>
                        <form action="{{ route('admin.appointments.destroy', $appointment) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this appointment?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        No appointments found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
