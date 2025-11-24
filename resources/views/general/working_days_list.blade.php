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
<form id="formAuthentication" class="mb-3" action="{{url('/working-days-list')}}" method="POST">
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
                    <button class="btn btn-primary d-grid w-70" type="submit">load</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Working days Table starts here -->
<div class="card">
    <h5 class="card-header">Working Days List</h5>
    <div class="table-responsive text-nowrap" style="padding:5px">
        <table class="table" id="working_days_table" style="width: 100%;
    border: 1px solid #ede6e6;">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Academic Year</th>
                    <th>Class</th>
                    <th>Working Days</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($working_days as $ind => $day)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        </td>
                        <td>{{$day->academic_year}}</td>
                        <td>{{$day->class}}</td>
                        <td>{{$day->total_working_days}}</td>
                        <td>
                            <div class="dropdown" style="display:none">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
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
    $(document).ready(function () {
        $('#sworking_days_table').DataTable({
            dom: 'Bfrtip',
            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
        });
    });
    $(document).ready(function () {
        $('#working_days_table').DataTable({
            // processing: true,
            // serverSide: true,
            // ajax: '/data',
            dom: 'Bfrtip',
            buttons: ['excelHtml5'],
            // columns: [{
            //         data: 'name',
            //         name: 'name'
            //     },
            //     {
            //         data: 'email',
            //         name: 'email'
            //     },
            //     {
            //         data: 'created_at',
            //         name: 'created_at'
            //     },
            //     {
            //         data: 'updated_at',
            //         name: 'updated_at'
            //     }
            // ]
        });
    });
</script>
@endsection