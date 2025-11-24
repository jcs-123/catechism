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
<form id="formAuthentication" class="mb-3" action="{{url('/add-excellence-criteria')}}" method="POST">
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
                        <label for="no_of_criteria">Number Of Criteria</label>

                        <input type="number" class="form-control" id="no_of_criteria" name="no_of_criteria"
                            placeholder="Enter" value="{{$no_of_criteria}}" autofocus>
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

    @if ($no_of_criteria != '')


        <table class="table">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Title</th>
                    <th>Criteria Desc</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @for($i = 1; $i <= $no_of_criteria; $i++)
                    <tr>
                        <td>{{$i}}</td>
                        <td>
                            <input type="text" name="title[]" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="desc[]" class="form-control">
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