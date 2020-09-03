@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Form Schedule</div>
                </div>

                @if(isset($schedule))
                {!! Form::model($schedule,['route' => ['schedule.update', $user->id, $schedule->id],
                'method'=>'put', "enctype"=>"multipart/form-data", "id"=>"form"]) !!}
                @else
                {!! Form::open(['route'=>['schedule.store', $user->id], "enctype"=>"multipart/form-data",
                "id"=>"form"]) !!}
                @endif
                <div class="card-body">
                    <div class="form-group {{ ($errors->has('days_id') ? 'has-error' : '') }}">
                        {{ Form::label('days_id', 'Hari', ['class' => 'control-label']) }}
                        {{-- {{ Form::select('days_id', App\Days::pluck('name_day', 'id'), null, ['class' => 'form-control','placeholder' => 'Pilih Hari']) }} --}}
                        <select class="form-control" name="days_id" id="days_id">
                            <option value="1" {{ $action == 'edit' ? $schedule->days_id == '1' ? 'selected' : '' : '' }}>Senin</option>
                            <option value="2" {{ $action == 'edit' ? $schedule->days_id == '2' ? 'selected' : '' : '' }}>Selasa</option>
                            <option value="3" {{ $action == 'edit' ? $schedule->days_id == '3' ? 'selected' : '' : '' }}>Rabu</option>
                            <option value="4" {{ $action == 'edit' ? $schedule->days_id == '4' ? 'selected' : '' : '' }}>Kamis</option>
                            <option value="5" {{ $action == 'edit' ? $schedule->days_id == '5' ? 'selected' : '' : '' }}>Jumat</option>
                            <option value="6" {{ $action == 'edit' ? $schedule->days_id == '6' ? 'selected' : '' : '' }}>Sabtu</option>
                        </select>
                        <span class="help-block">{{ ($errors->has('days_id') ? $errors->first('days_id') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('clock_in') ? 'has-error' : '') }}">
                        {{ Form::label('clock_in', 'Clock In', ['class' => 'control-label']) }}
                        <div class="input-group clockpicker">
                            {{-- <input type="text" class="form-control" value="09:30"> --}}
                            {{ Form::text('clock_in', ($action == 'edit') ? $schedule->clock_in : '', ['class' => 'form-control', 'placeholder' => 'Clock In', 'required', 'readonly']) }}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group {{ ($errors->has('clock_out') ? 'has-error' : '') }}">
                        {{ Form::label('clock_out', 'Clock Out', ['class' => 'control-label']) }}
                        <div class="input-group clockpicker">
                            {{-- <input type="text" class="form-control" value="09:30"> --}}
                            {{ Form::text('clock_out', ($action == 'edit') ? $schedule->clock_out : '', ['class' => 'form-control', 'placeholder' => 'Clock Out', 'required', 'readonly']) }}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
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