@extends('layouts.app')

@section('content')
<div class="container-fluid px-3">

    @can('manage medical records')

        <h1 class="mb-4">Medical Records</h1>

        {{-- Success message --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-2">

                <table class="table table-bordered table-hover table-sm align-middle text-center mb-0"
                       style="table-layout: fixed; width: 100%;">

                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 20%;">Patient</th>
                            <th style="width: 20%;">Doctor</th>
                            <th style="width: 25%;">Diagnosis</th>
                            <th style="width: 30%;">Treatment Plan</th>
                            <th style="width: 15%;">Follow-up Date</th>
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

                                <td class="text-wrap small">
                                    {{ $record->diagnosis }}
                                </td>

                                <td class="text-wrap small">
                                    {{ $record->treatment_plan }}
                                </td>

                                <td>
                                    {{ $record->follow_up_date
                                        ? \Carbon\Carbon::parse($record->follow_up_date)->format('Y-m-d')
                                        : 'N/A'
                                    }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>

        <div class="mt-3">
            {{ $records->links() }}
        </div>

    @else
        <div class="alert alert-danger">
            You are not authorized to view medical records.
        </div>
    @endcan

</div>
@endsection
