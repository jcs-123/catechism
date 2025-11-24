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
<form id="formAuthentication" class="mb-3" action="{{url('/add-events')}}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="row gy-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Congratulations card -->
            <div class="card-body">
                <div class=" col-md-12 ">
                    <div class="mt-2 mb-4 col-md-6 float-left">
                        <label for="title">Event Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Event Title"
                            autofocus>
                    </div>
                    <div class="mt-2 mb-4  col-md-6 float-right">
                        <label for="discription">Event Discription</label>
                        <input type="text" class="form-control" id="discription" name="discription"
                            placeholder="Enter Event Discription" autofocus>
                    </div>
                </div>

                <div class=" col-md-12 ">
                    <div class="mt-2 mb-4 col-md-6 float-left">
                        <label for="image">Event Image</label>
                        <input type="file" class="form-control" id="event_image" name="event_image"
                            accept="application/pdf">
                    </div>

                    <div class="mt-2 mb-4 col-md-6 float-right">
                        <label for="pdf">Event file</label>
                        <input type="file" class="form-control" name="pdf" id="pdf" accept="application/pdf">
                    </div>
                </div>

                <div class=" col-md-12">
                    <div class="mt-2 mb-4  col-md-6 float-left">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Enter"
                            autofocus>
                    </div>

                    <div class="mt-2 mb-4 col-md-6 float-right">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Enter"
                            autofocus>
                    </div>
                </div>
                <!-- 
                <div class="col-md p-4">
                    <small class="text-light fw-medium d-block">Status</small>
                    <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" name="status" id="published">
                        <label class="form-check-label" for="published">published</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" id="pending">
                        <label class="form-check-label" for="pending">pending</label>
                    </div>
                </div> -->

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