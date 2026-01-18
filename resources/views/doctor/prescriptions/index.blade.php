@extends('layouts.app')

@section('content')
<div style="background-color:#f3f3f3; min-height:100vh; padding:30px">

    <div style="max-width:1200px; margin:auto;">

        {{-- Success Message --}}
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
            @can('manage prescriptions')
            <a href="{{ route('doctor.prescriptions.create') }}"
               style="background-color:#ff7a00; color:#fff; padding:10px 16px; text-decoration:none; border-radius:6px;">
                + Add New Prescription
            </a>
            @endcan
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto; background:#ffffff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
            @if($prescriptions->count() > 0)
            <table style="width:100%; border-collapse:collapse; text-align:center;">
                <thead style="background-color:#e5e5e5;">
                    <tr>
                        <th>Patient</th>
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
                        <td>{{ $prescription->medical_record->patient->user->name ?? 'N/A' }}</td>
                        <td>{{ $prescription->medicine_name }}</td>
                        <td>{{ $prescription->dosage }}</td>
                        <td>{{ $prescription->frequency }}</td>
                        <td>{{ $prescription->refills }}</td>
                        <td>{{ $prescription->instructions }}</td>
                        <td>{{ $prescription->duration }}</td>
                        <td style="display:flex; gap:10px; justify-content:center; align-items:center;">
                            {{-- Edit --}}
                            <a href="{{ route('doctor.prescriptions.edit', $prescription->id) }}" title="Edit">
                                <i class="fas fa-edit action-icon text-warning" style="font-size:1.3rem;"></i>
                            </a>

                            {{-- Delete --}}
                            <form id="delete-form-{{ $prescription->id }}"
                                  action="{{ route('doctor.prescriptions.destroy', $prescription->id) }}"
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="confirmDeletePrescription({{ $prescription->id }})"
                                        style="background:none; border:none; padding:0;">
                                    <i class="fas fa-trash action-icon text-danger"
                                       style="font-size:1.3rem; cursor:pointer;"
                                       title="Delete"></i>
                                </button>
                            </form>

                            {{-- Show --}}
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

        {{-- Back Button --}}
  <a href="{{ route('dashboard') }}"
            style="display:inline-block; margin-top:20px; padding:10px 20px; background-color:#ff7a00; color:#fff; text-decoration:none; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1); transition:background-color 0.3s;">
            Go Back
        </a>

    </div>
</div>

{{-- SweetAlert2 Script --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeletePrescription(id) {
    Swal.fire({
        title: 'Delete Prescription?',
        text: "This prescription will be permanently deleted!",
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#dc3545',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>

{{-- Styles --}}
<style>
.action-icon {
    transition: transform 0.2s;
}
.action-icon:hover {
    transform: scale(1.2);
    cursor: pointer;
}
</style>

{{-- FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection
