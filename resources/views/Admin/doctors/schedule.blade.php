@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">
@can('manage doctors')
    <div style="max-width:1200px; margin:auto;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#ff7a00;">Doctor Appointments</h2>
        </div>

        <h3 style="color:#333; margin-bottom:10px;">
            {{ $doctor->user->name }} ({{ $doctor->specialization }})
        </h3>

        <div style="overflow-x:auto; background:#fff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
            @if($doctor->appointments && $doctor->appointments->count() > 0)
            <table style="width:100%; border-collapse:collapse;">
                <thead style="background-color:#e5e5e5;">
                    <tr>
                        <th style="padding:12px;">Patient</th>
                        <th style="padding:12px;">Date & Time</th>
                        <th style="padding:12px;">Status</th>
                        <th style="padding:12px;">Reason</th>
                        <th style="padding:12px;">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctor->appointments as $appointment)
                    <tr style="border-bottom:1px solid #ddd;">
                        <td style="padding:10px;">
                            {{ $appointment->patient->user->name ?? 'N/A' }}
                        </td>
                        <td style="padding:10px;">
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d H:i') }}
                        </td>
                        <td style="padding:10px;">
                            @if($appointment->status == 'scheduled')
                                <span style="background-color:#ff7a00; color:#fff; padding:4px 10px; border-radius:12px; font-size:12px;">Scheduled</span>
                            @elseif($appointment->status == 'completed')
                                <span style="background-color:#28a745; color:#fff; padding:4px 10px; border-radius:12px; font-size:12px;">Completed</span>
                            @elseif($appointment->status == 'cancelled')
                                <span style="background-color:#dc3545; color:#fff; padding:4px 10px; border-radius:12px; font-size:12px;">Cancelled</span>
                            @endif
                        </td>
                        <td style="padding:10px;">{{ $appointment->reason ?? 'N/A' }}</td>
                        <td style="padding:10px;">{{ $appointment->notes ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div style="padding:20px; text-align:center; color:#888;">
                No appointments found for this doctor.
            </div>
            @endif
        </div>

        <a href="{{ url()->previous() }}"
           style="display:inline-block; margin-top:20px; padding:10px 20px;
                  background-color:#ff7a00; color:#fff; text-decoration:none;
                  border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
            Go Back
        </a>

    </div>
    @endcan
</div>
@endsection