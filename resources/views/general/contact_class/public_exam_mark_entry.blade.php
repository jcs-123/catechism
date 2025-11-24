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

@section('content')
    <h3>Public Exam Mark Entry</h3>
    <form id="formAuthentication" class="mb-3" action="{{url('/public-exam-mark-entry')}}" method="POST">
        @csrf
        <div class="card">
            <div class="row gy-4">
                <!-- Congratulations card -->
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="academic_year" class="form-label">Academic Year</label>
                            <select id="academic_year" name="academic_year" class="form-select form-select-lg">
                                @foreach($academicYears as $id => $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
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
                                    <option value="{{ $clas->class }}">
                                        {{ $clas->class }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                </br>


                <div class="col-md-12 col-lg-2">
                    <div class="card-body">
                        </br>
                        <button class="btn btn-primary d-grid w-70" type="submit">Load</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--<div class="card">
                                                                    <div class="table-responsive text-nowrap">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Slno</th>
                                                                                    <th>Academic Year</th>
                                                                                    <th>Class</th>
                                                                                    <th>Contact Class Dates</th>
                                                                                    <th>Attd. Entry Last Date</th>
                                                                                    <th>Pass Percentage</th>
                                                                                </tr>
                                                                            </thead>

                                                                        </table>
                                                                    </div>
                                                                </div> -->
    </div>


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

            flatpickr("#cc_days", {
                mode: "multiple",
                dateFormat: "Y-m-d"
            });
        });

    </script>
@endsection