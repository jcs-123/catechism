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
    <form id="formAuthentication" class="mb-1" action="{{url('/attendance-management')}}" method="POST">
        @csrf
        <div class="card">
            <div class="row gy-1">
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
                <div class="col-md-12 col-lg-4" id="forane_div">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="forane" class="form-label">Forane Name</label>
                            <select id="forane" name="forane" class="form-select form-select-lg">
                                <option value="">Select forane</option>
                                @foreach($foranes as $foran)
                                    <option value="{{ $foran->forane_code }}" {{$foran->forane_code == $forane ? 'selected' : ''}}>{{ $foran->forane_name}}</option>
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
                                                            <!-- <input type="hidden" name="units" value="{{$units}}"{{$units != '' ? 'selected' : ''}}> -->

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
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <div class="mt-2 mb-3">
                            <label for="class_date">Catechism Class Date</label>
                            <input type="date" class="form-control" id="class_date" name="class_date"
                                value="<?php echo date('Y-m-d'); ?>" disabled>
                                <input type="hidden" name="class_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>


            </div>
            @if(isset($staffs) && $staffs != '')
                <!-- Working days Table starts here -->
                <div class="card">
                    <!-- <h5 class="card-header"></h5> -->
                    <div class="table-responsive text-nowrap ml-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Slno</th>
                                    <th>Student Name &Attendance<input type="checkbox" id="selectAll"></th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach($staffs as $key => $staf)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td><input type="hidden" name="staf[{{$staf->staff_code}}][staff_code]" class="form-control"
                                                value="{{$staf->staff_code}}">
                                            <input type="checkbox" name="staff_present[{{$staf->staff_code}}]" value="{{$staf->staff_code}}"
                                                class="individualCheckbox">{{$staf->staff_name}}
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include if not already present -->

    <script>
        $(document).ready(function () {
            $('#selectAll').on('change', function () {
                $('.individualCheckbox').prop('checked', $(this).is(':checked'));
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