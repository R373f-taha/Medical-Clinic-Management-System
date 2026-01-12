@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bookings</h2>

    {{-- زر إضافة حجز فقط إذا عنده صلاحية --}}
    @can('manage appointments')
        <a href="{{ route('employee.bookings.create') }}" class="btn btn-primary mb-3">
            + Add Booking
        </a>
    @endcan

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th width="300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
            <tr>
                <td>{{ $b->patient?->user?->name }}</td>
                <td>{{ $b->doctor?->user?->name }}</td>
                <td>{{ $b->appointment_date->format('Y-m-d H:i') }}</td>
                <td>{{ $b->reason }}</td>
                <td>{{ ucfirst($b->status) }}</td>
                <td>
                    {{-- Accept / Reject فقط للـ Hold --}}
                    @if($b->status === 'hold')
                        @can('manage appointments')
                            <form method="POST" action="{{ route('employee.bookings.approve', $b->id) }}" style="display:inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Accept</button>
                            </form>

                            <form method="POST" action="{{ route('employee.bookings.reject', $b->id) }}" style="display:inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @endcan
                    @endif

                    {{-- Edit --}}
                    @can('manage appointments')
                        <a href="{{ route('employee.bookings.edit', $b->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    @endcan

                    {{-- Complete --}}
                    @if($b->status === 'scheduled')
                        @can('manage appointments')
                            <form method="POST" action="{{ route('employee.bookings.complete', $b->id) }}" style="display:inline">
                                @csrf
                                <button class="btn btn-info btn-sm">Complete</button>
                            </form>
                        @endcan
                    @endif

                    {{-- Delete --}}
                    @can('manage appointments')
                        <form method="POST" action="{{ route('employee.bookings.destroy', $b->id) }}" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
