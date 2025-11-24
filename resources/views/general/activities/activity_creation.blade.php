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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
    <form id="formAuthentication" class="mb-3" action="{{url('/activity-creation')}}" method="POST">
        @csrf
        <div class="card">
            <div class="row gy-6">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Congratulations card -->
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="activity_no">Activity No</label>

                            <input type="text" class="form-control" id="activity_no" name="activity_no" placeholder="Enter"
                                autofocus>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="certificate_date">Activity Date to be displayed in the certificate</label>

                            <input type="date" class="form-control" id="certificate_date" name="certificate_date"
                                placeholder="Enter" autofocus>

                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="activity_name">Activity Name<span style="color: red;">*</span></label>

                            <input type="text" class="form-control" id="activity_name" name="activity_name"
                                placeholder="Enter" autofocus>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="certificate_name">Activity Name to be displayed in the certificate</label>

                            <input type="text" class="form-control" id="certificate_name" name="certificate_name"
                                placeholder="Enter" autofocus>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="activity_topic">Activity/Course Topic</label>

                            <input type="text" class="form-control" id="activity_topic" name="activity_topic"
                                placeholder="Enter" autofocus>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-0 mb-3">
                            <label for="activity_for" class="form-label">Activity For<span
                                    style="color: red;">*</span></label>
                            <select id="activity_for" name="activity_for" class="form-select form-select-lg">
                                <option value="">{{ "Please Select"}}</option>
                                @foreach($activities_for as $act_for)
                                    <option value="{{ $act_for->activity_for }}">{{ $act_for->activity_for}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-0 mb-3">
                            <label for="activity_type" class="form-label">Activity type<span
                                    style="color: red;">*</span></label>
                            <select id="activity_type" name="activity_type" class="form-select form-select-lg">
                                <option value="">{{ "Please Select"}}</option>
                                @foreach($activities_type as $act_type)
                                    <option value="{{ $act_type->activity_type }}">{{ $act_type->activity_type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="resident_seat">Resident Seat<span style="color: red;">*</span></label>

                            <input type="number" class="form-control" id="resident_seat" name="resident_seat"
                                placeholder="Enter" autofocus>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="academic_year" class="form-label">Education Year<span
                                    style="color: red;">*</span></label>
                            <select id="academic_year" name="academic_year" class="form-select form-select-lg">
                                @foreach($academicYears as $year)
                                    <option value="{{ $year['academic_year'] }}">{{ $year['academic_year'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-3">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="venue">Venue<span style="color: red;">*</span></label>

                            <input type="text" class="form-control" id="venue" name="venue" placeholder="Enter" autofocus>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-3">
                    <div class="card-body">
                        <div class="mt-2 mb-3">
                            <label for="activity_dates">Activity Dates<span style="color: red;">*</span></label>
                            <input type="date" class="form-control" id="activity_dates" name="activity_dates"
                                placeholder="Enter" autofocus>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-3">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="activity_duration">Activity/Course Duration<span
                                    style="color: red;">*</span></label>

                            <input type="number" class="form-control" id="activity_duration" name="activity_duration"
                                placeholder="Enter" autofocus>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-3">
                    <div class="card-body">
                        <div class="mt-2 mb-3">
                            <label for="hr_day">(Hrs/Days)</label>
                            <select class="form-control" id="hr_day" name="hr_day" autofocus>
                                <option value="hrs">Hrs</option>
                                <option value="days">Days</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-3">
                    <div class="card-body">
                        <div class="mt-2 mb-3">
                            <label for="bishop_sign">Bishop Signature Required<span style="color: red;">*</span></label>
                            <select class="form-control" id="bishop_sign" name="bishop_sign" autofocus>
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="activity_summary">Activity Summary</label>

                            <input type="text" class="form-control" id="activity_summary" name="activity_summary"
                                placeholder="Enter" autofocus>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-2">
                    <div class="card-body">
                        <div class="mt-2 mb-3">
                            <button class="btn btn-primary d-grid w-70" type="submit">Register</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>


    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        flatpickr("#activity_dates", {
            mode: "multiple",
            dateFormat: "Y-m-d"
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
    <script>
        $(document).ready(function () {
            $('#stud_class').change(function () {
                var classes = $(this).val();
                if (classes) {
                    $.ajax({
                        url: 'get-divisions/' + classes,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#class_division').empty();
                            $('#class_division').append('<option value="">Select unit</option>');
                            $.each(data, function (key, value) {
                                $('#class_division').append('<option value="' + value.division +
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
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
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
@endsection