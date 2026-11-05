<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trezo - Laravel Admin Dashboard Template</title>
        <!-- Styles -->
        @include('partials.styles')
    </head>
    <body class="boxed-size">
        @include('partials.preloader')
        @include('partials.sidebar')

        <div class="container-fluid">
			<div class="main-content d-flex flex-column">
				<!-- Start Header Area -->
				@include('partials.header')
				<!-- End Header Area -->

				<div class="main-content-container overflow-hidden">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card border-0 rounded-3 welcome-box mb-4 position-relative z-1 overflow-hidden" style="background-color: #4936F5;">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <div class="col-9 col-lg-9 col-sm-6 col-xl-10 col-xxl-7">
                                            <div class="border-bottom" style="border: 0 !important; padding-bottom: 35px;">
                                                <h3 class="text-white fw-semibold mb-1 fs-20">Hi, <span style="color: #FFE8D4;">Dr. Olivia!</span></h3>
                                                <p class="text-body-bg">Your schedule today</p>
                                            </div>

                                            <div class="d-flex align-items-center flex-wrap gap-2 gap-xxl-4">
                                                <div class="d-flex align-items-center welcome-status-item">
                                                    <div class="flex-shrink-0">
                                                        <i class="material-symbols-outlined icon-bg">airplay</i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h5 class="text-white fw-semibold mb-0 fs-18">320</h5>
                                                        <p class="text-light">Patients</p>
                                                    </div>
                                                </div>
                                            
                                                <div class="d-flex align-items-center welcome-status-item">
                                                    <div class="flex-shrink-0">
                                                        <i class="material-symbols-outlined text-primary-div" style="background-color: #F3E8FF;">local_library</i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h5 class="text-white fw-semibold mb-0 fs-18">18</h5>
                                                        <p class="text-light">Surgeries</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 col-lg-3 col-sm-6 col-xl-2 col-xxl-5">
                                            <div class="welcome-img text-center text-sm-end mt-4 mt-sm-0">
                                                <img src="/assets/images/dr-olivia.png" alt="welcome">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <img src="/assets/images/shape-7.png" class="position-absolute top-50 end-0 translate-middle-y z-n1 h-100" alt="shape">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card bg-primary-div bg-opacity-25 border-0 rounded-3 p-4 mb-4 overflow-hidden">
                                        <span class="d-block mb-3" style="color: #526077;">Overall Visitors</span>
                                        <div class="d-flex align-items-center">
                                            <h3 class="fs-24 fw-medium mb-0">45,745</h3>
                                            <span class="d-inline-block px-2 text-success border-success border rounded-pill bg-opacity-25 fs-12 fw-medium ms-2" style="background-color: #D8FFC8;">
                                                <i class="ri-arrow-up-fill"></i>
                                                7%
                                            </span>
                                        </div>
                                        <div style="margin: -16px -35px -80px -38px;">
                                            <div id="overall_visitors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card bg-danger bg-opacity-25 border-0 rounded-3 p-4 mb-4 overflow-hidden">
                                        <span class="d-block mb-3" style="color: #526077;">Patients last 7 days</span>
                                        <div class="d-flex align-items-center">
                                            <h3 class="fs-24 fw-medium mb-0">768</h3>
                                            <span class="d-inline-block px-2 text-danger border-danger border rounded-pill bg-opacity-25 fs-12 fw-medium ms-2" style="background-color: #FFC8C0;">
                                                <i class="ri-arrow-up-fill"></i>
                                                7%
                                            </span>
                                        </div>
                                        <div style="margin: -5px -19px -31px -32px;">
                                            <div id="patients_last_7_days_service"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Patient Admissions & Discharges</h3>
                                        <select class="form-select month-select form-control w-135" aria-label="Default select example">
                                            <option selected>Last Week</option>
                                            <option value="1">Last 60 Days</option>
                                            <option value="2">Last 90 Days</option>
                                        </select>
                                    </div>

                                    <div style="margin: -5px -9px -28px -17px;">
                                        <div id="patient_admissions_discharges"></div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xxl-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <div class="">
                                            <h3 class="mb-0">Emergency Room Visits</h3>
                                            <p>ER based on patient visits</p>
                                        </div>
                                        <select class="form-select month-select form-control w-135" aria-label="Default select example">
                                            <option selected>Last Week</option>
                                            <option value="1">Last 60 Days</option>
                                            <option value="2">Last 90 Days</option>
                                        </select>
                                    </div>

                                    <div style="margin: -36px -21px -63px -18px;">
                                        <div id="emergency_room_visits" style="margin: 35px auto;"></div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xxl-2">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <span class="d-block mb-2">Critical Patients</span>
                                    <h3 class="fs-18 mb-3">780</h3>

                                    <div style="margin: 0 -10px 0 -12px;">
                                        <div id="critical_patients"></div>
                                    </div>

                                    <div class="d-flex align-items-center mb-2 mt-2">
                                        <span style="width: 12px; height: 2px;" class="bg-primary d-inline-block me-2"></span>
                                        <span>Cardiology: <span class="fw-semibold">280</span></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-0">
                                        <span style="width: 12px; height: 2px;" class="bg-danger d-inline-block me-2"></span>
                                        <span>Orthopedics: <span class="fw-semibold">600</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xxl-5">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <div class="">
                                            <h3 class="mb-0">Bed Occupancy Rate</h3>
                                            <p>Currently occupied vs. available.</p>
                                        </div>
                                        <select class="form-select month-select form-control w-135" aria-label="Default select example">
                                            <option selected>Todays</option>
                                            <option value="1">Last 60 Days</option>
                                            <option value="2">Last 90 Days</option>
                                        </select>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center welcome-status-item mb-4">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-bg bg-primary bg-opacity-25 text-primary">airplay</i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="mb-0 fs-18">1,275</h5>
                                                    <p>Total Beds</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center welcome-status-item mb-4">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-bg bg-primary-div bg-opacity-25 text-primary-div">bed</i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="mb-0 fs-18">825</h5>
                                                    <p>Occupied Beds</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center welcome-status-item mb-0">
                                                <div class="flex-shrink-0">
                                                    <i class="material-symbols-outlined icon-bg bg-success bg-opacity-25 text-success">featured_seasonal_and_gifts</i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="mb-0 fs-18">450</h5>
                                                    <p>Available Beds</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-3 mt-sm-0">
                                            <div class="text-center" style="margin-top: -8px;">
                                                <div id="bed_occupancy_rate"></div>
                                                <p class="fs-12 lh-16">The donut or pie chart representing the occupancy rate.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-xl-8 col-md-6">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-3">
                                        <h3 class="mb-0">Patient Appointments</h3>
                                        <select class="form-select month-select form-control h-auto pe-5 w-auto" style="background-position: right 15px center; color: #64748B !important;" aria-label="Default select example">
                                            <option>July 01 - July 31, 2024</option>
                                            <option value="1">August 01 - August 31, 2024</option>
                                            <option selected value="2">September 01 - September 31, 2024</option>
                                        </select>
                                    </div>

                                    <div class="default-table-area style-two patient-table">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class="bg-transparent">Patient Name</th>
                                                        <th scope="col" class="text-end bg-transparent">Date</th>
                                                        <th scope="col" class="text-end bg-transparent">Time</th>
                                                        <th scope="col" class="bg-transparent">Assigned</th>
                                                        <th scope="col" class="text-end bg-transparent">Department</th>
                                                        <th scope="col" class="text-end bg-transparent">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-medium">John Doe</td>
                                                        <td class="text-end fw-medium text-body">Sept 12, 2024</td>
                                                        <td class="text-end fw-medium text-body">10:30 AM</td>
                                                        <td class="fw-medium">
                                                            <div class="d-flex align-items-center">
                                                                <img src="/assets/images/user-71.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                                                <span class="ps-2 fw-medium">Dr. Sarah</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium text-body">Cardiology</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Confirmed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium">Jane Smith</td>
                                                        <td class="text-end fw-medium text-body">Sep 11, 2024	</td>
                                                        <td class="text-end fw-medium text-body">11:00 AM</td>
                                                        <td class="fw-medium">
                                                            <div class="d-flex align-items-center">
                                                                <img src="/assets/images/user-72.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                                                <span class="ps-2 fw-medium">Dr. Mark</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium text-body">Pediatrics</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-danger-div bg-opacity-10 rounded-2 text-danger">Rescheduled</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium">Robert Clark</td>
                                                        <td class="text-end fw-medium text-body">Sep 10, 2024</td>
                                                        <td class="text-end fw-medium text-body">1:00 PM</td>
                                                        <td class="fw-medium">
                                                            <div class="d-flex align-items-center">
                                                                <img src="/assets/images/user-73.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                                                <span class="ps-2 fw-medium">Dr. Emily</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium text-body">Orthopedics</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-danger bg-opacity-10 rounded-2 text-danger">Cancelled</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium">Linda Green</td>
                                                        <td class="text-end fw-medium text-body">Sep 09, 2024</td>
                                                        <td class="text-end fw-medium text-body">9:30 AM</td>
                                                        <td class="fw-medium">
                                                            <div class="d-flex align-items-center">
                                                                <img src="/assets/images/user-74.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                                                <span class="ps-2 fw-medium">Dr. Adam</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium text-body">Dermatology</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-success bg-opacity-10 rounded-2 text-success">Confirmed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-medium">Michael White</td>
                                                        <td class="text-end fw-medium text-body">Sep 08, 2024</td>
                                                        <td class="text-end fw-medium text-body">2:00 PM</td>
                                                        <td class="fw-medium">
                                                            <div class="d-flex align-items-center">
                                                                <img src="/assets/images/user-75.png" class="rounded-circle" style="width: 34px; height: 34px;" alt="user">
                                                                <span class="ps-2 fw-medium">Dr. Rebecca</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end fw-medium text-body">Surgery</td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block py-1 px-2 bg-primary-div bg-opacity-10 rounded-2 text-primary-div">Pending</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap mt-4">
                                            <span class="fs-12 fw-medium">Showing 5 of 30 Results</span>
            
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination mb-0 justify-content-center">
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/hospital" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/hospital">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/hospital">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/hospital">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/hospital">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/hospital" aria-label="Next">
                                                            <i class="material-symbols-outlined">keyboard_arrow_right</i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4 col-md-6">
                            <div class="card border-0 rounded-3 mb-4" style="background-color: #7C24CC;">
                                <div class="card-body p-4 py-5 p-xl-5 text-center">
                                    <h2 class="text-white fs-24 fw-semibold mb-2">Schedule Appointment</h2>
                                    <p class="text-white fs-14 m-auto" style="max-width: 273px;">Quickly schedule an appointment for a patient with any available doctor</p>
                                    <div class="py-4 mb-2">
                                        <img src="/assets/images/schedule.png" alt="schedule">
                                    </div>
                                    <button class="btn btn-primary py-2 px-4 fs-16 fw-medium text-white">Book Appointment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Patient by Age</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>Last Week</option>
                                            <option value="1">Last Month</option>
                                            <option value="2">Last Year</option>
                                        </select>
                                    </div>

                                    <div style="margin-top: -9px;">
                                        <div id="patient_by_age"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="card border-0 rounded-3 mb-4" style="background-color: #FFF5ED;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Hospital Earnings</h3>
                                        <select class="form-select month-select form-control p-0 h-auto border-0 w-90 bg-transparent" style="background-position: right 0 center;" aria-label="Default select example">
                                            <option selected>This Week</option>
                                            <option value="1">Last Month</option>
                                            <option value="2">Last Year</option>
                                        </select>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-lg-5">
                                            <div class="hospital-img pt-3 pb-4 text-center">
                                                <img src="/assets/images/hospital.png" alt="hospital">
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="card bg-white p-4 border-0 rounded-3 mb-4 exchange-for-dark">
                                                        <h2 class="fs-24 fw-medium mb-1">$120,000</h2>
                                                        <p class="fs-12 mb-0">Total Profit <span class="text-danger ms-1"> <i class="ri-arrow-down-fill"></i>5%</span></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="card bg-white p-4 border-0 rounded-3 mb-4 exchange-for-dark">
                                                        <h2 class="fs-24 fw-medium mb-1">$80,000</h2>
                                                        <p class="fs-12 mb-0">Total Costs <span class="text-success ms-1"> <i class="ri-arrow-up-fill"></i>3%</span></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="position-relative z-1">
                                                        <div class="card bg-white p-4 border-0 rounded-3 mb-0 exchange-for-dark">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-7">
                                                                    <h2 class="fs-24 fw-medium mb-1">$900,000</h2>
                                                                    <p class="fs-12 mb-0">Total Earnings <span class="text-success ms-1"> <i class="ri-arrow-up-fill"></i>3%</span></p>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div style="margin: -30px -10px -30px 0;">
                                                                        <div id="total_earnings"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bg-white bg-opacity-75 p-2 p-md-3 mx-3 mx-md-5 rounded-bottom-3 exchange-for-dark"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

				<div class="flex-grow-1"></div>

				<!-- Start Footer Area -->
				@include('partials.footer')
				<!-- End Footer Area -->
			</div>
		</div>

        
        @include('partials.theme_settings')
        @include('partials.scripts')
    </body>
</html>
