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
<form id="formAuthentication" class="mb-1" action="{{url('/add-unit')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-1">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
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
            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    <!-- <div class="mt-6 mb-3"> -->
                    </br></br>
                    <button class="btn btn-primary d-grid w-70" type="submit">Add</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Working days Table starts here -->
<div class="card mt-3">
    <div class="row gy-1">
        <h5 class="pl-5 mb-4 mt-4">Unit Address Report </h5>

        @foreach($unit_add_report as $data)

            <div class="col-sm-6 col-lg-4 mt-3 mb-3">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$data->unit_name}}</h5>
                        <div class="card-text">{{$data->unit_address}}</div>
                        <div class="card-text">{{$data->place}}</div>
                        <div class="card-text">{{$data->post}}</div>
                        <div class="card-text">{{$data->district}}</div>
                        <div class="card-text">{{$data->state}}</div>
                        <div class="card-text">{{$data->pincode}}</div>
                        <div class="card-text">{{$data->email}}</div>


                    </div>
                </div>

            </div>
        @endforeach
    </div>

</div>
<!-- <h5 class="card-header"></h5> -->
<!-- <div class="table-responsive text-nowrap"> -->
<!-- <table class="table">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Academic Year</th>
                    <th>Acc Syllabus</th>
                    <th>Extra Attendance HM Count</th>
                    <th>Extra Attendance Vicar Count</th>
                    <th>Extra Attendance DBCLC Count</th>
                    <th>Status </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">

            </tbody>
         -->


<!-- </div> -->
<!--/ Working days Table ends here-->

</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    $(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/data',
            columns: [{
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'updated_at',
                name: 'updated_at'
            }
            ]
        });
    });
</script>
@endsection