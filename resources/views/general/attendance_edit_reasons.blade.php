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
<form id="formAttendanceReason" class="mb-3" action="{{url('/attendance-edit-reason')}}" method="POST">
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
                        <label for="reason">Reason</label>

                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter" autofocus>
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
                    <th>Reason</th>
                    <th>Display Order</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($at_ed_reasons as $reason)

                    <tr>
                        <td>{{$loop->iteration}}</td>
                        </td>
                        <td>{{$reason['reason']}}</td>
                        <td>{{$reason['display_order']}}</td>
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
@endsection