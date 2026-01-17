@extends('doctor.layouts.app')

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
            <h2 style="color:#ff7a00;">Medical Records</h2>

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
                        <th style="padding:12px; text-align:left;">Images</th>
                        <th style="padding:12px; text-align:left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr style="border-bottom:1px solid #ddd;">
                            <td style="padding:10px;">{{ $record->id }}</td>
                            <td style="padding:10px;">{{ $record->patient->user->name ?? 'N/A' }}</td>
                            <td style="padding:10px;">{{ $record->diagnosis ?? 'N/A' }}</td>
                            <td style="padding:10px;">{{ $record->notes ?? 'N/A' }}</td>
                            <td style="padding:10px;">{{ $record->treatment_plan ?? 'N/A' }}</td>
                            <td style="padding:10px;">{{ $record->follow_up_date ?? '-' }}</td>
                            {{-- Images --}}
                            <td>
                                @if($record->images->count())
                                    <div class="d-flex flex-wrap justify-content-center gap-1">
                                        @foreach($record->images as $image)
                                            <a href="{{ asset($image->image) }}" target="_blank">
                                                <img
                                                    src="{{ asset($image->image) }}"
                                                    alt="medical image"
                                                    width="36"
                                                    height="36"
                                                    class="rounded border"
                                                    style="object-fit: cover;"
                                                >
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">No images</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td style="padding:10px;">
                                <a href="{{ route('doctor.medical_records.edit',$record) }}" title="Edit">
                                    <i class="fas fa-edit action-icon text-warning" style="font-size:1.4rem;"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:20px; text-align:center; color:#888;">
                                No medical records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('dashboard') }}"
            style="display:inline-block; margin-top:20px; padding:10px 20px; background-color:#ff7a00; color:#fff; text-decoration:none; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.1); transition:background-color 0.3s;">
            Go Back
        </a>
    </div>

</div>

<style>
.action-icon {
    transition: transform 0.2s;
}
.action-icon:hover {
    transform: scale(1.3);
    cursor: pointer;
}
</style>

@endsection
