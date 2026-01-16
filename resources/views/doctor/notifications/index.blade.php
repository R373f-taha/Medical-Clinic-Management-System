@extends('layouts.app')

@section('title', 'Doctor Notifications')

@section('content')
<div class="container py-4">

    <h4 class="mb-4">إشعاراتي</h4>

    @if($notifications->count() > 0)
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">
                            {{ $notification->title }}
                        </div>
                        <p class="mb-1">{{ $notification->message }}</p>
                        <small class="text-secondary">
                            <i class="fa fa-clock me-1"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>

                    @if(isset($notification->appointment_id))
                        <a href="{{ route('doctor.appointments.show', $notification->appointment_id) }}" 
                           class="btn btn-sm btn-outline-primary">
                            افتح الموعد
                        </a>
                    @endif

                    @if(!$notification->is_read)
                        <form action="{{ route('doctor.notifications.read', $notification->id) }}" method="POST" class="ms-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">تم القراءة</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-secondary text-center">
            لا يوجد إشعارات
        </div>
    @endif

</div>
@endsection
