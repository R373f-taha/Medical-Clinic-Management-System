@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:800px; margin:auto; background:#fff;
                border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);
                padding:25px;">

        <h2 style="color:#ff7a00; margin-bottom:20px;">
            Prescription Details
        </h2>

        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <th style="text-align:left; padding:10px; background:#f5f5f5;">Patient ID</th>
                <td style="padding:10px;">
                    {{ $prescription->medical_record->patient_id ?? 'N/A' }}
                </td>
            </tr>

            <tr>
                <th style="text-align:left; padding:10px; background:#f5f5f5;">Medicine Name</th>
                <td style="padding:10px;">{{ $prescription->medicine_name }}</td>
            </tr>

            <tr>
                <th style="text-align:left; padding:10px; background:#f5f5f5;">Dosage</th>
                <td style="padding:10px;">{{ $prescription->dosage }}</td>
            </tr>

            <tr>
                <th style="text-align:left; padding:10px; background:#f5f5f5;">Frequency</th>
                <td style="padding:10px;">{{ $prescription->frequency }}</td>
            </tr>

            <tr>
                <th style="text-align:left; padding:10px; background:#f5f5f5;">Refills</th>
                <td style="padding:10px;">{{ $prescription->refills }}</td>
            </tr>

            <tr>
                <th style="text-align:left; padding:10px; background:#f5f5f5;">Duration (days)</th>
                <td style="padding:10px;">{{ $prescription->duration }}</td>
            </tr>

            <tr>
                <th style="text-align:left; padding:10px; background:#f5f5f5;">Instructions</th>
                <td style="padding:10px;">{{ $prescription->instructions }}</td>
            </tr>
        </table>

        <div style="margin-top:25px; display:flex; gap:10px;">
        @can('manage prescriptions')

            <a href="{{ route('doctor.prescriptions.index') }}"
               style="padding:10px 18px; background:#ff7a00; color:#fff;
                      text-decoration:none; border-radius:6px;">
                Back to Prescriptions
            </a>
            <a href="{{ route('doctor.prescriptions.download',$prescription) }}"
               style="padding:10px 18px; background:#ff7a00; color:#fff;
                      text-decoration:none; border-radius:6px;">
                Download PDF
            </a>
                    @endcan

        </div>

    </div>
</div>
@endsection
