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
<form id="formAuthentication" class="mb-3" action="{{url('/division-management')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-4">
            <!-- Congratulations card -->
            <div class="col-md-12 col-lg-4">
                <div class="card-body">
                    <!-- <small class="text-light fw-medium">Academic Year</small> -->
                    <div class="mt-2 mb-3">
                        <label for="forane" class="form-label">Foranes</label>
                        <select id="forane" name="forane" class="form-select form-select-lg">
                            @foreach($foranes as $forane)
                                <option value="{{ $forane->forane_code }}">{{ $forane->forane_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card-body">

                    <div class="mt-2 mb-3">

                        <label for="units">Unit</label>
                        <select id="units" name="units" class="form-control">
                            <option value="">Select Unit</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Congratulations card -->
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
@if(isset($divisions) && $divisions != '')
    <!-- Working days Table starts here -->
    <div class="card">
        <!-- <h5 class="card-header"></h5> -->
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Class</th>
                        <th>Divisions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($divisions as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            </td>
                            <td>{{$data->class}}</td>
                            <td>{{$data->divisions}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
<!--/ Working days Table ends here-->

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<script>
    $(document).ready(function () {
        $('#forane').change(function () {
            var forane = $(this).val();
            // alert(forane);
            if (forane) {
                $.ajax({
                    url: 'get-units/' + forane,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#units').empty();
                        $('#units').append('<option value="">Select unit</option>');
                        $.each(data, function (key, value) {
                            $('#units').append('<option value="' + value.unit_code +
                                '">' +
                                value.unit_name + '</option>');
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
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
        });
    });
</script>
@endsection