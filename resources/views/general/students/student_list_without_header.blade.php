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
<form id="formAuthentication" class="mb-3" action="{{url('/student-list-without-header')}}" method="POST">
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
                            <option value="">Select forane</option>
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
                            <option value="">Select School</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->unit_code }}">
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
                        <label for="stud_class" class="form-label">Class<span style="color: red;">*</span></label>
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
                        <label for="class_division" class="form-label">Division<span
                                style="color: red;">*</span></label>
                        <select class="form-select form-select-lg" id="class_division" name="class_division" autofocus>
                            <option value="" disabled selected>Select Division</option>
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
            <div class="col-md-12 col-lg-2">
                <div class="card-body p-3">
                    <div class="mt-2 mb-3">
                        <label for="health_statuses">Health Status</label>
                        <select class="form-control" id="health_statuses" name="health_statuses" autofocus>
                            <option value="" disabled selected>Select Health Status</option>
                            @foreach($healthStatus as $health)
                                <option value="{{ $health->id }}" {{ $health->name == $selectedhealthStatus ? 'selected' : '' }}>{{ $health->name }}</option>
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
            <div class=" col-md-12 col-lg-4">
                <div class="card-body">
                    <div class="mt-2 mb-4">
                        <label for="age_from">Age From</label>
                        <input type="number" class="form-control" id="age_from" name="age_from" placeholder="Enter"
                            autofocus>
                    </div>
                </div>
            </div>
            <div class=" col-md-12 col-lg-4">
                <div class="card-body">
                    <div class="mt-2 mb-4">
                        <label for="age_to">Age To</label>
                        <input type="number" class="form-control" id="age_to" name="age_to" placeholder="Enter"
                            autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body p-2">
                    <div class="mt-2 mb-3">
                        <label for="cont_class">Contact class</label>
                        <select class="form-control" id="cont_class" name="cont_class" autofocus>
                            <option value="" disabled selected>Select</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body p-2">
                    <div class="mt-0 mb-3">
                        <label for="denom">Denom</label>
                        <select class="form-control" id="denom" name="denom" autofocus>
                            <option value="" disabled selected>Select</option>
                            <option value="CL">Catholic</option>
                            <option value="NL">Non-Catholic</option>
                            <option value="NC">Non-Cristian</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="adm_no" name="adm_no">
                        <label class="form-check-label" for="adm_no">
                            Admission No
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
                        <input class="form-check-input" type="checkbox" value="1" id="stud_dioc" name="stud_dioc">
                        <label class="form-check-label" for="stud_dioc">
                            Student Diocese
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
                        <input class="form-check-input" type="checkbox" value="1" id="class_medium" name="class_medium">
                        <label class="form-check-label" for="class_medium">
                            Medium
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="member_code" name="member_code">
                        <label class="form-check-label" for="member_code">
                            Member Code
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
                            Student Forane
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
                        <input class="form-check-input" type="checkbox" value="1" id="exam_unit" name="exam_unit">
                        <label class="form-check-label" for="exam_unit">
                            Exam Unit
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="student_name" name="student_name"
                            checked>
                        <label class="form-check-label" for="student_name">
                            Student Name
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
                            Student Parish
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
                        <input class="form-check-input" type="checkbox" value="1" id="class" name="class">
                        <label class="form-check-label" for="class">
                            Class
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
                        <input class="form-check-input" type="checkbox" value="1" id="catechism_forane_code"
                            name="catechism_forane_code">
                        <label class="form-check-label" for="catechism_forane_code">
                            Catechism Forane
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
                        <input class="form-check-input" type="checkbox" value="1" id="division" name="division">
                        <label class="form-check-label" for="division">
                            Division
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
                        <input class="form-check-input" type="checkbox" value="1" id="BaptName" name="BaptName">
                        <label class="form-check-label" for="BaptName">
                            Baptismal Name
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
                        <input class="form-check-input" type="checkbox" value="1" id="identification_mark"
                            name="identification_mark">
                        <label class="form-check-label" for="identification_mark">
                            Identification Mark
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
                        <input class="form-check-input" type="checkbox" value="1" id="pious" name="pious">
                        <label class="form-check-label" for="pious">
                            Pious Assoc
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
                        <input class="form-check-input" type="checkbox" value="1" id="health_status"
                            name="health_status">
                        <label class="form-check-label" for="health_status">
                            Health Status
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
            <div class="col-md-12 col-lg-2 pl-6">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="division_count"
                            name="division_count">
                        <label class="form-check-label" for="division_count">
                            Division Count
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-2 pl-6">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="denomination" name="denomination">
                        <label class="form-check-label" for="denomination">
                            Denomination
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
            <h5 class="text-center text-primary ">STUDENT LIST {{$academicYear['academic_year']}}
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