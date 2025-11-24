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
<form id="formAuthentication" class="mb-3" action="{{url('/unit-report')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-4">
            <!-- Congratulations card -->
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
            </br></br>

            <div class="col-md-12 col-lg-3 ">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="forane_name" name="forane_name">
                        <label class="form-check-label" for="forane_name">
                            Forane
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 pl-6">
                <div class="mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="class_count" name="class_count">
                        <label class="form-check-label" for="class_count">
                            Class Count
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 pl-6">
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

            <div class="col-md-12 col-lg-3 pl-6">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="student_count"
                            name="student_count">
                        <label class="form-check-label" for="student_count">
                            Student Count
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-3 pl-6">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="staff_count" name="staff_count">
                        <label class="form-check-label" for="staff_count">
                            Staff Count
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
            <!-- <div class="col-md-12 col-lg-3 pl-6">
                <div class=" mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="mobile" name="mobile">
                        <label class="form-check-label" for="mobile">
                            HM Contact No
                        </label>
                    </div>
                </div>
            </div> -->
            <div class="col-md-12 col-lg-4 pl-6">
                <div class=" mt-4">
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
                    @foreach($unit_report as $key => $data) 
                        <th>{{$key}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <tr>
                    @foreach($unit_report as $key => $data)
                        <td>{{$data}}</td>
                    @endforeach
                </tr>
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
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
        });
    });
</script>
@endsection