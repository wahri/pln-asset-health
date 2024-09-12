@extends('layouts.main')
@section('content')
    <div class="page-content">
        <div class="row row-cols-1 row-cols-lg-3">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Goal Completions</p>
                                <h4 class="font-weight-bold">1,94,2335</h4>
                                <p class="text-secondary mb-0 font-13">Analytics for last month</p>
                            </div>
                            <div class="widgets-icons bg-gradient-kyoto text-white"><i class='bx bxs-cube'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">Bounce Rate</p>
                                <h4 class="font-weight-bold">58% <small class="text-danger font-13">(-16%)</small></h4>
                                <p class="text-secondary mb-0 font-13">Analytics for last week</p>
                            </div>
                            <div class="widgets-icons bg-gradient-blues text-white"><i class='bx bx-line-chart'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="mb-0">New Sessions</p>
                                <h4 class="font-weight-bold">96% <small class="text-danger font-13">(+54%)</small></h4>
                                <p class="text-secondary mb-0 font-13">Analytics for last week</p>
                            </div>
                            <div class="widgets-icons bg-gradient-moonlit text-white"><i class='bx bx-bar-chart'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label class="form-label" for="exampleFormControlSelect1">Select Location</label>
                            <select class="form-select" id="exampleFormControlSelect1">
                                <option>Duri</option>
                                <option>PLTA</option>
                                <option>PLTL</option>
                            </select>
                        </div>
                        <button class="btn btn-primary mt-3">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div id="chart1"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div id="chart2"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-body">
                        <div id="chart3"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4 d-lg-flex align-items-lg-stretch">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent font-weight-bold mb-2 mb-lg-0">Common PLTMG</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th class="text-success">Normal</th>
                                        <th class="text-warning">Abnormal</th>
                                        <th class="text-danger">Fault</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jan</td>
                                        <td>56</td>
                                        <td>10</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td>Feb</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Mar</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Apr</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>May</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Jun</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Jul</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Aug</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card radius-10">
                    <div class="card-header border-bottom-0 bg-transparent">
                        <div class="d-lg-flex align-items-center">
                            <div>
                                <h6 class="font-weight-bold mb-2 mb-lg-0">Historical Analytics</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <div class="cursor-pointer text-dark font-24 dropdown-toggle dropdown-toggle-nocaret"
                                    data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded text-option"></i>
                                </div>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javaScript:;">Action</a>
                                    <a class="dropdown-item" href="javaScript:;">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javaScript:;">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center ms-auto font-13 gap-2">
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class="bx bxs-circle text-success me-1"></i>Normal</span>
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class="bx bxs-circle text-warning me-1"></i>Abnormal</span>
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class="bx bxs-circle text-danger me-1"></i>Fault</span>
                        </div>
                        <div id="chart4"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4 d-lg-flex align-items-lg-stretch">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent font-weight-bold mb-2 mb-lg-0">PLTMG #1</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th class="text-success">Normal</th>
                                        <th class="text-warning">Abnormal</th>
                                        <th class="text-danger">Fault</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jan</td>
                                        <td>56</td>
                                        <td>10</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td>Feb</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Mar</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Apr</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>May</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Jun</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Jul</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Aug</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card radius-10">
                    <div class="card-header border-bottom-0 bg-transparent">
                        <div class="d-lg-flex align-items-center">
                            <div>
                                <h6 class="font-weight-bold mb-2 mb-lg-0">Historical Analytics</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <div class="cursor-pointer text-dark font-24 dropdown-toggle dropdown-toggle-nocaret"
                                    data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded text-option"></i>
                                </div>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javaScript:;">Action</a>
                                    <a class="dropdown-item" href="javaScript:;">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javaScript:;">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center ms-auto font-13 gap-2">
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class="bx bxs-circle text-success me-1"></i>Normal</span>
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class="bx bxs-circle text-warning me-1"></i>Abnormal</span>
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class="bx bxs-circle text-danger me-1"></i>Fault</span>
                        </div>
                        <div id="chart5"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4 d-lg-flex align-items-lg-stretch">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent font-weight-bold mb-2 mb-lg-0">PLTMG #2</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th class="text-success">Normal</th>
                                        <th class="text-warning">Abnormal</th>
                                        <th class="text-danger">Fault</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jan</td>
                                        <td>56</td>
                                        <td>10</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td>Feb</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Mar</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Apr</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>May</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Jun</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Jul</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>Aug</td>
                                        <td>58</td>
                                        <td>5</td>
                                        <td>3</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card radius-10">
                    <div class="card-header border-bottom-0 bg-transparent">
                        <div class="d-lg-flex align-items-center">
                            <div>
                                <h6 class="font-weight-bold mb-2 mb-lg-0">Historical Analytics</h6>
                            </div>
                            <div class="dropdown ms-auto">
                                <div class="cursor-pointer text-dark font-24 dropdown-toggle dropdown-toggle-nocaret"
                                    data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded text-option"></i>
                                </div>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javaScript:;">Action</a>
                                    <a class="dropdown-item" href="javaScript:;">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javaScript:;">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center ms-auto font-13 gap-2">
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class="bx bxs-circle text-success me-1"></i>Normal</span>
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class="bx bxs-circle text-warning me-1"></i>Abnormal</span>
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class="bx bxs-circle text-danger me-1"></i>Fault</span>
                        </div>
                        <div id="chart6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- highcharts js -->
    <script src="{{ asset('assets/plugins/highcharts/js/highcharts.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/highcharts-more.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/variable-pie.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/solid-gauge.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/highcharts-3d.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/cylinder.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/funnel3d.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/exporting.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/export-data.js') }}"></script>
    <script src="{{ asset('assets/plugins/highcharts/js/accessibility.js') }}"></script>
	<script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/index4.js') }}"></script>
@endpush
