@extends('layouts.app')

@section('title', 'Employee')

@section('content')
@if(Auth::user()->hasrole('doctor'))
    @include('partials.doctorDashboard')
@elseif(Auth::user()->hasrole('employee'))

    <style>
        body.employee-dashboard .main-content {
    background-image: url('/images/logo2.png');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    min-height: 100vh;
    background-size: cover;

}

    </style>


@elseif(Auth::user()->hasrole('clinicManager'))
    <div class="row">

        <div class="mb-4 col-lg-8 col-md-12">
            <div class="card h-100">
                <div class="pb-0 card-header">
                    <h6>Profits During the Weeks of the Current Month</h6>
                    <p class="text-sm">
                        <span class="font-weight-bold">Weekly Profit Percentage</span>
                    </p>
                </div>
                <div class="p-3 card-body">
                    <canvas id="weekly-profit-chart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">

            <div class="mb-4 card">
                <div class="pb-0 card-header">
                    <h6>Number of Patients per Clinic</h6>
                </div>
                <div class="p-3 card-body">
                    <canvas id="patients-per-clinic-chart" height="200"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="pb-0 card-header">
                    <h6>Overview of Appointments</h6>
                    <p class="text-sm">Current Appointment Status</p>
                </div>
                <div class="card-body">
                    <canvas id="appointments-status-chart" height="200"></canvas>
                </div>
            </div>

        </div>

    </div>



    </main>
    <div class="fixed-plugin">
        <a class="px-3 py-2 fixed-plugin-button text-dark position-fixed">
            <i class="py-2 fa fa-cog"> </i>
        </a>
        <div class="shadow-lg card ">
            <div class="pt-3 pb-0 card-header ">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Soft UI Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="mt-4 float-end">
                    <button class="p-0 btn btn-link text-dark fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="my-1 horizontal dark">
            <div class="pt-0 card-body pt-sm-3">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="my-2 badge-colors text-start">
                        <span class="badge filter bg-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="px-3 mb-2 btn btn-primary w-100 active" data-class="bg-transparent"
                        onclick="sidebarType(this)">Transparent</button>
                    <button class="px-3 mb-2 btn btn-primary w-100 ms-2" data-class="bg-white"
                        onclick="sidebarType(this)">White</button>
                </div>
                <p class="mt-2 text-sm d-xl-none d-block">You can change the sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <div class="mt-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                </div>
                <div class="form-check form-switch ps-0">
                    <input class="mt-1 form-check-input ms-auto" type="checkbox" id="navbarFixed"
                        onclick="navbarFixed(this)">
                </div>
                <hr class="horizontal dark my-sm-4">
                <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/soft-ui-dashboard">Free
                    Download</a>
                <a class="btn btn-outline-dark w-100"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/license/soft-ui-dashboard">View
                    documentation</a>
                <div class="text-center w-100">
                    <a class="github-button" href="https://github.com/creativetimofficial/soft-ui-dashboard"
                        data-icon="octicon-star" data-size="large" data-show-count="true"
                        aria-label="Star creativetimofficial/soft-ui-dashboard on GitHub">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Soft%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard"
                        class="mb-0 btn btn-dark me-2" target="_blank">
                        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/soft-ui-dashboard"
                        class="mb-0 btn btn-dark me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>

    <script>
        // Weekly Profit Chart
        const weeklyProfitCtx = document
            .getElementById("weekly-profit-chart")
            .getContext("2d");

        new Chart(weeklyProfitCtx, {
            type: "line",
            data: {
                labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
                datasets: [{
                    label: "Profit Percentage %",
                    data: {!! $profits !!},
                    borderColor: "#2dce89",
                    backgroundColor: "rgba(45,206,137,0.2)",
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return value;
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script>
        // Patients Per Clinic Chart
        const patientsClinicCtx = document
            .getElementById("patients-per-clinic-chart")
            .getContext("2d");

        new Chart(patientsClinicCtx, {
            type: "bar",
            data: {
                labels: ["Cardiology", "Neurology", "Pediatrics", "Dermatology", "GeneralSurgery"],
                datasets: [{
                    label: "Patients Number",
                    data: {!! $patients !!},
                    backgroundColor: [
                        "#5e72e4",
                        "#11cdef",
                        "#f5365c",
                        "#fb6340"
                    ],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


    <script>
        const appointmentsCtx = document
            .getElementById("appointments-status-chart")
            .getContext("2d");

        new Chart(appointmentsCtx, {
            type: "doughnut",
            data: {
                labels: [
                    "Completed",
                    "Scheduled",
                    "Canceled"
                ],
                datasets: [{
                    data: {!! $status !!},
                    backgroundColor: [
                        "#2dce89",
                        "#fb6340",
                        "#f5365c"
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom"
                    }
                },
                cutout: "70%"
            }
        });
    </script>


    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
    @endsection
@endif
