<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
         
            </div>

            <ul class="navbar-nav justify-content-end">


                <li class="nav-item d-flex align-items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-link text-body" type="submit">
                            <i class="fa fa-user me-1"></i> Log Out
                        </button>
                    </form>
                </li>

                {{-- إشعارات الجرس --}}
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <button class="btn position-relative p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer text-warning fs-4 bell-animate"></i>

                        @php
                            $unreadCount = auth()->user()->hasRole('clinicManager') 
                                ? $notificationsCount 
                                : (auth()->user()->hasRole('doctor') ? $doctorUnreadCount : 0);
                        @endphp

                        @if($unreadCount > 0)
                            <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">

                        {{-- إشعارات المدير --}}
                        @if(auth()->user()->hasRole('clinicManager'))
                            @forelse($notifications as $notification)
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="{{ $notification['link'] }}">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-primary me-3 my-auto">
                                                @if($notification['type'] == 'invoice')
                                                    <i class="fa fa-credit-card text-white"></i>
                                                @else
                                                    <i class="fa fa-star text-white"></i>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">{{ $notification['title'] }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $notification['message'] }}</p>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>{{ \Carbon\Carbon::parse($notification['date'])->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="text-center text-secondary py-2">لا يوجد إشعارات</li>
                            @endforelse
                        @endif

                        {{-- إشعارات الدكتور --}}
                        @if(auth()->user()->hasRole('doctor'))
                            @forelse($doctorNotifications as $notification)
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="#">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-primary me-3 my-auto">
                                                <i class="fa fa-bell text-white"></i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">{{ $notification->title }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $notification->message }}</p>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="text-center text-secondary py-2">لا يوجد إشعارات</li>
                            @endforelse
                        @endif

                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
