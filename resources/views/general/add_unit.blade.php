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
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="parish" class="form-label">Parishes</label>
                        <select id="parish" name="parish" class="form-select form-select-lg">
                            @foreach($parishes as $parish)
                                <option value="{{ $parish->parish_code }}">{{ $parish->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="unit_full_name">Unit full name</label>
                        <input type="text" class="form-control" id="unit_full_name" name="unit_full_name"
                            placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="mobile_no">Mobile No</label>
                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter"
                            autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="fax">Fax</label>

                        <input type="text" class="form-control" id="fax" name="fax" placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="email">Email</label>

                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter"
                            autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="place">Place</label>

                        <input type="text" class="form-control" id="place" name="place" placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>


            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="post">post</label>
                        <input type="text" class="form-control" id="post" name="post" placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="pincode">pincode</label>
                        <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter"
                            autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="district">district</label>
                        <input type="text" class="form-control" id="district" name="district" placeholder="Enter"
                            autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="state">state</label>
                        <input type="text" class="form-control" id="state" name="state" placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="mass_time">mass_time</label>
                        <input type="text" class="form-control" id="mass_time" name="mass_time" placeholder="Enter"
                            autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="catechism_time">catechism_time</label>
                        <input type="text" class="form-control" id="catechism_time" name="catechism_time"
                            placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="vicar_name">vicar_name</label>
                        <input type="text" class="form-control" id="vicar_name" name="vicar_name" placeholder="Enter"
                            autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="asst_vicar">asst_vicar</label>

                        <input type="text" class="form-control" id="asst_vicar" name="asst_vicar" placeholder="Enter"
                            autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="prin_sign">Principal Signature</label>
                        <input type="file" name="prin_sign" id="prin_sign" accept="application/pdf">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="vigar_sign">Vigar Signature</label>
                        <input type="file" name="vigar_sign" id="vigar_sign" accept="application/pdf">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="logo">Logo</label>
                        <input type="file" name="logo" id="logo" accept="application/pdf">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="motto">Motto</label>
                        <input type="text" class="form-control" id="motto" name="motto" placeholder="Enter" autofocus>
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

            </tbody>
        </table>
    </div>
</div>
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