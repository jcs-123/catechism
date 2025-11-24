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
    <form id="formAuthentication" class="mb-3" action="{{url('/cancel-tc')}}" method="POST">
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
                            <label for="unit_code" class="form-label">Units</label>
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
        <h5 class="card-header">Student List</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th class="header" style="width:5%;">#</th>
                        <th class="header" style="width:15%;">Transfered To</th>
                        <th class="header" style="width:30%;">Student Name</th>
                        <th class="header" style="width:15%;">Transfer Reason</th>
                        <th class="header" style="width:10%;">Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if(isset($transfered_students) && !empty($transfered_students))
                        @foreach($transfered_students as $students)

                            <tr>
                                <td>{{$loop->iteration}}</td>
                                </td>
                                <td>{{$students['to_unit_name']}}</td>
                                <td>{{$students['student_name']}}</td>
                                <td>{{$students['transfer_reason']}}</td>
                                <td>
                                    <a href="{{ route('cancel-student-TC', ['transfer_id' => $students['transfer_id']]) }}">Cancel
                                        TC</a>
                                </td>
                                <td></td>
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