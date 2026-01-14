@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:1200px; margin:auto;">
        @if (session('success'))
            <div style="
                background-color:#d4edda;
                color:#155724;
                padding:12px 15px;
                border-radius:6px;
                margin-bottom:20px;
                border:1px solid #c3e6cb;
            ">
                {{ session('success') }}
            </div>
        @endif
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 style="color:#ff7a00;">Prescriptions</h2>

            <a href="{{ route('doctor.prescriptions.create') }}"
               style="background-color:#ff7a00; color:#fff;
                      padding:10px 16px; text-decoration:none;
                      border-radius:6px;">
                + Add New Prescription
            </a>
        </div>

        <div style="overflow-x:auto; background:#ffffff;
                    border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">

            @if($prescriptions->count() > 0)
            <table style="width:100%; border-collapse:collapse; text-align:center;">
                <thead style="background-color:#e5e5e5;">
                    <tr>
                        <th>Patient ID</th>
                        <th>Medicine Name</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Refills</th>
                        <th>Instructions</th>
                        <th>Duration (days)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $prescription)
                    <tr style="border-bottom:1px solid #ddd;">
                        <td>{{ $prescription->medical_record->patient_id ?? 'N/A' }}</td>
                        <td>{{ $prescription->medicine_name }}</td>
                        <td>{{ $prescription->dosage }}</td>
                        <td>{{ $prescription->frequency }}</td>
                        <td>{{ $prescription->refills }}</td>
                        <td>{{ $prescription->instructions }}</td>
                        <td>{{ $prescription->duration }}</td>
                        <td>
                            <a href="{{ route('doctor.prescriptions.edit', $prescription->id) }}" title="Edit">
                                <i class="fas fa-edit action-icon text-warning" style="font-size:1.3rem;"></i>
                            </a>

                            <form action="{{ route('doctor.prescriptions.destroy', $prescription->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <i class="fas fa-trash action-icon text-danger" style="font-size:1.3rem; cursor:pointer;"
                                   title="Delete"
                                   onclick="return confirm('Are you sure you want to delete this prescription?') ? this.closest('form').submit() : false;">
                                </i>
                            </form>
                            <a href="{{ route('doctor.prescriptions.show', $prescription->id) }}">
                                <i class="fas fa-eye action-icon info" title="Show Prescription"></i>
                            </a>
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

<style>
.action-icon {
    transition: transform 0.2s;
}
.action-icon:hover {
    transform: scale(1.2);
}
</style>

@endsection
