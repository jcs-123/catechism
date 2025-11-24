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
<form id="formAuthentication" class="mb-3" action="{{url('/add-internal-criteria')}}" method="POST">
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
                                <option value="{{ $year }}" {{$academic_yr == $year ? 'selected' : ''}}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <label for="classesDropdown">Class</label>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="classesDropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Select Classes
                        </button>
                        <div class="dropdown-menu" aria-labelledby="classesDropdown">
                            <div id="classes" class="px-3">
                                @foreach($classes as $class)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="classes[]"
                                            id="class_{{ $class->id }}" value="{{ $class->class }}"
                                            {{in_array($class->class, $class_selected) ? 'checked' : ''}}>
                                        <label class="form-check-label" for="class_{{ $class->id }}">
                                            {{ $class->class }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="no_of_criteria">Number Of Criteria</label>

                        <input type="number" class="form-control" id="no_of_criteria" name="no_of_criteria"
                            placeholder="Enter" value="{{$no_of_criteria}}" autofocus>
                    </div>

                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="total">Total Marks</label>

                        <input type="number" class="form-control" id="total" name="total" value="{{$total}}"
                            placeholder="Enter" autofocus>
                    </div>

                </div>
            </div>


            @if ($no_of_criteria != '')


                <table class="table">
                    <thead>
                        <tr>
                            <th>Slno</th>
                            <th>Criteria</th>
                            <th>Type</th>
                            <th>Max Marks</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @for($i = 1; $i <= $no_of_criteria; $i++)
                            <tr>
                                <td>{{$i}}</td>
                                <td>
                                    <input type="text" name="criteria[]" class="form-control">
                                </td>
                                <td>
                                    <select id="type" name="type[]" class="form-select form-select-lg">
                                        <option value="Half Yearly Exam">Half Yearly Exam</option>
                                        <option value="Attendance">Attendance</option>
                                        <option value="Others">Others</option>

                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="max[]" class="form-control">
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>

            @endif
            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    <!-- <div class="mt-6 mb-3"> -->
                    </br></br>
                    <button class="btn btn-primary d-grid w-70" type="submit">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>


</form>
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