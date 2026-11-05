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
                        <div class="col-lg-8 col-xxl-9">
                            <div class="rounded-3 p-4 mb-4" style="background: linear-gradient(104deg, #361E7D 2.4%, #403CFF 112.33%);">
                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-1">
                                    <span class="d-block mb-1" style="color: #B1BBC8;">Today’s Payment</span>
                                    <select class="form-select month-select form-control w-135 bg-border-color border-color" aria-label="Default select example">
                                        <option selected="">All</option>
                                        <option value="1">Monthly</option>
                                        <option value="1">Yearly</option>
                                    </select>
                                </div>
                                <div  class="d-flex align-items-center mb-4">
                                    <h3 class="fs-32 fw-bold text-white mb-0">$1,528</h3>
                                    <span class="fw-medium fs-12 border border-success px-2 rounded-pill ms-2" style="background-color: #D8FFC8; color: #1E8308;">
                                        +5.4%
                                    </span>
                                </div>

                                <div style="margin: -24px -9px -27px -17px;">
                                    <div id="today_payment"></div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xxl-3">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center position-relative">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-2">Active User</span>
                                            <h3 class="fs-24 fw-bold">241K</h3>
                                            <span class="bg-success bg-opacity-10 border border-success rounded-pill text-success px-2 fs-12 fw-medium d-inline-block">+5.4%</span>
                                        </div>
                                        <div class="position-absolute top-50 end-0 translate-middle-y saas-chart-position">
                                            <div id="active_user" style="width: 95px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center position-relative">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-2">Revenue</span>
                                            <h3 class="fs-24 fw-bold">$1.2M</h3>
                                            <span class="bg-danger bg-opacity-10 border border-danger rounded-pill text-danger px-2 fs-12 fw-medium d-inline-block">-3.2%</span>
                                        </div>
                                        <div class="position-absolute top-50 end-0 translate-middle-y saas-chart-position">
                                            <div id="revenue_two" style="width: 130px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center position-relative">
                                        <div class="flex-grow-1 me-3">
                                            <span class="d-block mb-2">Conversion</span>
                                            <h3 class="fs-24 fw-bold">32.5%</h3>
                                            <span class="bg-success bg-opacity-10 border border-success rounded-pill text-success px-2 fs-12 fw-medium d-inline-block">+1.4%</span>
                                        </div>
                                        <div class="position-absolute top-50 end-0 translate-middle-y saas-chart-position">
                                            <div id="conversion" style="width: 130px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="mb-3 mb-lg-30 d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                        <h3 class="mb-0">Top Refers</h3>
                                        <a href="#" class="text-body text-decoration-none">
                                            <span>Browse All</span>
                                            <i class="ri-arrow-right-s-line"></i>
                                        </a>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled">
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/facebook.svg" style="width: 31px;" alt="facebook">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Facebook</h4>
                                                            <span class="fs-12">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #DDE4FF;" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 50%; height: 8px; background-color: #757DFF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">50%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/dribbble.svg" style="width: 31px;" alt="dribbble">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Dribbble</h4>
                                                            <span class="fs-12">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #DAEBFF;" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 75%; height: 8px; background-color: #5DA8FF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/instagram.svg" style="width: 31px;" alt="instagram">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Instagram</h4>
                                                            <span class="fs-12">Reel</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #FFE8D4;" role="progressbar" aria-label="Example with label" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 30%; height: 8px; background-color: #FE7A36;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">30%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/behance.svg" style="width: 31px;" alt="behance">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Behance</h4>
                                                            <span class="fs-12">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #F3E8FF;" role="progressbar" aria-label="Example with label" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 80%; height: 8px; background-color: #BF85FB;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">80%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/figma.svg" style="width: 31px;" alt="figma">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Figma</h4>
                                                            <span class="fs-12">Community</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #DAEBFF;" role="progressbar" aria-label="Example with label" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 50%; height: 8px; background-color: #5DA8FF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">50%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex">
                                                        <img src="/assets/images/google2.svg" style="width: 31px;" alt="google">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-14 fw-semibold lh-1">Google</h4>
                                                            <span class="fs-12">SEO & PPC</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #D8FFC8;" role="progressbar" aria-label="Example with label" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 20%; height: 8px; background-color: #58F229;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-12">20%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 mb-lg-30">
                                        <h3 class="mb-0">Active Users</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color" aria-label="Default select example">
                                            <option selected>Monthly</option>
                                            <option value="1">Yearly</option>
                                        </select>
                                    </div>
                                    
                                    <div style="margin: -24px -30px -27px -17px;">
                                        <div id="active_users"></div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                        <h3 class="mb-0">Latest Transaction</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color" aria-label="Default select example">
                                            <option selected>Monthly</option>
                                            <option value="1">Yearly</option>
                                        </select>
                                    </div>
                                    <div class="default-table-area style-two campaigns-table latest-transaction-table">
                                        <div class="table-responsive">
                                            <table class="table align-middle border-0">
                                                <thead>
                                                    <tr class="border-bottom">
                                                        <th scope="col" class=" bg-transparent text-body fw-medium">
                                                            <span class="fs-12">ID</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">CLIENT</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">AMOUNT</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">SUBSCRIPTION PLAN</span>
                                                        </th>
                                                        <th scope="col" class="bg-transparent text-body fw-medium">
                                                            <span class="fs-12">PAYMENT METHOD</span>
                                                        </th>
                                                        <th scope="col" class="text-end bg-transparent text-body fw-medium">
                                                            <span class="fs-12">STATUS</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body">#001</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-81.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Johhna Loren</h4>
                                                                    <span class="fs-12">loren123@gmail.com</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">$6240</td>
                                                        <td class="fs-12 fw-semibold text-body">Pro</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/paypal.png" alt="paypal">
                                                                <span class="ms-2">Paypal</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block px-2 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">Completed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body">#002</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-82.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Skyler White</h4>
                                                                    <span class="fs-12">skyqueen@gmail.com</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">$5135</td>
                                                        <td class="fs-12 fw-semibold text-body">Enterprise</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/wise.png" alt="paypal">
                                                                <span class="ms-2">Wise</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block px-2 bg-primary-div bg-opacity-10 text-primary-div border border-primary-div rounded-pill fs-12 fw-medium">Pending</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body">#003</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-83.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Jonathon Watson</h4>
                                                                    <span class="fs-12">jona2134@gmail.com</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">$4321</td>
                                                        <td class="fs-12 fw-semibold text-body">Startup</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/bank.png" alt="bank">
                                                                <span class="ms-2">Bank</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block px-2 bg-danger bg-opacity-10 text-danger border border-danger rounded-pill fs-12 fw-medium">Failed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body">#004</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-84.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">Walter White</h4>
                                                                    <span class="fs-12">Puzzleworld</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">$3124</td>
                                                        <td class="fs-12 fw-semibold text-body">Pro</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/skrill.png" alt="skrill">
                                                                <span class="ms-2">Skrill</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block px-2 bg-success bg-opacity-10 text-success border border-success rounded-pill fs-12 fw-medium">Completed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-12 fw-semibold text-body">#005</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="/assets/images/user-85.png" class="rounded-circle" style="width: 40px; height: 40px;" alt="nft">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2">
                                                                    <h4 class="fs-14 fw-semibold mb-0">David Carlen</h4>
                                                                    <span class="fs-12">Liveslong</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="fs-12 fw-semibold text-body">$2137</td>
                                                        <td class="fs-12 fw-semibold text-body">Basic</td>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <img src="/assets/images/paypal.png" alt="paypal">
                                                                <span class="ms-2">Paypal</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="d-inline-block px-2 bg-primary-div bg-opacity-10 text-primary-div border border-primary-div rounded-pill fs-12 fw-medium">Pending</span>
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
                                                        <a class="page-link icon" href="/saas" aria-label="Previous">
                                                            <i class="material-symbols-outlined">keyboard_arrow_left</i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link active" href="/saas">1</a></li>
                                                    <li class="page-item"><a class="page-link" href="/saas">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="/saas">3</a></li>
                                                    <li class="page-item"><a class="page-link" href="/saas">4</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link icon" href="/saas" aria-label="Next">
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
                        <div class="col-lg-4">
                            <div class="rounded-3 p-4 text-center mb-4" style="background: linear-gradient(164deg, #B95232 3.1%, #EB6D5C 99.22%);">
                                <h2 class="fs-24 text-white mx-auto mb-5 text-center" style="max-width: 300px; line-height: 1.4;">Have A Team More Than 10 Members?</h2>
                                <a href="#" class="btn btn-dark fs-16 fw-medium rounded-3 py-2 px-3">
                                    Upgrade Plans
                                </a>
                                <div class="text-center py-5 mt-4">
                                    <img src="/assets/images/saas.png" alt="saas">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3 border-bottom pb-4">
                                        <h3 class="mb-0">Active Users</h3>
                                        <div class="dropdown action-opt">
                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-horizontal"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="clock"></i>
                                                        Today
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="pie-chart"></i>
                                                        Last 7 Days
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="rotate-cw"></i>
                                                        Last Month
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="calendar"></i>
                                                        Last 1 Year
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="bar-chart"></i>
                                                        All Time
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="eye"></i>
                                                        View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="trash"></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="position-relative">
                                                <img src="/assets/images/user-92.png" class="rounded-circle" style="width: 33px; height: 33px;" alt="user">
                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2 bottom-0"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-14 fw-semibold mb-0">Johhna Loren</h4>
                                            <span class="fs-12">Admin</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="position-relative">
                                                <img src="/assets/images/user-93.png" class="rounded-circle" style="width: 33px; height: 33px;" alt="user">
                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2 bottom-0"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-14 fw-semibold mb-0">Zinia Watson Loren</h4>
                                            <span class="fs-12">Moderator</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="position-relative">
                                                <img src="/assets/images/user-94.png" class="rounded-circle" style="width: 33px; height: 33px;" alt="user">
                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2 bottom-0"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-14 fw-semibold mb-0">Angela Carter</h4>
                                            <span class="fs-12">Editor</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="position-relative">
                                                <img src="/assets/images/user-95.png" class="rounded-circle" style="width: 33px; height: 33px;" alt="user">
                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2 bottom-0"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-14 fw-semibold mb-0">Skyler White</h4>
                                            <span class="fs-12">Admin</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="position-relative">
                                                <img src="/assets/images/user-96.png" class="rounded-circle" style="width: 33px; height: 33px;" alt="user">
                                                <div class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2 bottom-0"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-14 fw-semibold mb-0">Jane Ronan</h4>
                                            <span class="fs-12">Editor</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center border-bottom pb-3">
                                        <div class="flex-shrink-0">
                                            <div class="position-relative">
                                                <img src="/assets/images/user-97.png" class="rounded-circle" style="width: 33px; height: 33px;" alt="user">
                                                <div class="position-absolute p-1 bg-danger border border-2 border-white rounded-circle status-position2 bottom-0"></div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="fs-14 fw-semibold mb-0">Viktor James</h4>
                                            <span class="fs-12">Editor</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <h3 class="mb-0">Product Trade Condition</h3>
                                        <select class="form-select month-select form-control w-135 bg-border-color border-color" aria-label="Default select example">
                                            <option selected>Monthly</option>
                                            <option value="1">Yearly</option>
                                        </select>
                                    </div>
                                    
                                    <div style="margin: -25px -12px -21px -13px;">
                                        <div id="product_trade_condition"></div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 align-items-center mt-4 pt-2">
                                        <div class="border-end pe-4 me-4">
                                            <span class="d-block mb-1">Forcast Hours</span>
                                            <div class="d-flex align-items-center">
                                                <h2 class="fs-24 mb-0 me-2">144h </h2>
                                                <span class="fs-12 fw-medium d-inline-block bg-success border-success border text-success bg-opacity-10 px-2 rounded-pill">+5.4%</span>
                                            </div>
                                        </div>
                                        <div class="border-end pe-4 me-4">
                                            <span class="d-block mb-1">Workflow Hours</span>
                                            <div class="d-flex align-items-center">
                                                <h2 class="fs-24 mb-0 me-2">120h </h2>
                                                <span class="fs-12 fw-medium d-inline-block bg-danger border-danger border text-danger bg-opacity-10 px-2 rounded-pill">-3.2%</span>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="d-block mb-1">Forcast Income</span>
                                            <div class="d-flex align-items-center">
                                                <h2 class="fs-24 mb-0 me-2">$350K</h2>
                                                <span class="fs-12 fw-medium d-inline-block bg-success border-success border text-success bg-opacity-10 px-2 rounded-pill">+3.9%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card bg-white border-0 p-4 mb-4 rounded-10">
                                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-1">
                                    <span class="d-block mb-1">Gross Revenue</span>
                                    <select class="form-select month-select form-control w-135 bg-border-color border-color" aria-label="Default select example">
                                        <option selected="">Monthly</option>
                                        <option value="1">Yearly</option>
                                    </select>
                                </div>
                                <div  class="d-flex align-items-center mb-2">
                                    <h3 class="fs-32 fw-bold text-secondary mb-0">$1,528</h3>
                                    <span class="fw-medium fs-12 text-success bg-success bg-opacity-10 border border-success px-2 rounded-pill ms-2">
                                        +5.4%
                                        <i class="ri-arrow-up-line"></i>
                                    </span>
                                </div> 
                                <span class="fs-12 d-block mb-4">vs previous 30 days</span>

                                <div style="margin: -24px -11px -15px -16px;">
                                    <div id="gross_revenue"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-white border-0 rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                        <h3 class="mb-0">Sales By Country</h3>
                                        <div class="dropdown action-opt">
                                            <button class="btn bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i data-feather="more-horizontal"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="clock"></i>
                                                        Today
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="pie-chart"></i>
                                                        Last 7 Days
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="rotate-cw"></i>
                                                        Last Month
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="calendar"></i>
                                                        Last 1 Year
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="bar-chart"></i>
                                                        All Time
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="eye"></i>
                                                        View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;">
                                                        <i data-feather="trash"></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="ext-center" style="margin: 54px 0;">
                                        <div id="sales_by_country_map"></div>
                                    </div>
                                    <ul class="ps-0 mb-0 list-unstyled">
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/united-states-3.png" style="width: 24px;" alt="united-states">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-12 fw-semibold lh-1">United States</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 85%; height: 8px; background-color: #757DFF;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">85%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/japan.png" style="width: 24px;" alt="japan">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-12 fw-semibold lh-1">Japan</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 65%; height: 8px; background-color: #0F79F3;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">65%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/australia-2.png" style="width: 24px;" alt="australia">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-12 fw-semibold lh-1">Australia</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 45%; height: 8px; background-color: #9135E8;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">45%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="flex-shrink-0">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/assets/images/germany-2.png" style="width: 24px;" alt="germany">
                                                        <div class="ms-3">
                                                            <h4 class="mb-0 fs-12 fw-semibold lh-1">Germany</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <div class="progress-responsive" style="width: 120px;">
                                                            <div class="progress rounded-pill" style="height: 8px; background-color: #ECF0FF;" role="progressbar" aria-label="Example with label" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar rounded-pill" style="width: 75%; height: 8px; background-color: #25B003;"></div>
                                                            </div>
                                                        </div>
                                                        <span class="count text-body ms-3 fs-14 fw-medium">75%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
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