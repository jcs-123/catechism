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

@section('content')
<form id="formAttendanceReason" class="mb-3" action="{{url('/name-titles')}}" method="POST">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @csrf
    <div class="card">
        <div class="row gy-4">
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="name_title">Name Title</label>
                        <input type="text" class="form-control" id="name_title" name="name_title" placeholder="Enter"
                            autofocus>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="order">Show Order</label>

                        <input type="number" class="form-control" id="order" name="order" placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    <!-- <div class="mt-6 mb-3"> -->
                    </br>
                    <button type="submit" class="btn btn-primary d-grid w-70" id="submit">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="card">

    <div class="col-md-12 col-lg-2">
        <div class="card-body">
            <!-- <div class="mt-6 mb-3"> -->
            </br>
            <button class="btn btn-primary d-grid w-70" id="addButton">Add</button>
        </div>
    </div>
</div>

<!-- Working days Table starts here -->
<div class="card">
    <!-- <h5 class="card-header"></h5> -->
    <div class="table-responsive text-nowrap">
        <table class="table" id="example">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Name Title</th>
                    <th>Show Order</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($name_title_data as $data)

                    <tr>
                        <td>{{$loop->iteration}}</td>
                        </td>
                        <td>{{$data['title']}}</td>
                        <td>{{$data['show_order']}}</td>
                        <td><a href="" ;>Change</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!--/ Working days Table ends here-->

</div>


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
        $('#formAttendanceReason').hide(); // Show the form
        //$('#addButton').show(); // Show the form

        $('#addButton').on('click', function () {
            $('#formAttendanceReason').show();
            $('#addButton').hide(); // Show the form
            // Show the form
        });

        $('#cancelButton').on('click', function () {
            $('#formAttendanceReason').hide(); // Hide the form
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