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
<form id="formAuthentication" class="mb-3" action="{{url('/add-settings')}}" method="POST">
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
                        <label for="academic_year" class="form-label">Academic Year</label>
                        <select id="academic_year" name="academic_year" class="form-select form-select-lg">
                            @foreach($academicYears as $id => $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="examtype" class="form-label">Exam Type</label>
                        <select id="examtype" name="examtype" class="form-select form-select-lg">
                            @foreach($examtype as $id => $exam)
                                <option value="{{ $exam->id }}">{{ $exam->type }}</option>
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

    <!-- Working days Table starts here -->
    <div class="card">
        <!-- <h5 class="card-header"></h5> -->
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Classes</th>
                        <th>Min Marks</th>
                        <th>Max Marks</th>
                        <th>Extra Question Paper Count</th>
                        <th>Duration</th>
                        <th>Re-Exam</th>

                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($classes as $ind => $class)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><input type="hidden" name="class[]" class="form-control"
                                    value="{{$class->class}}">{{$class->class}}</td>

                            <td>
                                <input type="number" name="min[]" class="form-control">
                            </td>
                            <td>
                                <input type="number" name="max[]" class="form-control">
                            </td>
                            <td>
                                <input type="number" name="extra_qp[]" class="form-control">
                            </td>
                            <td>
                                <input type="number" name="duration[]" class="form-control">
                            </td>
                            <td>
                                <label for="re_exam" class="form-label">Re Exam Type</label>
                                <select id="re_exam" name="re_exam[]" class="form-select form-select-lg">
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>

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