@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Periode</div>
                </div>

                @if(isset($periode))
                {!! Form::model($periode,['route' => ['periode.update', $periode->id],
                'method'=>'put', "enctype"=>"multipart/form-data", "id"=>"form"]) !!}
                @else
                {!! Form::open(['route'=>'periode.store', "enctype"=>"multipart/form-data",
                "id"=>"form"]) !!}
                @endif
                <div class="card-body">
                    <div class="form-group {{ ($errors->has('name') ? 'has-error' : '') }}">
                        {{ Form::label('name', 'Nama periode', ['class' => 'control-label']) }}
                        {{ Form::text('name', ($action == 'edit') ? $periode->name : '', ['class' => 'form-control', 'placeholder' => 'Nama periode', 'required']) }}
                        <span class="help-block">{{ ($errors->has('name') ? $errors->first('name') : '') }}</span>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6 {{ ($errors->has('periode_start') ? 'has-error' : '') }}">
                            {{ Form::label('name', 'Periode Mulai', ['class' => 'control-label']) }}
                            {{ Form::text('periode_start', ($action == 'edit') ? $periode->periode_start : '', ['class' => 'form-control datepicker', 'placeholder' => 'Periode periode', 'required']) }}
                            <span class="help-block">{{ ($errors->has('periode_start') ? $errors->first('periode_start') : '') }}</span>
                        </div>
                        
                        <div class="form-group col-md-6 {{ ($errors->has('periode_end') ? 'has-error' : '') }}">
                            {{ Form::label('periode_end', 'Periode Akhir', ['class' => 'control-label']) }}
                            {{ Form::text('periode_end', ($action == 'edit') ? $periode->periode_end : '', ['class' => 'form-control datepicker', 'placeholder' => 'Periode akhir', 'required']) }}
                            <span class="help-block">{{ ($errors->has('periode_end') ? $errors->first('periode_end') : '') }}</span>
                        </div>
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