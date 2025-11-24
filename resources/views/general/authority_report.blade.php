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
<form id="formAuthentication" class="mb-3" action="{{url('/authority-report')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-4">
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="authority" class="form-label">Authority</label>
                        <select id="authority" name="authority" class="form-select form-select-lg">
                            @foreach($authorities as $authority)
                                <option value="{{ $authority->id }}">{{ $authority->authority_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="designations">Designation</label>
                        <select id="designations" name="designations" class="form-control">
                            <option value="">Select Unit</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="forane" class="form-label">Foranes</label>
                        <select id="forane" name="forane" class="form-select form-select-lg">
                            @foreach($foranes as $forane)
                                <option value="{{ $forane->forane_code }}">{{ $forane->forane_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="units">Unit</label>
                        <select id="units" name="units" class="form-control">
                            <option value="">Select Unit</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select id="gender" name="gender" class="form-select form-select-lg">
                            <option value="">{{ "Please Select"}}</option>
                            <option value="Female">{{ "Female"}}</option>
                            <option value="Male">{{ "Male"}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-2">
                        <label for="religi_lai" class="form-label">Religious/Laity</label>
                        <select id="religi_lai" name="religi_lai" class="form-select form-select-lg">
                            <option value="">{{ "Please Select"}}</option>
                            <option value="Religious">{{ "Religious"}}</option>
                            <option value="Laity">{{ "Laity"}}</option>
                        </select>
                    </div>
                </div>
            </div>
            </br></br>

            <div class="col-md-12 col-lg-3 pl-3">
                <div class="mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="member_name" name="member_name">
                        <label class="form-check-label" for="member_name">
                            Member Name
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 pl-3">
                <div class="mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="category" name="category">
                        <label class="form-check-label" for="category">
                            Member Category
                        </label>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-12 col-lg-3 pl-3">
                <div class="mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="forane_name" name="forane_name">
                        <label class="form-check-label" for="forane_name">
                            Forane Name
                        </label>
                    </div>
                </div>
            </div> -->
            <div class="col-md-12 col-lg-3 pl-3">
                <div class="mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="unit_name" name="unit_name">
                        <label class="form-check-label" for="unit_name">
                            Unit Name
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 pl-3 ">
                <div class="mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="designation" name="designation">
                        <label class="form-check-label" for="designation">
                            Designation
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 pl-3">
                <div class="mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="email" name="email">
                        <label class="form-check-label" for="email">
                            Email
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 pl-3">
                <div class=" mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="mobile_no" name="mobile_no">
                        <label class="form-check-label" for="mobile_no">
                            Mobile No
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-3 pl-3">
                <div class=" mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="gend" name="gend">
                        <label class="form-check-label" for="gend">
                            Gender
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-3 pl-3">
                <div class=" mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="religious_laity"
                            name="religious_laity">
                        <label class="form-check-label" for="religious_laity">
                            Religious/Laity
                        </label>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-12 col-lg-3 pl-6">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="hm_name" name="hm_name">
                        <label class="form-check-label" for="hm_name">
                            HM name
                        </label>
                    </div>
                </div>
            </div> -->
            <div class="col-md-12 col-lg-3 pl-6">
                <div class="mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="duration" name="duration">
                        <label class="form-check-label" for="duration">
                            Duration
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 pl-6">
                <div class=" mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="hm_sign" name="hm_sign">
                        <label class="form-check-label" for="hm_sign">
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
<div class="card">
    <h5 class="card-header">Unit Report</h5>
    <div class="table-responsive text-nowrap">
        <table class="table" id="example">
            <thead>
                <tr>
                    @foreach($authority_report[0] as $key => $data) 
                        <th>{{$key}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($authority_report as $k => $row)
                    <tr>
                        @foreach($row as $key => $data)
                            <td>{{$data}}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
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
        $('#authority').change(function () {
            var authority = $(this).val();
            //alert(academicYear);
            if (authority) {
                $.ajax({
                    url: 'get-designations/' + authority,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#designations').empty();
                        $('#designations').append('<option value="">Select Designation</option>');
                        $.each(data, function (key, value) {
                            $('#designations').append('<option value="' + value.designation +
                                '">' +
                                value.designation + '</option>');
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
@endsection