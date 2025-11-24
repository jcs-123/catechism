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
                <div class="col-md-12 col-lg-4" id="forane_div">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="forane" class="form-label">Forane Name<span style="color: red;">*</span></label>
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

                            <label for="units">Catechism Unit<span style="color: red;">*</span></label>
                            <select id="units" name="units" class="form-control">
                                <option value="">Select Unit</option>
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

                <div class="col-md-12 col-lg-4 ">
                    <div class=" card-body p-3">
                        <div class="mt-0 mb-3">
                            <label for="staf_name">
                                Staff Name
                            </label>
                            <input class="form-control" type="text" value="" id="staf_name" name="staf_name">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-2 ">
                    <div class=" mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="staff_code" name="staff_code">
                            <label class="form-check-label" for="staff_code">
                                Staff Code
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-2 ">
                    <div class=" mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="forane_code" name="forane_code">
                            <label class="form-check-label" for="forane_code">
                                Forane Code
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-2 ">
                    <div class=" mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="parish_code" name="parish_code">
                            <label class="form-check-label" for="parish_code">
                                Staff Parish Code
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-2 ">
                    <div class=" mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="BaptDate" name="BaptDate">
                            <label class="form-check-label" for="BaptDate">
                                Baptismal Date
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-2 pl-6">
                    <div class="mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="catechism_unit_code"
                                name="catechism_unit_code">
                            <label class="form-check-label" for="catechism_unit_code">
                                Catechism Unit
                            </label>
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
    @if(isset($staffs_report) && !empty($staffs_report))

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
                <h5 class="text-center text-primary ">STAFF LIST OF UNIT {{$unit_name['unit_name']}} -
                    {{$forane_name['forane_name']}}
                </h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            @foreach($staffs_report[0] as $key => $data)
                                <th>{{$key}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($staffs_report as $key => $data)
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