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
<form id="formAuthentication" class="mb-3" action="{{url('/criteria-list')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-4">
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
    <h5 class="card-header">Criteria List</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Class</th>
                    <th>Criteria</th>
                    <th>Percentage of marks/Minimumu marks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($criterias as $ind => $crit)
                    <td>{{$loop->iteration}}</td>
                    </td>
                    <td>{{$crit->class}}</td>
                    <td>{{$crit->criteria}}</td>
                    <td>{{$crit->annual}}</td>
                    <td>
                        <div class="dropdown" style="display:none">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                                    class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i
                                        class="mdi mdi-pencil-outline me-1"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i
                                        class="mdi mdi-trash-can-outline me-1"></i> Delete</a>
                            </div>
                        </div>
                    </td>
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