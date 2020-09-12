@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Data Rekap Presensi</div>
                </div>

                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <button class="btn btn-default" id="attendance_filter">
                        <span>
                            <i class="fa fa-calendar"></i> Today
                        </span>
                        <i class="fa fa-caret-down"></i>
                    </button>

                    <table id="presensi-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            {{-- <th width="30">No.</th> --}}
                            <th>Name</th>
                            <th>J_Hadir</th>
                            <th>J_T Hadir</th>
                            <th>J_Sakit</th>
                            <th>J_Izin</th>
                            <th>J_Cuti</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    $(document).ready(function() {
        $('#presensi-table_wrapper').removeClass('form-inline');
        
        $('#attendance_filter').daterangepicker(
            {
                ranges   : {
                    // 'Today'       : [moment(), moment()],
                    // 'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    // 'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    // 'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().subtract(1, 'month').startOf('month').add(14, 'days'), moment().startOf('month').add(14, 'days')],
                    'Last Month'  : [moment().subtract(2, 'month').startOf('month').add(14, 'days'), moment().subtract(1, 'month').startOf('month').add(14, 'days')]
                },
                startDate: moment().subtract(1, 'month').startOf('month').add(14, 'days'),
                endDate  : moment().startOf('month').add(14, 'days'),
                opens: "left"
            },
            function (start, end) {
                $('#attendance_filter span').html(start.format('YYYY-MM-DD') + ' ~ ' + end.format('YYYY-MM-DD'));
                console.log(start.format('YYYY-MM-DD') + ' ~ ' + end.format('YYYY-MM-DD'));
                table_presensi.api().ajax.reload();
            }
        );


        var table_presensi = $('#presensi-table').dataTable({
                    processing: true,
                    // serverSide: true,
                        ajax : {
                            "url": "{{ route('api.presensi.recap') }}",
                            data: function (d) {
                                var start = $('#attendance_filter').data('daterangepicker').startDate.format('YYYY-MM-DD');
                                var end = $('#attendance_filter').data('daterangepicker').endDate.format('YYYY-MM-DD');
                                d.start = start;
                                d.end = end;
                            }
                        },
                        'columnDefs': [
                        {
                            "targets": 4,
                            "className": "text-center",
                        }],
                        columns: [
                            // {data:'DT_RowIndex', name:'DT_RowIndex'},
                            {data:'full_name', name:'full_name'},
                            {data:'present_full_time', name:'present_full_time'},
                            {data:'not_present', name:'not_present'},
                            {data:'sick_present', name:'sick_present'},
                            {data:'permit_present', name:'permit_present'},
                            {data:'leave_present', name:'leave_present'},
                        ]
                    });

    });
    

    
</script>
@endsection