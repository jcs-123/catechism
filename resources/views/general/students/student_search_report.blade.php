@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form id="formAuthentication" class="mb-3" action="{{url('/student-search-report')}}" method="POST">
    @csrf
    <div class="card p-3">
        <div class="row gy-4">
            <div class="col-md-12 col-lg-4">
                <div class="card-body p-2">
                    <div class="mt-2 mb-3">
                        <label for="forane">Forane Name<span style="color: red;">*</span></label>
                        <select class="form-control" id="forane" name="forane" autofocus>
                            <option value="" disabled selected>Select Forane</option>
                            @foreach($foranes as $forane)
                                <option value="{{ $forane->forane_code }}">{{ $forane->forane_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4" id="unit_div">
                <div class="card-body">

                    <div class="mt-2 mb-3">

                        <label for="units">Unit</label>
                        <select id="units" name="units" class="form-control">
                            <option value="">Select Unit</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body p-2">
                    <div class="mt-2 mb-3">
                        <label for="class">Class<span style="color: red;">*</span></label>
                        <select class="form-control" id="class" name="class" autofocus>
                            <option value="" disabled selected>Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->class }}">{{ $class->class }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-md-12 col-lg-4">
                <div class="card-body p-2">
                    <div class="mt-2 mb-3">
                        <label for="division">Division<span style="color: red;">*</span></label>
                        <select class="form-control" id="division" name="division" autofocus>
                            <option value="" disabled selected>Select Division</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card-body p-2">
                    <div class="mt-2 mb-3">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" autofocus>
                            <option value="" disabled selected>Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card-body p-2">
                    <div class="mt-2 mb-3">
                        <label for="admn_no">Admission Number</label>
                        <input type="text" name="admn_no" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-md-12 col-lg-4">
                <div class="card-body p-2">
                    <div class="mt-2 mb-3">
                        <label for="student_code">Student Code</label>
                        <input type="text" name="student_code" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body p-2">
                    <div class="mt-2 mb-3">
                        <label for="admn_no">Student Name</label>
                        <input type="text" name="admn_no" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-2">
            <div class="card-body p-3 text-center">
                <!-- <button type="button" class="btn btn-primary mt-4" onclick="student_list()">Find Student</button> -->
                <button class="btn btn-primary d-grid w-70" type="submit">Search</button>
            </div>
        </div>

    </div>
</form>

<!-- Working days Table starts here -->
<div class="card">
    <h5 class="card-header">Attendance List</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Sl.No</th>

                    <th>Student Name</th>

                    <th>Attendance</th>
                </tr>
            </thead>

        </table>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#class').change(function () {
            var classes = $(this).val();
            if (classes) {
                $.ajax({
                    url: 'get-divisions/' + classes,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#division').empty();
                        $('#division').append('<option value="">Select unit</option>');
                        $.each(data, function (key, value) {
                            $('#division').append('<option value="' + value.division +
                                '">' +
                                value.division + '</option>');
                        });
                    }
                });
            } else {
                $('#classes').empty();
                $('#classes').append('<option value="">Select Class</option>');
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#forane').change(function () {
            var forane = $(this).val();
            //alert(academicYear);
            if (forane) {
                $.ajax({
                    url: 'get-units/' + forane,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#units').empty();
                        $('#units').append('<option value="">Select unit</option>');
                        $.each(data, function (key, value) {
                            $('#units').append('<option value="' + value.unit_code +
                                '">' +
                                value.unit_name + '</option>');
                        });
                    }
                });
            } else {
                $('#classes').empty();
                $('#classes').append('<option value="">Select Class</option>');
            }
        });
    });
</script>


@endsection