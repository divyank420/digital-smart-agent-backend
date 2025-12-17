@extends('layouts.agent')
@section('content')
    @include('agents.includes.filters.dashboard_filter')
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 border-theme border-start border-0 border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0">Total RM's</p>
                            <h4 class="my-1 text-theme">{{ $dashboardData['total_rm'] }}</h4>
                        </div>
                        <div class="text-theme ms-auto font-35"><i class="bx bx-user"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-primary border-start border-0 border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0">Total Denomination</p>
                            <h4 class="my-1 text-primary">{{ amountFormat($dashboardData['total_denomination']) }}</h4>
                        </div>
                        <div class="text-primary ms-auto font-35"><i class="bx bx-coin-stack"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-success border-start border-0 border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0">Total Collection</p>
                            <h4 class="my-1 text-success">
                                {{ amountFormat($dashboardData['total_collection']) }}</h4>
                        </div>
                        <div class="text-success ms-auto font-35"><i class="bx bx-rupee"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10  border-danger border-start border-0 border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0">Total Expenses</p>
                            <h4 class="text-danger my-1">
                                {{ amountFormat($dashboardData['total_expenses']) }}</h4>
                        </div>
                        <div class="text-danger ms-auto font-35"><i class="bx bx-rupee"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-danger border-start border-0 border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0">Comments</p>
                            <h4 class="my-1 text-danger">8569</h4>
                        </div>
                        <div class="text-danger ms-auto font-35"><i class="bx bx-comment-detail"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Sales Overview</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                    class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container-0">
                        <canvas id="chart1"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card radius-10">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Money Ratio</h6>
                        </div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                    class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container-0">
                        <canvas id="chart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->


    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Recent Orders</h6>
                </div>
                <div class="dropdown ms-auto">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                            class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Photo</th>
                            <th>Product ID</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Iphone 5</td>
                            <td><img src="assets/images/products/01.png" class="product-img-2" alt="product img"></td>
                            <td>#9405822</td>
                            <td><span class="badge bg-success text-white shadow-sm">Paid</span></td>
                            <td>$1250.00</td>
                            <td>03 Feb 2020</td>
                        </tr>

                        <tr>
                            <td>Earphone GL</td>
                            <td><img src="assets/images/products/02.png" class="product-img-2" alt="product img"></td>
                            <td>#8304620</td>
                            <td><span class="badge bg-info text-white shadow-sm">Pending</span></td>
                            <td>$1500.00</td>
                            <td>05 Feb 2020</td>
                        </tr>

                        <tr>
                            <td>HD Hand Camera</td>
                            <td><img src="assets/images/products/03.png" class="product-img-2" alt="product img"></td>
                            <td>#4736890</td>
                            <td><span class="badge bg-danger text-white shadow-sm">Failed</span></td>
                            <td>$1400.00</td>
                            <td>06 Feb 2020</td>
                        </tr>

                        <tr>
                            <td>Clasic Shoes</td>
                            <td><img src="assets/images/products/04.png" class="product-img-2" alt="product img"></td>
                            <td>#8543765</td>
                            <td><span class="badge bg-success text-white shadow-sm">Paid</span></td>
                            <td>$1200.00</td>
                            <td>14 Feb 2020</td>
                        </tr>
                        <tr>
                            <td>Sitting Chair</td>
                            <td><img src="assets/images/products/06.png" class="product-img-2" alt="product img"></td>
                            <td>#9629240</td>
                            <td><span class="badge bg-info text-white shadow-sm">Pending</span></td>
                            <td>$1500.00</td>
                            <td>18 Feb 2020</td>
                        </tr>
                        <tr>
                            <td>Hand Watch</td>
                            <td><img src="assets/images/products/05.png" class="product-img-2" alt="product img"></td>
                            <td>#8506790</td>
                            <td><span class="badge bg-danger text-white shadow-sm">Failed</span></td>
                            <td>$1800.00</td>
                            <td>21 Feb 2020</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script>
    $(function() {
    "use strict";
        var ctx = document.getElementById("chart2").getContext('2d');

        var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["RD LOT", "Collection", "Denomination",'Expenses'],
            datasets: [{
                backgroundColor: [
                    '#f0ad4e',
                    '#a6d96a',
                    '#a18292',
                    '#bb2124',
                ],
                hoverBackgroundColor: [
                    '#f0ad4e',
                    '#a6d96a',
                    '#a18292',
                    '#bb2124'
                ],
            
                data: {{ $dashboardData['pieChart'] }},
                borderWidth: [1, 1, 1]
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutoutPercentage: 75,
            legend: {
                position: 'bottom',
                display: true,
                labels: {
                    boxWidth: 20
                }
            },
            tooltips: {
                displayColors: false,
            }
        }
        });
    });
    </script>
@endpush
