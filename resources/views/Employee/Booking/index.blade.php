@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Bookings</h4>

        @can('manage appointments')
            <a href="{{ route('employee.bookings.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Booking
            </a>
        @endcan
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success py-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th style="width:140px;">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($bookings as $b)
                <tr>
                    <td class="text-truncate" style="max-width:120px;">
                        {{ $b->patient?->user?->name }}
                    </td>

                    <td class="text-truncate" style="max-width:120px;">
                        {{ $b->doctor?->user?->name }}
                    </td>

                    <td>
                        {{ $b->appointment_date->format('Y-m-d H:i') }}
                    </td>

                    <td class="text-truncate" style="max-width:180px;">
                        {{ $b->reason ?? '-' }}
                    </td>

                    <td>
                        @if($b->status === 'hold')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($b->status === 'scheduled')
                            <span class="badge bg-primary">Scheduled</span>
                        @elseif($b->status === 'completed')
                            <span class="badge bg-success">Completed</span>
                        @elseif($b->status === 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </td>

                    {{-- ACTIONS --}}
                    <td>
                        <div class="d-flex justify-content-center gap-2">

                            {{-- HOLD --}}
                            @if($b->status === 'hold')

                                {{-- Accept --}}
                                <form method="POST" action="{{ route('employee.bookings.approve', $b->id) }}">
                                    @csrf
                                    <i class="fas fa-check action-icon success"
                                       title="Accept"
                                       onclick="this.closest('form').submit()"></i>
                                </form>

                                {{-- Reject --}}
                                <form method="POST" action="{{ route('employee.bookings.reject', $b->id) }}">
                                    @csrf
                                    <i class="fas fa-times action-icon danger"
                                       title="Reject"
                                       onclick="this.closest('form').submit()"></i>
                                </form>

                                {{-- Edit --}}
                                <a href="{{ route('employee.bookings.edit', $b->id) }}">
                                    <i class="fas fa-edit action-icon warning" title="Edit"></i>
                                </a>
                            @endif


                            {{-- SCHEDULED --}}
                            @if($b->status === 'scheduled')

                                {{-- Edit --}}
                                <a href="{{ route('employee.bookings.edit', $b->id) }}">
                                    <i class="fas fa-edit action-icon warning" title="Edit"></i>
                                </a>

                                {{-- Complete --}}
                                <form method="POST" action="{{ route('employee.bookings.complete', $b->id) }}">
                                    @csrf
                                    <i class="fas fa-check-circle action-icon info"
                                       title="Complete"
                                       onclick="this.closest('form').submit()"></i>
                                </form>

                                {{-- Delete --}}
                                <form method="POST"
                                      action="{{ route('employee.bookings.destroy', $b->id) }}"
                                      onsubmit="return confirm('Delete booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <i class="fas fa-trash action-icon danger"
                                       title="Delete"
                                       onclick="this.closest('form').submit()"></i>
                                </form>
                            @endif


                            {{-- COMPLETED --}}
                            @if($b->status === 'completed')
                                <form method="POST"
                                      action="{{ route('employee.bookings.destroy', $b->id) }}"
                                      onsubmit="return confirm('Delete booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <i class="fas fa-trash action-icon danger"
                                       title="Delete"
                                       onclick="this.closest('form').submit()"></i>
                                </form>
                            @endif

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-muted py-3">
                        No bookings found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- STYLE --}}
<style>
.table {
    font-size: 0.85rem;
}

.table th, .table td {
    padding: 0.4rem;
    white-space: nowrap;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
}

.container-fluid {
    max-width: calc(100vw - 260px);
}

/* ICONS */
.action-icon {
    font-size: 1.1rem;
    cursor: pointer;
}

.action-icon.success { color: #198754; }
.action-icon.danger  { color: #dc3545; }
.action-icon.warning { color: #ffc107; }
.action-icon.info    { color: #0dcaf0; }

.action-icon:hover {
    opacity: 0.7;
}

@media (max-width: 768px) {
    .container-fluid {
        max-width: 100vw;
    }
}
</style>
@endsection
