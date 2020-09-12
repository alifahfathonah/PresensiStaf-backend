@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Data Presensi</div>
                    <a href="{{ route('presensi.recap') }}" class="btn btn-success btn-sm">Rekap Presensi</a>
                </div>

                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table id="presensi-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="30">No.</th>
                            <th>Name</th>
                            <th>Start</th>
                            <th>End</th>
                            {{-- <th>Hours</th> --}}
                            <th>Status</th>
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

<script>
    $(document).ready(function() {
        $('#presensi-table_wrapper').removeClass('form-inline');
    });
    var table = $('#presensi-table').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax : "{{ route('api.presensi') }}",
                    'columnDefs': [
                    {
                        "targets": 4,
                        "className": "text-center",
                    }],
                    columns: [
                        {data:'DT_RowIndex', name:'DT_RowIndex'},
                        {data:'name', name:'name'},
                        {data:'start', name:'start'},
                        {data:'end', name:'end'},
                        // {data:'hours', name:'hours'},
                        {data:'status', name:'status'},
                    ]
                });

    
</script>
@endsection