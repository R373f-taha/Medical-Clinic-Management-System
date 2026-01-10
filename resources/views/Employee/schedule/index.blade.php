@extends('layouts.app')

@section('content')

<h2>Doctors Schedule</h2>

{{-- فلترة --}}
<form method="GET" action="{{ route('employee.schedule') }}" class="row mb-3">
    <div class="col-md-4">
        <input type="text"
               name="doctor_name"
               class="form-control"
               placeholder="Doctor name"
               value="{{ request('doctor_name') }}">
    </div>

    <div class="col-md-3">
        <select name="period" class="form-control">
            <option value="">-- Select period --</option>
            <option value="daily" {{ request('period') === 'daily' ? 'selected' : '' }}>
                Daily
            </option>
            <option value="weekly" {{ request('period') === 'weekly' ? 'selected' : '' }}>
                Weekly
            </option>
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary">
            Filter
        </button>

        <a href="{{ route('employee.schedule') }}" class="btn btn-secondary">
            Reset
        </a>
    </div>
</form>

{{-- جدول المواعيد --}}
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Doctor</th>
            <th>Patient</th>
            <th>Date</th>
            <th>Status</th>
            <th>Reason</th>
        </tr>
    </thead>
    <tbody>
        @forelse($appointments as $appt)
            <tr>
                <td>{{ optional($appt->doctor)->user->name ?? '-' }}</td>
                <td>{{ optional($appt->patient)->user->name ?? '-' }}</td>
                <td>{{ $appt->appointment_date?->format('Y-m-d H:i') ?? '-' }}</td>
                <td>{{ ucfirst($appt->status) }}</td>
                <td>{{ $appt->reason ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    No appointments found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
