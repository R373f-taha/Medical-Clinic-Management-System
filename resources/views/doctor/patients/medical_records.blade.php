@extends('doctor.layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:1200px; margin:auto;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#ff7a00;">
                Medical Records
            </h2>

            <a href="{{ route('doctor.medical_records.create') }}"
                style="background-color:#ff7a00; color:#fff; padding:10px 16px; text-decoration:none; border-radius:6px;">
                + Add New Medical Record
            </a>
        </div>

        <div style="overflow-x:auto; background:#ffffff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1)">
            <table style="width:100%; border-collapse:collapse;">
                <thead style="background-color:#e5e5e5;">
                    <tr>
                        <th style="padding:12px; text-align:left;">ID</th>
                        <th style="padding:12px; text-align:left;">Patient</th>
                        <th style="padding:12px; text-align:left;">Diagnosis</th>
                        <th style="padding:12px; text-align:left;">Notes</th>
                        <th style="padding:12px; text-align:left;">Treatment Plan</th>
                        <th style="padding:12px; text-align:left;">Follow Up Date</th>
                        <th style="padding:12px; text-align:left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:10px;">{{ $record->id }}</td>

                            <td style="padding:10px;">
                                {{ $record->patient->user->name ?? 'N/A' }}
                            </td>

                            <td style="padding:10px;">
                                {{ $record->diagnosis ?? 'N/A' }}
                            </td>

                            <td style="padding:10px;">
                                {{ $record->notes ?? 'N/A' }}
                            </td>

                            <td style="padding:10px;">
                                {{ $record->treatment_plan ?? 'N/A' }}
                            </td>

                            <td style="padding:10px;">
                                {{ $record->follow_up_date ?? '-' }}
                            </td>

                            <td style="padding:10px;">
                                <a href="{{ route('doctor.medical_records.edit',$record) }}"
                                    style="background-color:#6c757d; color:#fff; padding:6px 12px; text-decoration:none; border-radius:4px;">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:20px; text-align:center; color:#888;">
                                No medical records found
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
