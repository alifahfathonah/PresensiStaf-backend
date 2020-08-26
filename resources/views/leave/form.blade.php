@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Ajukan Cuti</div>
                </div>

                @if(isset($leave))
                {!! Form::model($leave,['route' => ['leave.update', $leave->id],
                'method'=>'put', "enctype"=>"multipart/form-data", "id"=>"form"]) !!}
                @else
                {!! Form::open(['route'=>'leave.store', "enctype"=>"multipart/form-data",
                "id"=>"form"]) !!}
                @endif
                <div class="card-body">
                    <div class="form-group {{ ($errors->has('users_id') ? 'has-error' : '') }}">
                        {{ Form::label('users_id', 'Staf', ['class' => 'control-label']) }}
                        {{ Form::select('users_id', App\LeaveStaf::with('users')->get()->pluck('users.name', 'users.id'), null, ['class' => 'form-control','placeholder' => 'Pilih Staf']) }}
                        <span class="help-block">{{ ($errors->has('users_id') ? $errors->first('users_id') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('periode_id') ? 'has-error' : '') }}">
                        {{ Form::label('periode_id', 'Periode', ['class' => 'control-label']) }}
                        {{ Form::select('periode_id', App\LeaveStaf::with(['periode', 'users'])->get()->pluck('periode.name', 'periode.id'), null, ['class' => 'form-control','placeholder' => 'Pilih Periode']) }}
                        <span class="help-block">{{ ($errors->has('periode_id') ? $errors->first('periode_id') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('date_leave') ? 'has-error' : '') }}">
                        {{ Form::label('date_leave', 'Tanggal Cuti', ['class' => 'control-label']) }}
                        @php
                        if($action == 'edit') {
                            $dateStart = json_decode($leave->date_leave);
                            $dateEnd = json_decode($leave->date_leave);
                        }
                        @endphp
                        @if($action == 'edit')
                        <input type="text" name="date_leave" class="daterange form-control" id="" value="{{ date('m/d/Y', strtotime(reset($dateStart))). ' - ' .date('m/d/Y', strtotime(end($dateEnd)))}}">
                        @else
                        {{ Form::text('date_leave', ($action == 'edit') ? $leave->date_leave : '', ['class' => 'daterange form-control', 'readonly' => 'readonly', 'placeholder' => 'Tanggal sakit', 'required']) }}
                        @endif
                        <span class="help-block">{{ ($errors->has('date_leave') ? $errors->first('date_leave') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('status') ? 'has-error' : '') }}">
                        {{ Form::label('status', 'Status', ['class' => 'control-label']) }}
                        <select class="form-control" name="status" id="status">
                            <option value="pending" {{ $action == 'edit' ? $leave->status == 'pending' ? 'selected' : '' : '' }}>Pending</option>
                            <option value="approved" {{ $action == 'edit' ? $leave->status == 'approved' ? 'selected' : '' : '' }}>Approved</option>
                            <option value="rejected" {{ $action == 'edit' ? $leave->status == 'rejected' ? 'selected' : '' : '' }}>Rejected</option>
                        </select>
                        <span class="help-block">{{ ($errors->has('status') ? $errors->first('status') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('note') ? 'has-error' : '') }}">
                        {{ Form::label('note', 'Catatan', ['class' => 'control-label']) }}
                        {{ Form::textarea('note', ($action == 'edit') ? $leave->note : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Catatan sakit', 'required']) }}
                        <span class="help-block">{{ ($errors->has('note') ? $errors->first('note') : '') }}</span>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <div>
                        {{ Form::submit(($action == 'create') ? 'Tambahkan Data' : 'Simpan Data', ['class' => 'btn btn-primary']) }}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
$(function() {
    @if($action == 'create')
        $("[name=periode_id]").html("");
    @endif

    $('.daterange').daterangepicker({
        // minDate: moment(),
        minDate: moment().subtract(29, 'days'),
        maxDate: moment().add('1', 'days'),
        opens: 'right'
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var request;
    $('[name=users_id]').change(function(){
        if($(this).val() != 0) {
            request = $.ajax({
                url: "/api/getPeriodeByUsers",
                type: "post",
                data: {users_id: Number($(this).val())}
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR){
                const {data} = response;
                $("[name=periode_id]").html("");
                $.each(data, function(key,item){
                    $("[name=periode_id]").append(new Option(item.name, item.id));
                })
            });
        }

    })
});
</script>
@endsection