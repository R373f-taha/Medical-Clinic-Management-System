@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:800px; margin:auto;">

        
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#ff7a00;">
                Edit Prescription
            </h2>

            <a href="{{ route('prescriptions.index') }}"
               style="background-color:#6c757d; color:#fff;
                      padding:10px 16px; text-decoration:none;
                      border-radius:6px;">
                Back to List
            </a>
        </div>

       
        <div style="background:#ffffff; border-radius:8px;
                    box-shadow:0 2px 8px rgba(0,0,0,0.1);
                    padding:25px;">

            <form action="{{ route('prescriptions.update', $prescription->id) }}" method="POST">
                @csrf
                @method('PUT')

             
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Patient</label>
                    <select name="medical_record_id"
                            style="width:100%; padding:10px; border-radius:6px;
                                   border:1px solid #ccc;" required>
                        <option value="">Select Patient</option>
                        @foreach($medicalRecords as $record)
                            <option value="{{ $record->id }}"
                                {{ $prescription->medical_record_id == $record->id ? 'selected' : '' }}>
                                Patient ID: {{ $record->patient_id }} | Doctor ID: {{ $record->doctor_id }}
                            </option>
                        @endforeach
                    </select>
                </div>

               
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Medicine Name</label>
                    <input type="text" name="medicine_name"
                           value="{{ $prescription->medicine_name }}"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

                
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Dosage</label>
                    <input type="text" name="dosage"
                           value="{{ $prescription->dosage }}"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Frequency</label>
                    <input type="text" name="frequency"
                           value="{{ $prescription->frequency }}"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

                
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Refills</label>
                    <input type="number" name="refills" min="0"
                           value="{{ $prescription->refills }}"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

                
                <div style="margin-bottom:15px;">
                    <label style="font-weight:600;">Instructions</label>


<textarea name="instructions" rows="2"
                              style="width:100%; padding:10px; border-radius:6px;
                                     border:1px solid #ccc;" required>{{ $prescription->instructions }}</textarea>
                </div>

                
                <div style="margin-bottom:25px;">
                    <label style="font-weight:600;">Duration (days)</label>
                    <input type="number" name="duration" min="1"
                           value="{{ $prescription->duration }}"
                           style="width:100%; padding:10px; border-radius:6px;
                                  border:1px solid #ccc;" required>
                </div>

                
                <div style="display:flex; gap:10px;">
                    <button type="submit"
                            style="background-color:#ff7a00; color:#fff;
                                   padding:10px 20px; border:none;
                                   border-radius:6px; cursor:pointer;">
                        Update Prescription
                    </button>

                    <a href="{{ route('prescriptions.index') }}"
                       style="background-color:#6c757d; color:#fff;
                              padding:10px 20px; text-decoration:none;
                              border-radius:6px;">
                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>
@endsection