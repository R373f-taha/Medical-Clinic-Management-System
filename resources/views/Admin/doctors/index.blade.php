@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">

    @can('manage doctors')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 text-warning">Doctors</h4>
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-warning btn-sm">
            <i class="fas fa-plus"></i> Add Doctor
        </a>
    </div>

    <div class="table-responsive bg-white rounded shadow-sm p-2">
        <table class="table table-bordered table-striped align-middle text-center mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Qualifications</th>
                    <th>Available Hours</th>
                    <th>Experience</th>
                    <th>Services</th>
                    <th style="width:100px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($doctors as $doctor)
                <tr>
                    <td class="text-truncate" style="max-width:150px;">{{ $doctor->user->name }}</td>
                    <td>{{ $doctor->specialization }}</td>
                    <td>{{ $doctor->qualifications }}</td>
                    <td>{{ $doctor->available_hours }}</td>
                    <td>{{ $doctor->experience_years ?? '-' }}</td>
                    <td>{{ implode('، ', $doctor->services) }}</td>

                    {{-- ACTIONS --}}
                    <td>
                        <div class="d-flex justify-content-center gap-1">

                            {{-- Edit --}}
                            <a href="{{ route('admin.doctors.edit', $doctor->id) }}">
                                <i class="fas fa-edit action-icon edit" title="Update Doctor"></i>
                            </a>

                            {{-- View Appointments --}}
                            <a href="{{ route('admin.doctors.show', $doctor->id) }}">
                                <i class="fas fa-calendar-check action-icon view" title="View Appointments"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-icon delete" title="Delete Doctor" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-muted py-3">No doctors found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Back Button --}}
    <a href="{{ url()->previous() }}" class="btn btn-warning btn-sm mt-3">
        Go Back
    </a>

    @else
    <div class="alert alert-danger">
        You do not have permission to manage doctors.
    </div>
    @endcan
</div>

{{-- STYLE --}}
<style>
.table th, .table td {
    padding: 0.35rem;
    white-space: nowrap;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
}

.action-icon {
    font-size: 1.1rem;
    cursor: pointer;
}

.action-icon.edit {
    color: #6c757d;
}

.action-icon.view {
    color: #0dcaf0;
}

.action-icon.delete {
    color: #ff7a00;
    border: none;
    background: none;
    padding: 0;
}

.action-icon:hover {
    opacity: 0.7;
}

@media (max-width: 768px) {
    .container-fluid {
        max-width: 100vw;
        padding: 0.5rem;
    }

    .table th, .table td {
        font-size: 0.75rem;
    }
}
</style>
@endsection
