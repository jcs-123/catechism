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
<form id="addworkingdays" class="mb-3" action="{{url('/add-working-days')}}" method="POST">
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
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="class">Class</label>

                        <select id="classes" name="classes" class="form-select form-select-lg">
                            @foreach($classes as $id => $class)
                            <option value="{{ $class }}">{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="tot_working_days">Total Working Days </label>

                        <input type="number" class="form-control" id="tot_working_days" name="tot_working_days"
                            placeholder="Enter" autofocus>

                    </div>

                </div>
            </div></br>

            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    <!-- <div class="mt-6 mb-3"> -->

                    <button class="btn btn-primary d-grid w-70" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>


</div>



@endsection