@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Data Cuti</div>
                    <a href="{{ route('leave.create') }}" class="btn btn-success btn-sm">Tambah baru</a>
                </div>

                <div class="card-body">
                    @if(Auth::user()->id == 1)
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('leave_staf.index') }}" class="btn btn-primary">Kelola Cuti Staf</a>
                        </div>
                    </div>
                    @endif

                        @if (session('success'))
                            <div class="alert alert-success mt-4" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div style="margin-top: 24px;">
                            <table id="leave-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="30">No.</th>
                                    <th>Name</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Status</th>
                                    <th width="190">Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

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
        $('#leave-table_wrapper').removeClass('form-inline');
    });
    var table = $('#leave-table').dataTable({
                    processing: true,
                    serverSide: true,
                    ajax : "{{ route('api.leave') }}",
                    'columnDefs': [
                    {
                        "targets": 4,
                        "className": "text-center",
                    }],
                    columns: [
                        {data:'DT_RowIndex', name:'DT_RowIndex'},
                        {data:'name', name:'name'},
                        {data:'created_at', name:'created_at'},
                        {data:'status', name:'status'},
                        {data:'action', name:'action', orderable: false, searchable: false}
                    ]
                });

    
</script>
@endsection