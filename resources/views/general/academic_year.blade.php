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
<form id="formAuthentication" class="mb-3" action="{{url('/academic-year')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="academic_year" class="form-label">Academic Year(yyyy-yyyy)</label>
                        <input type="text" class="form-control" id="academic_year" name="academic_year"
                            placeholder="Enter" autofocus>
                    </div>

                </div>

            </div>
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="extra_attendance_hm">Extra Attendance HM Count</label>

                        <input type="number" class="form-control" id="extra_attendance_hm" name="extra_attendance_hm"
                            placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="extra_attendance_vicar">Extra Attendance Vicar Count</label>

                        <input type="number" class="form-control" id="extra_attendance_vicar"
                            name="extra_attendance_vicar" placeholder="Enter" autofocus>

                    </div>

                </div>
            </div></br>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="extra_attendance_dbclc">Extra Attendance DBCLC Count</label>

                        <input type="number" class="form-control" id="extra_attendance_dbclc"
                            name="extra_attendance_dbclc" placeholder="Enter" autofocus>

                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-3 pl-6">
                <div class="mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="extra_attendance_permission"
                            name="extra_attendance_permission">
                        <label class="form-check-label" for="extra_attendance_permission">
                            Permission for extra attendance
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    <!-- <div class="mt-6 mb-3"> -->
                    </br></br>
                    <button class="btn btn-primary d-grid w-70" type="submit">load</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Working days Table starts here -->
<div class="card">
    <!-- <h5 class="card-header"></h5> -->
    <div class="table-responsive text-nowrap">
        <table class="table">
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
                @foreach($academicYears as $data)

                    <tr>
                        <td>{{$loop->iteration}}</td>
                        </td>
                        <td>{{$data['academic_year']}}</td>
                        <td>{{$data['extra_attendance_hm_ct']}}</td>
                        <td>{{$data['extra_attendance_vicar_ct']}}</td>
                        <td>{{$data['extra_attendance_dbclc_ct']}}</td>
                        <td>{{$data['status']}}</td>
                        <td></td>
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