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
    <h3>Contact Class Attendance List</h3>
    <form id="formAuthentication" class="mb-3" action="{{url('/contact-class-attendance-list')}}" method="POST">
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
                                @foreach($academicYears as $year)
                                    <option value="{{ $year['academic_year'] }}">{{ $year['academic_year'] }}</option>
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
                        <button class="btn btn-primary d-grid w-70" type="submit">Load</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if(isset($all_students) && !empty($all_students))

        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Student Name</th>

                            @foreach($dates as $k => $date)
                                <th>
                                    {{$date}}
                                </th>
                            @endforeach
                            <th>Total Attendane</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($all_students as $student)
                            @php $total_present = 0; @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>

                                <td class="fw-bold">{{ $student }}</td>
                                @foreach($cont_students_att as $record)
                                    @php
                                        $students_present = explode(',', $record['attendance']);
                                        $attended = in_array($student, $students_present);
                                    @endphp
                                    <td>
                                        @if($attended)
                                            <span class="badge bg-success">P</span>
                                            @php $total_present++; @endphp
                                        @else
                                            <span class="badge bg-danger">AB</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td><strong>{{ $total_present }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

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