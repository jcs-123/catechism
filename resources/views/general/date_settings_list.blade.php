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
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
<form id="formAuthentication" class="mb-3" action="{{url('/date-settings-list')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-4">
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <div class="mt-2 mb-3">
                        <label for="academic_year" class="form-label">Academic Year</label>
                        <select id="academic_year" name="academic_year" class="form-select form-select-lg">
                            @foreach($academicYears as $year)
                                <option value="{{ $year['academic_year'] }}">{{ $year['academic_year'] }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>
            <div class="col-md-6">
                <label for="classes">Class</label>
                <select id="classes" name="classes" class="form-control">
                    <option value="">Select Class</option>
                </select>
            </div>
            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    </br></br>
                    <button class="btn btn-primary d-grid w-70" type="submit">Search</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Working days Table starts here -->
<div class="card">
    <h5 class="card-header">Important Days List</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Type</th>
                    <th>Date</th>
                    <!-- <th>Max Marks</th>
                    <th>Extra Qpaper Count</th>
                    <th>Duration</th> -->
                    <!-- <th>Re Exam</th> -->
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($settings as $sett)

                    <tr>
                        <td>1</td>
                        </td>
                        <td>Start Date</td>
                        <td>{{$sett['start_date']}}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        </td>
                        <td>Last Attendance Date</td>
                        <td>{{$sett['last_attd_date']}}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        </td>
                        <td>Last Attendance Entry Date</td>
                        <td>{{$sett['last_attd_entry_date']}}</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        </td>
                        <td>Half Yearly Exam Date</td>
                        <td>{{$sett['hy_exam_date']}}</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        </td>
                        <td>Half Yearly Exam Mark Entry Last Date</td>
                        <td>{{$sett['hy_mark_last_date']}}</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        </td>
                        <td>Half Yearly Re-Exam Mark Entry Last Datee</td>
                        <td>{{$sett['re_exam_hy_exam_date']}}</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        </td>
                        <td>Annual Exam Date</td>
                        <td>{{$sett['annual_exam_date']}}</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        </td>
                        <td>Annual Exam Mark Entry Last Date</td>
                        <td>{{$sett['annual_mark_last_date']}}</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        </td>
                        <td>Annual Re-Exam Date</td>
                        <td>{{$sett['re_exam_annual_exam_date']}}</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        </td>
                        <td>Annual Exam Mark Entry Last Date</td>
                        <td>{{$sett['re_exam_annual_mark_last_date']}}</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        </td>
                        <td>Internal Mark Entry Last Date</td>
                        <td>{{$sett['int_mark_entry_date']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!--/ Working days Table ends here-->

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<script>
    $(document).ready(function () {
        $('#academic_year').change(function () {
            var academicYear = $(this).val();
            //alert(academicYear);
            if (academicYear) {
                $.ajax({
                    url: 'get-classes/' + academicYear,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#classes').empty();
                        $('#classes').append('<option value="">Select Class</option>');
                        $.each(data, function (key, value) {
                            $('#classes').append('<option value="' + value.class +
                                '">' +
                                value.class + '</option>');
                        });
                    }
                });
            } else {
                $('#classes').empty();
                $('#classes').append('<option value="">Select Class</option>');
            }
        });
    });
</script>
@endsection