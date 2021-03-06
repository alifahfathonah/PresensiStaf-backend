@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Ajukan Sakit</div>
                </div>

                @if(isset($sick))
                {!! Form::model($sick,['route' => ['sick.update', $sick->id],
                'method'=>'put', "enctype"=>"multipart/form-data", "id"=>"form"]) !!}
                @else
                {!! Form::open(['route'=>'sick.store', "enctype"=>"multipart/form-data",
                "id"=>"form"]) !!}
                @endif
                <div class="card-body">
                    <div class="form-group {{ ($errors->has('users_id') ? 'has-error' : '') }}">
                        {{ Form::label('users_id', 'Staf', ['class' => 'control-label']) }}
                        @if(Auth::user()->id == 1)
                        {{ Form::select('users_id', App\User::pluck('name', 'id'), null, ['class' => 'form-control','placeholder' => 'Pilih Staf']) }}
                        @else
                        {{ Form::select('users_id', App\User::where('id', Auth::user()->id)->get()->pluck('name', 'id'), null, ['class' => 'form-control']) }}
                        @endif
                        <span class="help-block">{{ ($errors->has('users_id') ? $errors->first('users_id') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('date_sick') ? 'has-error' : '') }}">
                        {{ Form::label('date_sick', 'Tanggal Sakit', ['class' => 'control-label']) }}
                        @php
                        if($action == 'edit') {
                            $dateStart = json_decode($sick->date_sick);
                            $dateEnd = json_decode($sick->date_sick);
                        }
                        @endphp
                        @if($action == 'edit')
                        <input type="text" name="date_sick" class="daterange form-control" id="" value="{{ date('m/d/Y', strtotime(reset($dateStart))). ' - ' .date('m/d/Y', strtotime(end($dateEnd)))}}">
                        @else
                        {{ Form::text('date_sick', ($action == 'edit') ? $sick->date_sick : '', ['class' => 'daterange form-control', 'readonly' => 'readonly', 'placeholder' => 'Tanggal sakit', 'required']) }}
                        @endif
                        <span class="help-block">{{ ($errors->has('date_sick') ? $errors->first('date_sick') : '') }}</span>
                    </div>
                    @if(Auth::user()->id == 1)
                    <div class="form-group {{ ($errors->has('status') ? 'has-error' : '') }}">
                        {{ Form::label('status', 'Status', ['class' => 'control-label']) }}
                        <select class="form-control" name="status" id="status">
                            <option value="pending" {{ $action == 'edit' ? $sick->status == 'pending' ? 'selected' : '' : '' }}>Pending</option>
                            <option value="approved" {{ $action == 'edit' ? $sick->status == 'approved' ? 'selected' : '' : '' }}>Approved</option>
                            <option value="rejected" {{ $action == 'edit' ? $sick->status == 'rejected' ? 'selected' : '' : '' }}>Rejected</option>
                        </select>
                        <span class="help-block">{{ ($errors->has('status') ? $errors->first('status') : '') }}</span>
                    </div>
                    @else
                    <input type="hidden" name="status" value="pending">
                    @endif
                    <div class="form-group {{ ($errors->has('note') ? 'has-error' : '') }}">
                        {{ Form::label('note', 'Catatan', ['class' => 'control-label']) }}
                        {{ Form::textarea('note', ($action == 'edit') ? $sick->note : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Catatan sakit', 'required']) }}
                        <span class="help-block">{{ ($errors->has('note') ? $errors->first('note') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('foto') ? 'has-error' : '') }}">
                        {{ Form::label('foto', 'Foto', ['class' => 'control-label']) }}
                        {{ Form::file('foto', ['class' => 'form-control']) }}

                        <span class="help-block">{{ ($errors->has('foto') ? $errors->first('foto') : '') }}</span>
                        @if($action == 'edit' && $sick->foto !== null)
                        <span class="help-block">{{ ($errors->has('foto') ? $errors->first('foto') : 'Kosongkan bila tidak ingin mengganti foto') }}</span>
                            <div class="text-center mt-2">
                                <img src="{{ asset('foto/sick/' . $sick->foto) }}" style="height: 250px" alt="" srcset="">
                            </div>
                        @endif
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