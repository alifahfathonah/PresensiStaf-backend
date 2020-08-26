@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Kelola Cuti Staf</div>
                </div>

                @if(isset($leaveStaf))
                {!! Form::model($leaveStaf,['route' => ['leave_staf.update', $leaveStaf->id],
                'method'=>'put', "enctype"=>"multipart/form-data", "id"=>"form"]) !!}
                @else
                {!! Form::open(['route'=>'leave_staf.store', "enctype"=>"multipart/form-data",
                "id"=>"form"]) !!}
                @endif
                <div class="card-body">
                    <div class="form-group {{ ($errors->has('users_id') ? 'has-error' : '') }}">
                        {{ Form::label('users_id', 'Staf', ['class' => 'control-label']) }}
                        {{ Form::select('users_id', App\User::pluck('name', 'id'), null, ['class' => 'form-control','placeholder' => 'Pilih Staf']) }}
                        <span class="help-block">{{ ($errors->has('users_id') ? $errors->first('users_id') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('periode_id') ? 'has-error' : '') }}">
                        {{ Form::label('periode_id', 'Periode', ['class' => 'control-label']) }}
                        {{ Form::select('periode_id', App\Periode::pluck('name', 'id'), null, ['class' => 'form-control','placeholder' => 'Pilih Periode']) }}
                        <span class="help-block">{{ ($errors->has('periode_id') ? $errors->first('periode_id') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('balance') ? 'has-error' : '') }}">
                        {{ Form::label('balance', 'Balance', ['class' => 'control-label']) }}
                        {{ Form::number('balance', ($action == 'edit') ? $leaveStaf->balance : '', ['class' => 'form-control', 'placeholder' => '', 'required', 'onkeypress' => 'if ( isNaN( String.fromCharCode(event.keyCode) )) return false;']) }}
                        <span class="help-block">{{ ($errors->has('balance') ? $errors->first('balance') : '') }}</span>
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
    $('.daterange').daterangepicker({
        // minDate: moment(),
        minDate: moment().subtract(29, 'days'),
        maxDate: moment().add('1', 'days'),
        opens: 'right'
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    // $('.daterange').on('apply.daterangepicker', function(ev, picker) {
    //     $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    // });
});
</script>
@endsection