<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl"
     id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    Dashboard
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>

        <!-- Right side -->
        <div class="d-flex align-items-center ms-auto">

            <!-- Log Out -->
            <form method="POST" action="{{ route('logout') }}" class="me-3">
                @csrf
                <button class="btn btn-link text-body p-0" type="submit">
                    <i class="fa fa-user me-1"></i>
                    Log Out
                </button>
            </form>

            <!-- Notifications -->
            <div class="nav-item dropdown">
                <a class="nav-link position-relative p-0" href="#" id="bellDropdown">
                    <i class="fa fa-bell text-warning fs-4 bell-animate"></i>

                    @if($bellUnreadCount > 0)
                        <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle">
                            {{ $bellUnreadCount }}
                        </span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end px-2 py-3">

                    @forelse($bellNotifications as $n)
                        <li class="mb-2">
                            <a href="#"
                               class="dropdown-item show-notification border-radius-md"
                               data-title="{{ $n['title'] }}"
                               data-patient="{{ $n['patient'] ?? '' }}"
                               data-doctor="{{ $n['doctor'] ?? '' }}"
                               data-rating="{{ $n['rating'] ?? '' }}"
                               data-reason="{{ $n['reason'] ?? '' }}"
                               data-status="{{ $n['status'] ?? '' }}"
                               data-date="{{ $n['appointment_date'] ?? $n['date'] }}"
                               data-details="{{ $n['details'] ?? '' }}">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-gradient-primary me-3 my-auto">
                                        <i class="fa fa-bell text-white"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1" style="color: #ff6f00;">
                                            {{ $n['title'] }}
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            {{ \Carbon\Carbon::parse($n['date'])->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="text-center text-secondary py-2">
                            No notifications
                        </li>
                    @endforelse

                </ul>
            </div>

        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: #ffffff; border-radius: 12px;">
            <div class="modal-header" style="border-bottom: none;">
                <h5 class="modal-title" id="modalTitle" style="color: #ff6f00; font-weight: 600;"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody" style="color: #333; font-size: 14px;"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Open dropdown
    const bell = document.getElementById('bellDropdown');
    if (bell) {
        bell.addEventListener('click', function (e) {
            e.preventDefault();
            bootstrap.Dropdown.getOrCreateInstance(bell).toggle();
        });
    }

    // Show modal with details
    document.querySelectorAll('.show-notification').forEach(el => {
        el.addEventListener('click', function () {

            let html = `<table style="width:100%; border-collapse: collapse; font-size: 14px;">`;
            html += `<tr style="background-color: #ff9800; color: #fff;">
                        <th style="padding: 8px; text-align: left;">Appointment</th>
                        <th style="padding: 8px; text-align: left;">Details</th>
                     </tr>`;

            if (this.dataset.patient)
                html += `<tr><td>Patient</td><td>${this.dataset.patient}</td></tr>`;
            if (this.dataset.doctor)
                html += `<tr><td>Doctor</td><td>${this.dataset.doctor}</td></tr>`;
            if (this.dataset.reason)
                html += `<tr><td>Reason</td><td>${this.dataset.reason}</td></tr>`;
            if (this.dataset.status)
                html += `<tr><td>Status</td><td>${this.dataset.status}</td></tr>`;
            if (this.dataset.date)
                html += `<tr><td>Time</td><td>${this.dataset.date}</td></tr>`;

            html += `</table>`;
            html += `<hr style="border-top: 1px solid #ff9800;">`;
            html += `<p>${this.dataset.details}</p>`;

            document.getElementById('modalTitle').textContent = this.dataset.title;
            document.getElementById('modalBody').innerHTML = html;

            new bootstrap.Modal(document.getElementById('notificationModal')).show();
        });
    });
});
</script>

<!-- Styles -->
<style>
.avatar.bg-gradient-primary {
    background: linear-gradient(135deg, #ff9800, #ff6f00);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
}
#notificationModal .modal-title { font-weight: 600; color: #ff6f00; }
#notificationModal .modal-body p { margin: 6px 0; font-size: 14px; color: #333; }
#notificationModal .modal-body hr { border-top: 1px solid #ff9800; }
.bell-animate { animation: bell 2s infinite; }
@keyframes bell { 0% { transform: rotate(0); } 5% { transform: rotate(15deg); } 10% { transform: rotate(-15deg); } 15% { transform: rotate(10deg); } 20% { transform: rotate(-10deg); } 25% { transform: rotate(0); } }
#notificationModal table { border: 1px solid #ff9800; background-color: #ffffff; }
#notificationModal th, #notificationModal td { border: 1px solid #ff9800; padding: 6px 10px; text-align: left; }
</style>
