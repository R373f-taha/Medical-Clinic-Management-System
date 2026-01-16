@extends('layouts.app')

@section('content')
<div class="container-fluid px-2">

@can('manage medical records')

    <h5 class="mb-3 fw-semibold">Medical Records</h5>

    @if(session('success'))
        <div class="alert alert-success py-2 small">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger py-2 small">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-2">

            <table class="table table-bordered table-hover table-sm align-middle text-center mb-0 small"
                   style="table-layout: fixed; width: 100%;">

                <thead class="table-light">
                    <tr>
                        <th style="width: 3%;">#</th>
                        <th style="width: 14%;">Patient</th>
                        <th style="width: 14%;">Doctor</th>
                        <th style="width: 17%;">Diagnosis</th>
                        <th style="width: 17%;">Treatment</th>
                        <th style="width: 10%;">Follow-up</th>
                        <th style="width: 15%;">Images</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="text-truncate">
                                {{ $record->patient->user->name ?? 'N/A' }}
                            </td>

                            <td class="text-truncate">
                                {{ $record->doctor->user->name ?? 'N/A' }}
                            </td>

                            <td class="text-start text-wrap">
                                {{ $record->diagnosis ?? '-' }}
                            </td>

                            <td class="text-start text-wrap">
                                {{ $record->treatment_plan ?? '-' }}
                            </td>

                            <td class="small">
                                {{ $record->follow_up_date
                                    ? \Carbon\Carbon::parse($record->follow_up_date)->format('Y-m-d')
                                    : '—'
                                }}
                            </td>

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

                            {{-- Action --}}
                            <td>
                                <form action="{{ route('admin.medical-records.destroy', $record->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm px-2 py-1">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted py-3">
                                No medical records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

    <div class="mt-2 d-flex justify-content-end small">
        {{ $records->links() }}
    </div>

@else
    <div class="alert alert-danger small">
        You are not authorized to view medical records.
    </div>
@endcan

</div>
@endsection
