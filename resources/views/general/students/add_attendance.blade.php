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
@section('content')
<form id="formAuthentication" class="mb-1" action="{{url('/add-attendance')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-1">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="academic_year" class="form-label">Academic Year</label>
                        <select id="academic_year" name="academic_year" class="form-select form-select-lg">
                            @foreach($academicYears as $year)
                                <option value="{{ $year['academic_year'] }}" {{$year['academic_year'] == $academic_yr ? 'selected' : ''}}>{{ $year['academic_year'] }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>
            <div class="col-md-12 col-lg-4" id="forane_div">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="forane" class="form-label">Forane Name</label>
                        <select id="forane" name="forane" class="form-select form-select-lg">
                            @foreach($foranes as $forane)
                                <option value="{{ $forane->forane_code }}" {{$forane->forane_code == $forane ? 'selected' : ''}}>{{ $forane->forane_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md p-4">
                <small class="text-light fw-medium d-block">Unit Type</small>
                <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="radio" name="unit_type" id="parish_unit" value="parish_unit">
                    <label class="form-check-label" for="parish_unit1">Parish Unit</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="unit_type" id="schoot_unit" value="school_unit">
                    <label class="form-check-label" for="schoot_unit1">School Unit</label>
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
            <div class="col-md-12 col-lg-4" id="school_div">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="school" class="form-label">School Name</label>
                        <select id="school" name="school" class="form-select form-select-lg">
                            @foreach($schools as $school)
                                <option value="">Select School</option>
                                <option value="{{ $school->unit_code }}" {{$school->unit_code == $units ? 'selected' : ''}}>
                                    {{ $school->address}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4" id="class_div">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="class" class="form-label">Class</label>
                        <select id="class" name="class" class="form-select form-select-lg">
                            @foreach($classes as $clas)
                                <option value="{{ $clas->class }}" {{$clas->class == $class ? 'selected' : ''}}>
                                    {{ $clas->class }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4" id="unit_div">
                <div class="card-body">

                    <div class="mt-2 mb-3">

                        <label for="division">Division</label>
                        <select id="division" name="division" class="form-control">
                            <option value="">Select Division</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($students) && $students != '')
            <!-- Working days Table starts here -->
            <div class="card">
                <!-- <h5 class="card-header"></h5> -->
                <div class="table-responsive text-nowrap ml-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Slno</th>
                                <th>Adm No</th>
                                <th>Student Name</th>
                                <th>Attendance till half yearly exam</th>
                                <th>Attendance after half yearly exam</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($students as $ind => $stud)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><input type="hidden" name="stud[{{$stud->adm_no}}][adm_no]" class="form-control"
                                            value="{{$stud->adm_no}}">{{$stud->adm_no}}</td>
                                    <td><input type="hidden" name="stud[{{$stud->adm_no}}][student_code]" class="form-control"
                                            value="{{$stud->student_code}}">{{$stud->student_name}}
                                    </td>
                                    <td>
                                        <input type="number" name="stud[{{$stud->adm_no}}][att_till_hlf_yr]"
                                            class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" name="stud[{{$stud->adm_no}}][att_before_hlf_yr]"
                                            class="form-control">
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <div class="col-md-12 col-lg-2">
            <div class="card-body">
                <!-- <div class="mt-6 mb-3"> -->
                </br></br>
                <button class="btn btn-primary d-grid w-70" type="submit">Add</button>
            </div>
        </div>
    </div>
</form>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

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

<script>
    $(document).ready(function () {
        $('#school_div').hide(); // Show the form
        $('#schoot_unit').on('click', function () {
            // alert("hi"); exit;
            $("#forane").prop("disabled", true);
            $("#parish").prop("disabled", true);
            $('#school_div').show(); // Show the form
            $('#unit_div').hide(); // Show the form

            // Show the form
        });
        $('#parish_unit').on('click', function () {
            // alert("hi"); exit;
            $("#forane").prop("disabled", false);
            $("#parish").prop("disabled", false);
            $('#school_div').hide(); // Show the form
            $('#unit_div').show(); // Show the form
            // Show the form
        });
        $('#cancelButton').on('click', function () {
            $('#formAttendanceReason').hide(); // Hide the form
        });
    });
</script>
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
@endsection