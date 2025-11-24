@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
<form id="formAuthentication" class="mb-3" action="{{url('/unit-summary-report')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-4">
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="units" class="form-label">Catechism Units</label>
                        <select id="units" name="units" class="form-select form-select-lg">
                            @foreach($units as $unit)
                                <option value="{{ $unit->unit_code }}">{{ $unit->unit_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    </br></br>
                    <button class="btn btn-primary d-grid w-70" type="submit">Search</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Table starts here -->
@if (!empty($unit_sum_report) && $unit_sum_report != '')
    <div class="card">
        <h5 class="card-header">Unit Summary Report</h5>

        <div class="card-body">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">PLACE OF UNIT:</label>
                <div class="col-sm-10">{{$unit_sum_report[0]['place']}}
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-company">FULL ADDRESS OF THE UNIT</label>
                <div class="col-sm-10">
                    {{$unit_sum_report[0]['unit_address']}}</br></br>
                    {{$unit_sum_report[0]['place']}}</br></br>
                    {{$unit_sum_report[0]['post']}}</br></br>
                    {{$unit_sum_report[0]['district']}}</br></br>
                    {{$unit_sum_report[0]['state']}}
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-email">PINCODE</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        {{$unit_sum_report[0]['pincode']}}
                    </div>
                    <div class="form-text"> You can use letters, numbers &amp; periods </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-phone">PHONE NO</label>
                <div class="col-sm-10">
                    {{$unit_sum_report[0]['phone']}}
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-message">FORANE</label>
                <div class="col-sm-10">
                    {{$unit_sum_report[0]['forane_name']}}
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-message">NAME OF PRINCIPAL WITH FULL RESIDENTIAL
                    ADDRESS</label>
                <div class="col-sm-10">
                    {{$unit_sum_report[0]['staff_name']}}</br></br>
                    {{$unit_sum_report[0]['permanent_address']}}
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-message">TIME OF CATESHISM CLASSES</label>
                <div class="col-sm-10">
                    {{$unit_sum_report[0]['cat_time']}}

                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-message">TIME OF HOLYMASS FOR STUDENTS</label>
                <div class="col-sm-10">
                    {{$unit_sum_report[0]['mass_time']}}

                </div>
            </div>


            <div class="card">
                <h5 class="card-header">NO OF STAFFS</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Male Staffs</th>
                                    <th>Female Staffs</th>
                                    <th>Total Staffs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($unit_staf_report[0] as $data)
                                        <td>{{$data}}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header">Student Strength (Actual)</h5>
            <div class="table-responsive text-nowrap">
                <table class="table" id="student_report">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Total Students</th>
                            <th>Division Count</th>
                        </tr>
                    </thead>
                    @foreach($unit_stu_report as $key => $data) 
                        <tbody class="table-border-bottom-0">
                            <tr>
                                @foreach($unit_stu_report[$key] as $data)
                                    <td>{{$data}}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>


    </div>
    <!--/ Working days Table ends here-->
@endif

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>



@endsection