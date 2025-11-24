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
    <form id="formAuthentication" class="mb-3" action="{{url('/transfer-certificate')}}" method="POST">
        @csrf
        <div class="card">
            <div class="row gy-6">
                <!-- Congratulations card -->
                <div class="col-md-12 col-lg-4" id="forane_div">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="forane" class="form-label">Forane Name</label>
                            <select id="forane" name="forane" class="form-select form-select-lg">
                                <option value="" disabled selected>Select Forane</option>
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
                <div class="col-md-12 col-lg-4" id="unit_div">
                    <div class="card-body">

                        <div class="mt-2 mb-3">

                            <label for="student">Student Name</label>
                            <select id="student" name="student" class="form-control">
                                <option value="">Select Unit</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-2">
                    <div class="card-body">
                        <button class="btn btn-primary d-grid w-70" type="submit">Load</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Working days Table starts here -->
    @if(isset($student_details) && !empty($student_details))

        <div class="card">
            <div class="row gy-1">

                <h5 class="mt-4 mb-3">Personal Details</h5>


                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter"
                                value="{{ $student_details['student_name'] ?? '' }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="dob">Date Of Birth</label>

                            <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter"
                                value="{{ $student_details['date_of_birth'] ?? '' }}" disabled>

                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-4 ">
                    <div class=" card-body">
                        <div class="mt-2 mb-3">
                            <label for="perm_addr">
                                Permenant Address
                            </label>
                            <input class="form-control" type="text" id="perm_addr" name="perm_addr" placeholder="Enter"
                                value="{{ $student_details['permanent_address'] ?? '' }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-4 ">
                    <div class=" card-body">
                        <div class="mt-2 mb-3">
                            <label for="pres_addr">
                                Present Address
                            </label>
                            <input class="form-control" type="text" id="pres_addr" name="pres_addr" placeholder="Enter"
                                value="{{ $student_details['present_address'] ?? '' }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="adm_no">Admission No</label>
                            <input type="text" class="form-control" id="adm_no" name="adm_no" placeholder="Enter"
                                value="{{ $student_details['adm_no'] ?? '' }}" disabled>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="date_join">Date Of Join</label>

                            <input type="date" class="form-control" id="date_join" name="date_join" placeholder="Enter"
                                disabled>

                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="email">Email</label>

                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter"
                                value="{{ $student_details['emailid'] ?? '' }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="father_name">Name Of Father</label>
                            <input type="text" class="form-control" id="father_name" name="father_name" placeholder="Enter"
                                value="{{ $student_details['father_name'] ?? '' }}" disabled>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="card-body">
                        <!-- <small class="text-light fw-medium">Academic Year</small> -->
                        <div class="mt-2 mb-3">
                            <label for="mother_name">Name Of Mother</label>
                            <input type="text" class="form-control" id="mother_name" name="mother_name" placeholder="Enter"
                                value="{{ $student_details['mother_name'] ?? '' }}" disabled>
                        </div>

                    </div>
                </div>

                <div class="col-md p-4">
                    <small class="text-light fw-medium d-block">Gender</small>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ (isset($student_details['gender']) && $student_details['gender'] == 'Male') ? 'checked' : '' }}>
                        <label class="form-check-label" for="inlineRadio1">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ (isset($student_details['gender']) && $student_details['gender'] == 'Female') ? 'checked' : '' }}>
                        <label class="form-check-label" for="inlineRadio2">Female</label>
                    </div>
                </div>






                <div class="card">
                    <div class="row gy-1">

                        <h5 class="mt-4 mb-3">Transfer Details</h5>


                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <div class="mt-2 mb-3">
                                    <label for="stud_class" class="form-label">Class Now Studying<span
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
                                <div class="mt-2 mb-3">
                                    <label for="to_class" class="form-label">Class In Which To Be Admitted<span
                                            style="color: red;">*</span></label>
                                    <select class="form-select form-select-lg" id="to_class" name="to_class" autofocus>
                                        <option value="" disabled selected>Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->class }}">{{ $class->class }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body p-3">
                                <div class="mt-0 mb-3">
                                    <label for="char_conduct">Charector&Conduct</label>
                                    <select class="form-control" id="char_conduct" name="char_conduct" autofocus>
                                        <option value="excellent">Excellent</option>
                                        <option value="v_good">Very Good</option>
                                        <option value="good">Good</option>
                                        <option value="satisfied">Satisfied</option>
                                        <option value="bad">Bad</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md p-4">
                            <small class="text-light fw-medium d-block">Catechism Diocese/Unit to which the Student seeks
                                admission</small>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="diocese" id="tsr" value="tsr">
                                <label class="form-check-label" for="inlineRadio1">Thrissur</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="diocese" id="other" value="other">
                                <label class="form-check-label" for="inlineRadio2">Other</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="units" class="form-label">Unit </label>
                                    <select id="units" name="units" class="form-select form-select-lg">
                                        <option value="" disabled selected>Select a unit</option>
                                        @foreach($catechismUnits as $unit)
                                            <option value="{{ $unit->unit_code }}">{{ $unit->unit_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 col-lg-6">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="transfer_reason">Reason For Transfer</label>
                                    <input type="text" class="form-control" id="transfer_reason" name="transfer_reason"
                                        placeholder="Enter" autofocus>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="trans_date">Date Of Transfer</label>

                                    <input type="date" class="form-control" id="trans_date" name="trans_date"
                                        placeholder="Enter" autofocus>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="responsible_person">Name of Responsible Person</label>
                                    <input type="text" class="form-control" id="responsible_person" name="responsible_person"
                                        placeholder="Enter" autofocus>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="student_rela">Relationship with Student</label>
                                    <input type="text" class="form-control" id="student_rela" name="student_rela"
                                        placeholder="Enter" autofocus>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 col-lg-2">
                            <div class="card-body">
                                <!-- <div class="mt-6 mb-3"> -->
                                </br></br>
                                <button class="btn btn-primary d-grid w-70" type="submit">Add</button>
                            </div>
                        </div>

                    </div>
                </div>







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
                    $.ajax({
                        url: 'get-students/' + forane,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#student').empty();
                            $('#student').append('<option value="">Select unit</option>');
                            $.each(data, function (key, value) {
                                $('#student').append('<option value="' + value.student_code +
                                    '">' +
                                    value.student_name + '</option>');
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