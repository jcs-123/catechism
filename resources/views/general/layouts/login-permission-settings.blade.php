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
<form id="formAuthentication" class="mb-3" action="{{url('/login-permission-settings')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-4">
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="unit_code" class="form-label">Academic Year</label>
                        <select id="unit_code" name="unit_code" class="form-select form-select-lg">
                            <option value="">-- Select a Unit --</option>
                            @foreach($cat_units as $id => $unit)
                            <option value="{{ $id }}" {{ old('unit_code', $id) == $unit_code ? 'selected' : '' }}>
                                {{ $unit }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>
            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    <!-- <div class="mt-6 mb-3"> -->
                    </br></br>
                    <button class="btn btn-primary d-grid w-70" type="submit">{{ $action_type }}</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Working days Table starts here -->
<div class="card">
    <h5 class="card-header">Working Days List</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th class="header" style="width:5%;">#</th>
                    <th class="header" style="width:10%;">Class & Division</th>
                    <th class="header" style="width:30%;">Staff Name</th>
                    <th class="header" style="width:15%;">Username</th>
                    <th class="header" style="width:15%;">Initial Password</th>
                    <th class="header" style="width:15%;">Permission&nbsp;&nbsp;&nbsp;<input type="checkbox"
                            name="check_all" id="check_all" onClick="select_all()">selectall</th>
                    <th class="header" style="width:10%;">Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @if(isset($distinct_class_divisions) && !empty($distinct_class_divisions))
                @foreach($distinct_class_divisions as $divn => $clssDiv)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$clssDiv->class_login_exist->class ?? ''}} {{$clssDiv->class_login_exist->division ?? ''}}
                    </td>
                    <td><select id="{{$clssDiv->class_login_exist->class}}'_'{{$clssDiv->class_login_exist->division}}"
                            name="staff_arr[{{$clssDiv->class_login_exist->class}}'_'{{$clssDiv->class_login_exist->division}}]"
                            class="form-select form-select-lg">
                            <option value="">--select a staff--</option>
                            @if($active_staffs)
                            @foreach($active_staffs as $each_staff)
                            <option value="{{ $each_staff->staff_code }}"
                                {{ ($each_staff->staff_code == $clssDiv->class_login_exist->staff_code) ? 'selected' : '' }}>
                                {{ $each_staff->t_status }} {{$each_staff->staff_name}}
                            </option>
                            @endforeach
                            @endif
                        </select></td>
                    <td>{{$clssDiv->class_login_exist->username ?? ''}}</td>
                    <td>{{$clssDiv->class_login_exist->password_decrypted ?? ''}}</td>
                    <td></td>
                    <td><a href="#">Change</a></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<!--/ Working days Table ends here-->

</div>


<script>
$(function() {
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