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
<form id="formAuthentication" class="mb-1" action="{{url('/staff-summary-report')}}" method="POST">
    @csrf
    <div class="card">
        <div class="row gy-1">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
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

            <div class="col-md-12 col-lg-2">
                <div class="card-body">
                    <!-- <div class="mt-6 mb-3"> -->
                    </br></br>
                    <button class="btn btn-primary d-grid w-70" type="submit">GENERATE</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Working days Table starts here -->
<div style=" border: solid 3px
    #000;border-radius:10px;padding-left:10px;padding-right:10px;margin-top:100px;margin-left:30px;margin-right:30px;"">
     <div class=" app-brand justify-content-center mt-5">
    <span class="app-brand-logo demo"><img src="{{asset('assets/img/logo/logo.png')}}" alt="auth-tree"
            style="bottom: 355px;left: 160px;"></span>
    </br><span class="app-brand-text demo text-heading fw-semibold">ARCHDIOCESE OF TRICHUR,SUNDAY CATECHISHM </span>

    </br></br><span class=" demo fw-semibold">Catechetical centre,D.B.C.L.C Thrissur - 680
        005
        </br></br>STAFF SUMMARY REPORT</span>


</div>
@if(isset($staff_summary) && !empty($staff_summary))


    <h5 style="text-align:center;padding-bottom:0px;margin-top:-18px;color:#000;font-weight:bolder;font-size:13px;">
        ARCHDIOCESE OF TRICHUR</h4>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>DESIGNATION</th>
                        <th>STAFF COUNT</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($staff_summary as $key => $data)
                        <tr>

                            <td>{{$data->designation_name}}</td>
                            <td>{{$data->total}}</td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
@endif
    </div>
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