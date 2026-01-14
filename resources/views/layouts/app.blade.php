<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
</head>

<style>
@keyframes bell-shake {
    0%   { transform: rotate(0); }
    10%  { transform: rotate(15deg); }
    20%  { transform: rotate(-15deg); }
    30%  { transform: rotate(10deg); }
    40%  { transform: rotate(-10deg); }
    50%  { transform: rotate(5deg); }
    60%  { transform: rotate(-5deg); }
    100% { transform: rotate(0); }
}

.bell-animate {
    animation: bell-shake 1.2s infinite;
    transform-origin: top center;
}
</style>

<body class="g-sidenav-show bg-gray-100">
    @if (Auth::user()->doctor)
        @include('doctor.partials.sidebar')
    @elseif(Auth::user()->employee)
        @include('employeeDashInfo.partials.sidebar')
    @else
        @include('partials.sidebar')
    @endif


    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @include('partials.navbar')

        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>

    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
</body>
</html>
