@extends('doctor.layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:1200px; margin:auto;">

        <!-- Header + Add Button -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#ff7a00;">
                Todays Appointments
            </h2>
        </div>

        <div style="overflow-x:auto; background:#ffffff; border-radius:8px;
                    box-shadow:0 2px 8px rgba(0,0,0,0.1)">

            <table style="width:100%; border-collapse:collapse;">
                <thead style="background-color:#e5e5e5;">
                    <tr>
                        <th style="padding:12px;">ID</th>
                        <th style="padding:12px;">Patient</th>
                        <th style="padding:12px;">Doctor</th>
                        <th style="padding:12px;">Appointment Date</th>
                        <th style="padding:12px;">Status</th>
                        <th style="padding:12px;">Reason</th>
                        <th style="padding:12px;">Notes</th>
                        <th style="padding:12px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($appointments as $appointment)
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:10px;">{{ $appointment->id }}</td>

                            <td style="padding:10px;">
                                Patient #{{ $appointment->patient_id }}
                            </td>

                            <td style="padding:10px;">
                                Doctor #{{ $appointment->doctor_id }}
                            </td>

                            <td style="padding:10px;">
                                {{ $appointment->appointment_date }}
                            </td>

                            <td style="padding:10px;">
                                <span style="
                                    padding:4px 10px;
                                    border-radius:12px;
                                    color:#fff;
                                    font-size:12px;
                                    background-color:
                                        {{ $appointment->status === 'scheduled' ? '#ff7a00' :
                                            ($appointment->status === 'completed' ? '#28a745' : '#dc3545') }};
                                ">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>

                            <td style="padding:10px;">
                                {{ $appointment->reason ?? 'N/A' }}
                            </td>

                            <td style="padding:10px;">
                                {{ $appointment->notes ?? 'N/A' }}
                            </td>

                            <!-- Actions -->
                            <td style="padding:10px;">
                                <a href="{{ route('doctor.appointments.update',$appointment) }}"
                                    style="background-color:#6c757d; color:#fff; padding:6px 12px;
                                            text-decoration:none; border-radius:4px;">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9"
                                style="padding:20px; text-align:center; color:#888;">
                                No appointments found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>
        <a href="{{ route('doctor.dashboard') }}"
            style="display:inline-block; margin-top:20px; padding:10px 20px; background-color:#ff7a00; color:#fff; text-decoration:none; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1); transition:background-color 0.3s;">
            Go Back
        </a>

</div>
@endsection
