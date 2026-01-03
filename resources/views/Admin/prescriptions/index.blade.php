@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:1200px; margin:auto;">

       
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#ff7a00;">
                Prescriptions
            </h2>

            <a href="{{ route('prescriptions.create') }}"
               style="background-color:#ff7a00; color:#fff;
                      padding:10px 16px; text-decoration:none;
                      border-radius:6px;">
                + Add New Prescription
            </a>
        </div>

       
        <div style="overflow-x:auto; background:#ffffff;
                    border-radius:8px;
                    box-shadow:0 2px 8px rgba(0,0,0,0.1)">

            @if($prescriptions->count() > 0)
            <table style="width:100%; border-collapse:collapse;">
                <thead style="background-color:#e5e5e5;">
                    <tr>
                        <th style="padding:12px;">Patient ID</th>
                        <th style="padding:12px;">Medicine Name</th>
                        <th style="padding:12px;">Dosage</th>
                        <th style="padding:12px;">Frequency</th>
                        <th style="padding:12px;">Refills</th>
                        <th style="padding:12px;">Instructions</th>
                        <th style="padding:12px;">Duration (days)</th>
                        <th style="padding:12px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($prescriptions as $prescription)
                    <tr style="border-bottom:1px solid #ddd;">
                        <td style="padding:10px;">
                            {{ $prescription->medical_record->patient_id ?? 'N/A' }}
                        </td>

                        <td style="padding:10px;">
                            {{ $prescription->medicine_name }}
                        </td>

                        <td style="padding:10px;">
                            {{ $prescription->dosage }}
                        </td>

                        <td style="padding:10px;">
                            {{ $prescription->frequency }}
                        </td>

                        <td style="padding:10px;">
                            {{ $prescription->refills }}
                        </td>

                        <td style="padding:10px;">
                            {{ $prescription->instructions }}
                        </td>

                        <td style="padding:10px;">
                            {{ $prescription->duration }}
                        </td>

                        
                        <td style="padding:10px;">
                            <a href="{{ route('prescriptions.edit', $prescription->id) }}"
                               style="background-color:#6c757d; color:#fff;
                                      padding:6px 12px; text-decoration:none;
                                      border-radius:4px; margin-right:4px;">
                                Edit
                            </a>

                            <form action="{{ route('prescriptions.destroy', $prescription->id) }}"
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background-color:#ff7a00; color:#fff;
                                               padding:6px 12px; border:none;
                                               border-radius:4px; cursor:pointer;"


onclick="return confirm('Are you sure you want to delete this prescription?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div style="padding:20px; text-align:center; color:#888;">
                    No prescriptions found.
                </div>
            @endif

        </div>

 
        <a href="{{ url()->previous() }}"
           style="display:inline-block; margin-top:20px;
                  padding:10px 20px; background-color:#ff7a00;
                  color:#fff; text-decoration:none;
                  border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
            Go Back
        </a>

    </div>

</div>
@endsection