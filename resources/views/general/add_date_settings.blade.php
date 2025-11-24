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
<form id="formAuthentication" class="mb-3" action="{{url('/add-date-settings')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-3">
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
            <div class="col-md-12 col-lg-3">
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
                                            id="class_{{ $class->id }}" value="{{ $class->class }}">
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
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="extra_attendance_hm">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Enter"
                            autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="last_attn_date">Last Attendance Date</label>
                        <input type="date" class="form-control" id="last_attn_date" name="last_attn_date"
                            placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="last_attn_entry_date">Last Attendance Entry Date</label>
                        <input type="date" class="form-control" id="last_attn_entry_date" name="last_attn_entry_date"
                            placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="half_yr_exam_date">Half Yearly Exam Date</label>
                        <input type="date" class="form-control" id="half_yr_exam_date" name="half_yr_exam_date"
                            placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="half_yr_mark_entry_last_dt">Half Yearly Mark Entry Last Date</label>
                        <input type="date" class="form-control" id="half_yr_mark_entry_last_dt"
                            name="half_yr_mark_entry_last_dt" placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="half_yr_re_exam_date">Half Yearly Re-Exam Date</label>
                        <input type="date" class="form-control" id="half_yr_re_exam_date" name="half_yr_re_exam_date"
                            placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="half_yr_re_mark_last_date">Half Yearly Re-Exam Mark Entry Last Date</label>
                        <input type="date" class="form-control" id="half_yr_re_mark_last_date"
                            name="half_yr_re_mark_last_date" placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="extra_attn_entry_last_date">Extra Attendance Entry Last Date</label>
                        <input type="date" class="form-control" id="extra_attn_entry_last_date"
                            name="extra_attn_entry_last_date" placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="annual_exm_date">Annual Exam Date</label>
                        <input type="date" class="form-control" id="annual_exm_date" name="annual_exm_date"
                            placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="annual_exm_mrk_en_lst_date">Annual Exam Mark Entry Last Date</label>
                        <input type="date" class="form-control" id="annual_exm_mrk_en_lst_date"
                            name="annual_exm_mrk_en_lst_date" placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="annual_re_exam_date">Annual Re-Exam Date</label>
                        <input type="date" class="form-control" id="annual_re_exam_date" name="annual_re_exam_date"
                            placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="annual_re_exam_mrk_entry_date">Annual Re-Exam Mark Entry Last Date</label>
                        <input type="date" class="form-control" id="annual_re_exam_mrk_entry_date"
                            name="annual_re_exam_mrk_entry_date" placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="intrnl_mrks_ent_lst_dt">Internal Marks Entry Last Date</label>
                        <input type="date" class="form-control" id="intrnl_mrks_ent_lst_dt"
                            name="intrnl_mrks_ent_lst_dt" placeholder="Enter" autofocus>
                    </div>
                </div>
            </div>
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    </br></br>
                    <button class="btn btn-primary d-grid w-70" type="submit">Add</button>
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