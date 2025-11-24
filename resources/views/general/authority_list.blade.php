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
<form id="formAuthentication" class="mb-3" action="{{url('/authority-list')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-4">
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select form-select-lg">
                            <option value="1">{{ "Active"}}</option>
                            <option value="0">{{ "Inactive"}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    <!-- <div class="mt-6 mb-3"> -->
                    </br></br>
                    <button class="btn btn-primary d-grid w-70" type="submit">Search</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Working days Table starts here -->
<div class="card">
    <h5 class="card-header">Exam Settings List</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Authority Name</th>
                    <th>Duration</th>
                    <th>Academic Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($authorities as $data)

                    <tr>
                        <td>{{$loop->iteration}}</td>
                        </td>
                        <td>{{$data['authority_name']}}</td>
                        <td>{{$data['duration']}}</td>
                        <td>{{$data['academic_year']}}</td>
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