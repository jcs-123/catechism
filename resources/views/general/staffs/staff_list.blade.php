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
    <form id="formAuthentication" class="mb-3" action="{{url('/staff-list-report')}}" method="POST">
        @csrf
        <div class="card">
            <div class="row gy-6">
                <!-- Congratulations card -->
                <div class="col-md-12 col-lg-4" id="forane_div">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-0 mb-3">
                            <label for="forane" class="form-label">Forane Name</label>
                            <select id="forane" name="forane" class="form-select form-select-lg">
                                @foreach($foranes as $forane)
                                    <option value="{{ $forane->forane_code }}" {{$forane->forane_code == $forane ? 'selected' : ''}}>{{ $forane->forane_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-4" id="unit_div">
                    <div class="card-body">

                        <div class="mt-0 mb-3">

                            <label for="units">Catechism Unit</label>
                            <select id="units" name="units" class="form-control">
                                <option value="">Select Unit</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4" id="designation_div">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-0 mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <select id="designation" name="designation" class="form-select form-select-lg">
                                <option value="">Select designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->unit_code }}">
                                        {{ $designation->address}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-0 mb-2">
                            <label for="religi_lai" class="form-label">Religious/Laity</label>
                            <select id="religi_lai" name="religi_lai" class="form-select form-select-lg">
                                <option value="">{{ "Please Select"}}</option>
                                <option value="Religious">{{ "Religious"}}</option>
                                <option value="Laity">{{ "Laity"}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4" id="forane_div">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-0 mb-3">
                            <label for="job_category" class="form-label">Job Category</label>
                            <select id="job_category" name="job_category" class="form-select form-select-lg">
                                @foreach($JobCategory as $cat)
                                    <option value="">{{ "Please Select"}}</option>
                                    <option value="{{ $cat->cat_id }}">{{ $cat->cat_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4" id="job_title">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-0 mb-3">
                            <label for="job_title" class="form-label">Job Title</label>
                            <select id="job_title" name="job_title" class="form-select form-select-lg">
                                @foreach($JobTitles as $jobs)
                                    <option value="">{{ "Please Select"}}</option>
                                    <option value="{{ $jobs->job_id }}">{{ $jobs->job_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <div class="mt-0 mb-3">
                            <label for="class_division" class="form-label">Division<span
                                    style="color: red;">*</span></label>
                            <select class="form-select form-select-lg" id="class_division" name="class_division" autofocus>
                                <option value="" disabled selected>Select Division</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-4">
                    <div class="card-body p-3">
                        <div class="mt-0 mb-3">
                            <label for="health_statuses">Health Status</label>
                            <select class="form-control" id="health_statuses" name="health_statuses" autofocus>
                                <option value="" disabled selected>Select Health Status</option>
                                @foreach($healthStatus as $health)
                                    <option value="">{{ "Please Select"}}</option>
                                    <option value="{{ $health->id }}" {{ $health->name == $selectedhealthStatus ? 'selected' : '' }}>{{ $health->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body p-3">
                        <div class="mt-0 mb-3">
                            <label for="ctc_year">CTC Year</label>
                            <select class="form-control" id="ctc_year" name="ctc_year" autofocus>
                                <option value="" disabled selected>Select year</option>
                                <option value="">{{ "Please Select"}}</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body p-2">
                        <div class="mt-2 mb-3">
                            <label for="genders">Gender</label>
                            <select class="form-control" id="genders" name="genders" autofocus>
                                <option value="" disabled selected>Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body p-2">
                        <div class="mt-0 mb-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="stat" name="stat" autofocus>
                                <option value="" disabled selected>Select status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                <option value="2">Transfered</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body p-3">
                        <div class="mt-0 mb-3">
                            <label for="experience_from">Experience From</label>
                            <select class="form-control" id="experience_from" name="experience_from" autofocus>
                                <option value="" disabled selected>Select year</option>
                                <option value="">{{ "Please Select"}}</option>
                                @foreach($Experience_range as $exp)
                                    <option value="{{ $exp }}">{{ $exp }} Years</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body p-3">
                        <div class="mt-0 mb-3">
                            <label for="experience_to">Experience To</label>
                            <select class="form-control" id="experience_to" name="experience_to" autofocus>
                                <option value="" disabled selected>Select year</option>
                                <option value="">{{ "Please Select"}}</option>
                                @foreach($Experience_range as $exp)
                                    <option value="{{ $exp }}">{{ $exp }} Years</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <div class="mt-0 mb-3">
                            <label for="stud_class" class="form-label">Current Class<span
                                    style="color: red;">*</span></label>
                            <select class="form-select form-select-lg" id="stud_class" name="stud_class" autofocus>
                                <option value="" disabled selected>Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->class }}">{{ $class->class }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="dob_from">DOB from</label>

                            <input type="date" class="form-control" id="dob_from" name="dob_from" placeholder="Enter"
                                autofocus>

                        </div>

                    </div>
                </div></br>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="dob_to">DOB To</label>

                            <input type="date" class="form-control" id="dob_to" name="dob_to" placeholder="Enter" autofocus>

                        </div>

                    </div>
                </div>


                <div class="col-md-12 col-lg-2">
                    <div class="card-body">
                        <button class="btn btn-primary d-grid w-70" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Working days Table starts here -->
    @if(isset($students_report) && !empty($students_report))

        <div class="card">
            <div class="app-brand justify-content-center mt-5">
                <a href="{{url('/')}}" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo"><img src="{{asset('assets/img/logo/logo.png')}}" alt="auth-tree"
                            class="authentication-image-object-left d-none d-lg-block"
                            style="bottom: 355px;left: 160px;"></span>
                    <span class="app-brand-text demo text-heading fw-semibold">{{config('variables.templateName_')}}</span>
                </a>
            </div>
            <div class="app-brand justify-content-center mt-2">
                <h5 class="text-center text-primary ">STUDENT LIST OF {{$forane_name['forane_name']}}
                    {{$unit_name['unit_name']}} UNIT {{$academicYear['academic_year']}}
                </h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            @foreach($students_report[0] as $key => $data)
                                <th>{{$key}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($students_report as $key => $data)
                            <tr>

                                @foreach($data as $k => $row)
                                    <td>{{$row}}</td>
                                @endforeach
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <!--/ Working days Table ends here-->

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

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