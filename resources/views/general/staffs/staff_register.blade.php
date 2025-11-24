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
    <form id="formAuthentication" class="mb-1" action="{{url('/staff-register')}}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row gy-1">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <h4>Staff Register</h4>
                <div class="card">
                    <div class="row gy-1">

                        <h5 class="mt-4 mb-3">Family Details</h5>


                        <div class="col-md-12 col-lg-4" id="forane_div">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="forane" class="form-label">Forane Name</label>
                                    <select id="forane" name="forane" class="form-select form-select-lg">
                                        <option value="">Select Forane</option>
                                        @foreach($foranes as $forane)
                                            <option value="{{ $forane->forane_code }}">{{ $forane->forane_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4" id="unit_div">
                            <div class="card-body">
                                <div class="mt-0 mb-3">
                                    <label for="parishes">parish</label>
                                    <select id="parishes" name="parishes" class="form-control">
                                        <option value="">Select parish</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 ">
                            <div class=" card-body">
                                <div class="mt-2 mb-3">
                                    <label for="house_name">
                                        House Name
                                    </label>
                                    <input class="form-control" type="text" id="house_name" name="house_name"
                                        placeholder="Enter" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 ">
                            <div class=" card-body">
                                <div class="mt-2 mb-3">
                                    <label for="perm_addr">
                                        Permenant Address
                                    </label>
                                    <input class="form-control" type="text" id="perm_addr" name="perm_addr"
                                        placeholder="Enter" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 ">
                            <div class=" card-body">
                                <div class="mt-2 mb-3">
                                    <label for="pres_addr">
                                        Present Address
                                    </label>
                                    <input class="form-control" type="text" id="pres_addr" name="pres_addr"
                                        placeholder="Enter" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="post">post</label>
                                    <input type="text" class="form-control" id="post" name="post" placeholder="Enter"
                                        autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="place">Place</label>

                                    <input type="text" class="form-control" id="place" name="place" placeholder="Enter"
                                        autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="pin">Pincode</label>
                                    <input type="text" class="form-control" id="pin" name="pin" placeholder="Enter"
                                        autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="district" class="form-label">Districts</label>
                                    <select id="district" name="district" class="form-select form-select-lg">
                                        <option value="">Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->district_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        placeholder="Enter" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="mobile_no">Mobile No</label>
                                    <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                                        placeholder="Enter" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="email">Email</label>

                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter"
                                        autofocus>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4">
                            <div class="card-body p-2">
                                <div class="mt-0 mb-3">
                                    <label for="denom">Denomination</label>
                                    <select class="form-control" id="denom" name="denom" autofocus>
                                        <option value="" disabled selected>Select</option>
                                        <option value="CL">Catholic</option>
                                        <option value="NL">Non-Catholic</option>
                                        <option value="NC">Non-Cristian</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class=" col-md-12 col-lg-4">
                            <div class="card-body">
                                <div class="mt-2 mb-2">
                                    <label for="ident_mark">Identification Marks</label>
                                    <input type="text" class="form-control" id="ident_mark" name="ident_mark"
                                        placeholder="Enter" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md p-4">
                            <small class="text-light fw-medium d-block">Diocese</small>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="diocese" id="tsr" value="tsr">
                                <label class="form-check-label" for="inlineRadio1">Thrissur</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="diocese" id="other" value="other">
                                <label class="form-check-label" for="inlineRadio2">Other</label>
                            </div>
                        </div>





                    </div>
                </div>
                <div class="card">
                    <div class="row gy-1">

                        <h5 class="mt-4 mb-23">Staff Details</h5>
                        <div class="col-md-12 col-lg-1 pr-0" id="name_title">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3 pr-0">
                                    <label for="name_title" class="form-label">Title</label>
                                    <select id="name_title" name="name_title" class="form-select form-select-lg">
                                        <option value="">{{ "Select"}}</option>
                                        @foreach($nameTitles as $names)
                                            <option value="{{ $names->id }}">{{ $names->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-3 pl-0">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3 pl-0">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name"
                                        placeholder="Enter" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 pl-0">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="father_name">Name Of Father</label>
                                    <input type="text" class="form-control" id="father_name" name="father_name"
                                        placeholder="Enter" autofocus>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="mother_name">Name Of Mother</label>
                                    <input type="text" class="form-control" id="mother_name" name="mother_name"
                                        placeholder="Enter" autofocus>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="dob">Date Of Birth</label>

                                    <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter"
                                        autofocus>

                                </div>

                            </div>
                        </div>
                        <div class=" col-md-12 col-lg-4">
                            <div class="card-body">
                                <div class="mt-2 mb-4">
                                    <label for="age">Age</label>
                                    <input type="number" class="form-control" id="age" name="age" placeholder="Enter"
                                        autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md p-4">
                            <small class="text-light fw-medium d-block">Gender</small>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                                <label class="form-check-label" for="inlineRadio1">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                <label class="form-check-label" for="inlineRadio2">Female</label>
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
                        <div class="col-md-12 col-lg-4 pl-0">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="congregation">Congregation</label>
                                    <input type="text" class="form-control" id="congregation" name="congregation"
                                        placeholder="Enter" autofocus>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="units" class="form-label">Catechism Unit Name</label>
                                    <select id="units" name="units" class="form-select form-select-lg">
                                        @foreach($catechismUnits as $unit)
                                            <option value="{{ $unit->unit_code }}">{{ $unit->unit_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="family_unit" class="form-label">Family Unit Name</label>
                                    <select id="family_unit" name="family_unit" class="form-select form-select-lg">
                                        <option value="">Select</option>
                                        @foreach($familyUnits as $familyUnit)
                                            <option value="{{ $familyUnit->Unit_code }}">{{ $familyUnit->family_unit_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4" id="designation_div">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-0 mb-3">
                                    <label for="designation" class="form-label">Catechism Designation</label>
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
                                <div class="mt-2 mb-3">
                                    <label for="date_of_join">Date Of Join</label>

                                    <input type="date" class="form-control" id="date_of_join" name="date_of_join"
                                        placeholder="Enter" autofocus>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="logo">Upload staff Photo(max width x height : 150 x 200)</label>
                                    <input type="file" name="logo" id="logo" accept="application/pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="row gy-1">

                        <h5 class="mt-4 mb-3">Qualification/Job Details</h5>

                        <div class="col-md-12 col-lg-4">
                            <div class="card-body p-3">
                                <div class="mt-0 mb-3">
                                    <label for="secu_qualification">Secular Qualification</label>
                                    <select class="form-control" id="secu_qualification" name="secu_qualification"
                                        autofocus>
                                        <option value="">{{ "Please Select"}}</option>
                                        @foreach($secularQualification as $sec)
                                            <option value="{{ $sec->id }}">
                                                {{ $sec->qualification }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body p-3">
                                <div class="mt-0 mb-3">
                                    <label for="relig_qualification">Religious Qualification</label>
                                    <select class="form-control" id="relig_qualification" name="relig_qualification"
                                        autofocus>
                                        <option value="">{{ "Please Select"}}</option>
                                        @foreach($religiousQualification as $reli)
                                            <option value="{{ $reli->id }}">
                                                {{ $reli->qualification }}
                                            </option>
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
                            <div class="card-body p-3">
                                <div class="mt-0 mb-3">
                                    <label for="ctc_batch">CTC batch</label>
                                    <select class="form-control" id="ctc_batch" name="ctc_batch" autofocus>
                                        <option value="" disabled selected>Select batch</option>
                                        <option value="">{{ "Please Select"}}</option>
                                        @foreach($CTCbatch as $batch)
                                            <option value="{{ $batch->id }}">{{ $batch->id }}</option>
                                        @endforeach
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

                        <div class="col-md-12 col-lg-6">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="job_details">Job Details</label>
                                    <input type="text" class="form-control" id="job_details" name="job_details"
                                        placeholder="Enter" autofocus>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="experience">Professional Experience</label>
                                    <input type="text" class="form-control" id="experience" name="experience"
                                        placeholder="Enter" autofocus>
                                </div>

                            </div>
                        </div>


                        <div class="col-md-12 col-lg-2">
                            <div class="card-body">
                                <!-- <div class="mt-6 mb-3"> -->
                                </br></br>
                                <button class="btn btn-primary d-grid w-70" type="submit">Register</button>
                            </div>
                        </div>
                    </div>
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
                //alert(forane);
                if (forane) {
                    $.ajax({
                        url: 'get-parishes/' + forane,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#parishes').empty();
                            $('#parishes').append('<option value="">Select Parish</option>');
                            $.each(data, function (key, value) {
                                $('#parishes').append('<option value="' + value.parish_code +
                                    '">' +
                                    value.name + '</option>');
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