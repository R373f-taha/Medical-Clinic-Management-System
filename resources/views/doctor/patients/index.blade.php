@extends('doctor.layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:1200px; margin:auto;">
        <h2 style="color:#ff7a00; margin-bottom:20px;">
            Patients List
        </h2>

        <div style="overflow-x:auto; background:#ffffff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1)">
            <table style="width:100%; border-collapse:collapse;">
                <thead style="background-color:#e5e5e5;">
                    <tr>
                        <th style="padding:12px; text-align:left;">ID</th>
                        <th style="padding:12px; text-align:left;">Gender</th>
                        <th style="padding:12px; text-align:left;">Blood Type</th>
                        <th style="padding:12px; text-align:left;">Height (cm)</th>
                        <th style="padding:12px; text-align:left;">Weight (kg)</th>
                        <th style="padding:12px; text-align:left;">Allergies</th>
                        <th style="padding:12px; text-align:left;">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:10px;">{{ $patient->id }}</td>
                            <td style="padding:10px;">{{ $patient->gender }}</td>
                            <td style="padding:10px;">
                                {{ $patient->blood_type ?? 'N/A' }}
                            </td>
                            <td style="padding:10px;">
                                {{ $patient->height ?? '-' }}
                            </td>
                            <td style="padding:10px;">
                                {{ $patient->weight ?? '-' }}
                            </td>
                            <td style="padding:10px;">
                                {{ $patient->allergies ?? 'None' }}
                            </td>
                            <td style="padding:10px; color:#777;">
                                {{ $patient->created_at->format('Y-m-d') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:20px; text-align:center; color:#888;">
                                No patients found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <a href="{{ route('doctor.dashboard') }}"
            style="display:inline-block; margin-top:20px; padding:10px 20px; background-color:#ff7a00; color:#fff; text-decoration:none; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1); transition:background-color 0.3s;">
            Go Back
        </a>
    </div>

</div>
@endsection
