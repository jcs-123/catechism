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
<form id="formAuthentication" class="mb-3" action="{{url('/staff-transfer')}}" method="POST">
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
            <div class="col-md-12 col-lg-4" id="unit_div">
                <div class="card-body">

                    <div class="mt-2 mb-3">

                        <label for="staff_name">Staff Name</label>
                        <select id="staff_name" name="staff_name" class="form-control">
                            <option value="">Select Unit</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md p-4">
                <small class="text-light fw-medium d-block">Diocese</small>
                <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="radio" name="diocese" id="thrissur" value="thrissur">
                    <label class="form-check-label" for="1">Thrissur</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="diocese" id="other" value="other">
                    <label class="form-check-label" for="1">Other</label>
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
            <div class="col-md-12 col-lg-4" id="catechism_unit_div">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="catechism_unit" class="form-label">Catechism Unit to which the staff is
                            transferred</label>
                        <select id="catechism_unit" name="catechism_unit" class="form-select form-select-lg">
                            <option value="">Select catechism unit</option>
                            @foreach($catechismUnits as $catechism_unit)
                                <option value="{{ $catechism_unit->unit_code }}">
                                    {{ $catechism_unit->unit_name}}
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
                        <label for="transfer_date">Date Of Transfer</label>
                        <input type="date" class="form-control" id="transfer_date" name="transfer_date"
                            placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="transfer_reason">Reason for Transfer</label>
                        <input type="text" class="form-control" id="transfer_reason" name="transfer_reason"
                            placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    <button class="btn btn-primary d-grid w-70 mt-6 mb-3" type="submit">Search</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Working days Table starts here -->
@if(isset($trans_list) && !empty($trans_list))

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
            <h5 class="text-center text-primary ">STAFF TRANSFER LIST
            </h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th class="header" style="width:5%;">#</th>
                        <th class="header" style="width:15%;">Transfer id</th>
                        <th class="header" style="width:15%;">Transfered To</th>
                        <th class="header" style="width:30%;">Staff Name</th>
                        <th class="header" style="width:10%;">Date Of Transfer</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if(isset($trans_list) && !empty($trans_list))
                        @foreach($trans_list as $staffs)

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                </td>
                                <td>{{$staffs['transfer_id']}}</td>
                                <td>{{$staffs['to_unit_code']}}</td>
                                <td>{{$staffs['staff_name']}}</td>
                                <td>{{$staffs['date_of_transfer']}}</td>
                            </tr>
                        @endforeach
                    @endif

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
                $.ajax({
                    url: 'get-staffs/' + forane,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#staff_name').empty();
                        $('#staff_name').append('<option value="">Select unit</option>');
                        $.each(data, function (key, value) {
                            $('#staff_name').append('<option value="' + value.staff_code +
                                '">' +
                                value.staff_name + '</option>');
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