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
    <form id="formAuthentication" class="mb-1" action="{{url('/student-register')}}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row gy-1">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <h4>Student Register</h4>
                <div class="card">
                    <div class="row gy-1">

                        <h5 class="mt-4 mb-3">Personal Details</h5>


                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name"
                                        placeholder="Enter" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
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
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="bapt_date">Date Of Baptism</label>

                                    <input type="date" class="form-control" id="bapt_date" name="bapt_date"
                                        placeholder="Enter" autofocus>

                                </div>

                            </div>
                        </div>
                        <div class=" col-md-12 col-lg-4">
                            <div class="card-body">
                                <div class="mt-2 mb-2">
                                    <label for="bapt_name">Baptism Name</label>
                                    <input type="text" class="form-control" id="bapt_name" name="bapt_name"
                                        placeholder="Enter" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="adm_no">Admission No</label>
                                    <input type="text" class="form-control" id="adm_no" name="adm_no" placeholder="Enter"
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
                                    <label for="denom_remarks">Denomination Remarks</label>
                                    <input type="text" class="form-control" id="denom_remarks" name="denom_remarks"
                                        placeholder="Enter" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-12 col-lg-4">
                            <div class="card-body">
                                <div class="mt-2 mb-2">
                                    <label for="char_conduct">Charector&Conduct</label>
                                    <input type="text" class="form-control" id="char_conduct" name="char_conduct"
                                        placeholder="Enter" autofocus>
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



                    </div>
                </div>
                <div class="card">
                    <div class="row gy-1">

                        <h5 class="mt-4 mb-3">Admission Details</h5>


                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="units" class="form-label">Catechism Unit Names</label>
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
                                    <label for="units" class="form-label">Catechism Unit Names</label>
                                    <select id="units" name="units" class="form-select form-select-lg">
                                        @foreach($catechismUnits as $unit)
                                            <option value="{{ $unit->unit_code }}">{{ $unit->unit_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body p-2">
                                <div class="mt-2 mb-3">
                                    <label for="denom">Catechism Type</label>
                                    <select class="form-control" id="denom" name="denom" autofocus>
                                        <option value="" disabled selected>Select Catechism Type</option>
                                        <option value="sunday_catechism">Sunday Catechism</option>
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
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body p-2">
                                <div class="mt-2 mb-3">
                                    <label for="medium">Class Medium</label>
                                    <select class="form-control" id="medium" name="medium" autofocus>
                                        <option value="" disabled selected>Select Class Medium</option>
                                        <option value="Malayalam">Malayalam Medium</option>
                                        <option value="English">English Medium</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <div class="mt-2 mb-3">
                                    <label for="stud_class" class="form-label">Class<span
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
                                    <label for="class_division" class="form-label">Division<span
                                            style="color: red;">*</span></label>
                                    <select class="form-select form-select-lg" id="class_division" name="class_division"
                                        autofocus>
                                        <option value="" disabled selected>Select Division</option>
                                    </select>
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


                        <div class="col-md-12 col-lg-2 ">
                            <div class=" mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="boys_assoc"
                                        name="boys_assoc">
                                    <label class="form-check-label" for="boys_assoc">
                                        Alter Boys Association
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 ">
                            <div class=" mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="choir" name="choir">
                                    <label class="form-check-label" for="choir">
                                        Choir
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 ">
                            <div class=" mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="clc" name="clc">
                                    <label class="form-check-label" for="clc">
                                        CLC
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 ">
                            <div class=" mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="holy_childhood"
                                        name="holy_childhood">
                                    <label class="form-check-label" for="holy_childhood">
                                        Holy Childhood
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 ">
                            <div class=" mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="jesus_youth"
                                        name="jesus_youth">
                                    <label class="form-check-label" for="jesus_youth">
                                        Jesus Youth
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 ">
                            <div class=" mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="juni_choir"
                                        name="juni_choir">
                                    <label class="form-check-label" for="juni_choir">
                                        Junior Choir
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 ">
                            <div class=" mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="juni_clc" name="juni_clc">
                                    <label class="form-check-label" for="juni_clc">
                                        Junior CLC
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 ">
                            <div class=" mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="kcym" name="kcym">
                                    <label class="form-check-label" for="kcym">
                                        KCYM
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 ">
                            <div class=" mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="svdp" name="svdp">
                                    <label class="form-check-label" for="svdp">
                                        SVDP
                                    </label>
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
                        <div class="col-md-12 col-lg-2 ">
                            <div class=" mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="date_of_join"
                                        name="date_of_join">
                                    <label class="form-check-label" for="date_of_join">
                                        Date Of Join
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="prices_awards">Prizes and Awards</label>
                                    <input type="text" class="form-control" id="prices_awards" name="prices_awards"
                                        placeholder="Enter" autofocus>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter"
                                        autofocus>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4">
                            <div class="card-body">
                                <!-- <small class="text-light fw-medium">Academic Year</small> -->
                                <div class="mt-2 mb-3">
                                    <label for="logo">Upload Student Photo(max width x height : 150 x 200)</label>
                                    <input type="file" name="logo" id="logo" accept="application/pdf">
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