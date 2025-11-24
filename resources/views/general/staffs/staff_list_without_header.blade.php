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
                        <label for="age_from">Age From</label>
                        <select class="form-control" id="age_from" name="age_from" autofocus>
                            <option value="" disabled selected>Select age</option>
                            <option value="">{{ "Please Select"}}</option>
                            @foreach($age_range as $exp)
                                <option value="{{ $exp }}">{{ $exp }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body p-3">
                    <div class="mt-0 mb-3">
                        <label for="age_to">Age To</label>
                        <select class="form-control" id="age_to" name="age_to" autofocus>
                            <option value="" disabled selected>Select age</option>
                            <option value="">{{ "Please Select"}}</option>
                            @foreach($age_range as $exp)
                                <option value="{{ $exp }}">{{ $exp }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <div class="mt-0 mb-3">
                        <label for="curr_class" class="form-label">Current Class<span
                                style="color: red;">*</span></label>
                        <select class="form-select form-select-lg" id="curr_class" name="curr_class" autofocus>
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





            <div class="col-md-12 col-lg-4">
                <div class="card-body p-2">
                    <div class="mt-2 mb-3">
                        <label for="cont_class">CTC Attended</label>
                        <select class="form-control" id="cont_class" name="cont_class" autofocus>
                            <option value="" disabled selected>Select</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
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
            <div class="col-md-12 col-lg-4">
                <div class="card-body p-3">
                    <div class="mt-0 mb-3">
                        <label for="secu_qualification">Secular Qualification</label>
                        <select class="form-control" id="secu_qualification" name="secu_qualification" autofocus>
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
                        <select class="form-control" id="relig_qualification" name="relig_qualification" autofocus>
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
                        <input class="form-check-input" type="checkbox" value="1" id="occupation_id"
                            name="occupation_id">
                        <label class="form-check-label" for="occupation_id">
                            Occupation ID
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="gender" name="gender">
                        <label class="form-check-label" for="gender">
                            Gender
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="diocese" name="diocese">
                        <label class="form-check-label" for="diocese">
                            Diocese
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="house_name" name="house_name">
                        <label class="form-check-label" for="house_name">
                            House Name
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="perm_addr" name="perm_addr">
                        <label class="form-check-label" for="perm_addr">
                            Permenant Address
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="religios_laity"
                            name="religios_laity">
                        <label class="form-check-label" for="religios_laity">
                            Religious/Laity
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="date_of_birth"
                            name="date_of_birth">
                        <label class="form-check-label" for="date_of_birth">
                            Date Of Birth
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
                        <input class="form-check-input" type="checkbox" value="1" id="post" name="post">
                        <label class="form-check-label" for="post">
                            Post
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="present_address"
                            name="present_address">
                        <label class="form-check-label" for="present_address">
                            Present Address
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="ctc_year" name="ctc_year">
                        <label class="form-check-label" for="ctc_year">
                            CTC YEAR
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="staff_name" name="staff_name">
                        <label class="form-check-label" for="staff_name">
                            Staff Name
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="age" name="age">
                        <label class="form-check-label" for="age">
                            Current Age
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
                        <input class="form-check-input" type="checkbox" value="1" id="place" name="place">
                        <label class="form-check-label" for="place">
                            Place
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="phone_number" name="phone_number">
                        <label class="form-check-label" for="phone_number">
                            Phone Number
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="job_details" name="job_details">
                        <label class="form-check-label" for="job_details">
                            Job Details
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
                        <input class="form-check-input" type="checkbox" value="1" id="experience" name="experience">
                        <label class="form-check-label" for="experience">
                            Catechism Experience
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="pin_code" name="pin_code">
                        <label class="form-check-label" for="pin_code">
                            Pincode
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="mobile" name="mobile">
                        <label class="form-check-label" for="mobile">
                            Mobile Number
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="secular_qualifications"
                            name="secular_qualifications">
                        <label class="form-check-label" for="secular_qualifications">
                            Secular Qualifications
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="father_name" name="father_name">
                        <label class="form-check-label" for="father_name">
                            Name Of Father
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="t_status" name="t_status">
                        <label class="form-check-label" for="t_status">
                            Name Title
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
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="district" name="district">
                        <label class="form-check-label" for="district">
                            District
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="religious_qualifications"
                            name="religious_qualifications">
                        <label class="form-check-label" for="religious_qualifications">
                            Religious Qualifications
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="emailid" name="emailid">
                        <label class="form-check-label" for="emailid">
                            Email
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="reg_no" name="reg_no">
                        <label class="form-check-label" for="reg_no">
                            Register Number
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="mother_name" name="mother_name">
                        <label class="form-check-label" for="mother_name">
                            Name Of Mother
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="ctc_batch" name="ctc_batch">
                        <label class="form-check-label" for="ctc_batch">
                            CTC Batch
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="catechism_type"
                            name="catechism_type">
                        <label class="form-check-label" for="catechism_type">
                            Catechism Type
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="join_date" name="join_date">
                        <label class="form-check-label" for="join_date">
                            Join Date
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="family_unit_id"
                            name="family_unit_id">
                        <label class="form-check-label" for="family_unit_id">
                            Family Unit
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="stat" name="stat">
                        <label class="form-check-label" for="stat">
                            Status
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="contact_class"
                            name="contact_class">
                        <label class="form-check-label" for="contact_class">
                            Contact Class
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 pl-6">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="sign" name="sign">
                        <label class="form-check-label" for="sign">
                            Signature Column
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
            <h5 class="text-center text-primary ">STAFF LIST </h5>
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