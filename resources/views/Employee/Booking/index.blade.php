@extends('layouts.app')

@section('content')
<h2>Bookings</h2>

<a href="{{ route('employee.bookings.create') }}" class="btn btn-primary mb-3">
    + Add Booking
</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
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
                {{-- أزرار الموافقة/الرفض فقط للحجوزات على Hold --}}
                @if($b->status === 'hold')
                    <form method="POST"
                          action="{{ route('employee.bookings.approve', $b->id) }}"
                          style="display:inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Accept</button>
                    </form>

                    <form method="POST"
                          action="{{ route('employee.bookings.reject', $b->id) }}"
                          style="display:inline">
                        @csrf
                        <button class="btn btn-danger btn-sm">Reject</button>
                    </form>
                @endif

                {{-- زر تعديل --}}
                <a href="{{ route('employee.bookings.edit', $b->id) }}"
                   class="btn btn-warning btn-sm">Edit</a>

                {{-- زر Complete فقط للـ Scheduled --}}
                @if($b->status === 'scheduled')
                    <form method="POST"
                          action="{{ route('employee.bookings.complete', $b->id) }}"
                          style="display:inline">
                        @csrf
                        <button class="btn btn-info btn-sm">Complete</button>
                    </form>
                @endif

                {{-- زر حذف --}}
                <form method="POST"
                      action="{{ route('employee.bookings.destroy', $b->id) }}"
                      style="display:inline"
                      onsubmit="return confirm('Are you sure you want to delete this booking?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
