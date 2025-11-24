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


<!-- Working days Table starts here -->
<div class="card">
    <h5 class="card-header">Sunday Catechism Summary Report</h5>
    <div class="table-responsive text-nowrap">
        <input type="hidden" id="search_token" name="search_token" value="{{ csrf_token() }}">
        <table id="example" class="table align-items-center mb-0" width="96% !important">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Forane name</th>
                    <th>Staff Count</th>
                    <th>Student Count</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($foranes_data as $ind => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    </td>
                    <td>{{$data->forane_name}}</td>
                    <td>{{$data->staff_count}}</td>
                    <td>{{$data->student_count}}</td>

                    <td><button class="btn btn-sm btn-primary" onclick="view_details({{$data->forane_code}})">View
                            Details</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!--/ Working days Table ends here-->

</div>


<script>
$(document).ready(function() {
    //$('#acc_no').focus();
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
        ],

        "columnDefs": [{
            "targets": 0,
            "orderable": false
        }],
        // initComplete: function () {
        //     var btns = $('.dt-button');
        //     btns.addClass('btn btn-success btn-sm');
        //     btns.css({
        //         "margin-left": "15px",
        //         "margin-top": "23px"
        //     });
        //     btns.removeClass('dt-button');

        // }
    });
});

// function view_details(id) {
//     //alert(id);
//     $.ajax({
//         type: 'POST',
//         url: "{{route('detail-summary')}}",
//         data: {
//             '_token': '<?php echo csrf_token() ?>',
//             'forane_id': id
//         },
//         success: function(data) {
//             var jsondata = $.parseJSON(data);
//             // console.log(json.message);
//             $("#msg").html(
//                 '<div class="row"><div class="alert alert-danger alert-dismissible text-white" role="alert"><span class="text-sm">' +
//                 jsondata.message +
//                 '</span><button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div> </div>'
//             );
//             window.location.reload();
//         }
//     });
// }
</script>
@endsection