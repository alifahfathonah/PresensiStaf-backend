@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Ajukan Izin</div>
                </div>

                @if(isset($permit))
                {!! Form::model($permit,['route' => ['permit.update', $permit->id],
                'method'=>'put', "enctype"=>"multipart/form-data", "id"=>"form"]) !!}
                @else
                {!! Form::open(['route'=>'permit.store', "enctype"=>"multipart/form-data",
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
                    <div class="form-group {{ ($errors->has('type_permit') ? 'has-error' : '') }}">
                        {{ Form::label('type_permit', 'Tipe Izin', ['class' => 'control-label']) }}
                        <select class="form-control" name="type_permit" id="type_permit">
                            <option value="akademis" {{ $action == 'edit' ? $permit->type_permit == 'akademis' ? 'selected' : '' : '' }}>Akademis</option>
                            <option value="khusus" {{ $action == 'edit' ? $permit->type_permit == 'khusus' ? 'selected' : '' : '' }}>Khusus</option>
                        </select>
                        <span class="help-block">{{ ($errors->has('type_permit') ? $errors->first('type_permit') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('date_permit') ? 'has-error' : '') }}">
                        {{ Form::label('date_permit', 'Tanggal Izin', ['class' => 'control-label']) }}
                        @php
                        if($action == 'edit') {
                            $date = json_decode($permit->date_permit);
                            // $dateEnd = json_decode($permit->date_permit);
                            $datePermit = '';
                            for ($i=0; $i < count($date); $i++) {
                                // echo $date[$i];
                                $datePermit .= $i == 0 ? $date[$i] : ','.$date[$i];
                            }
                        }
                        @endphp
                        @if($action == 'edit')
                        <input type="text" name="date_permit" class="datepicker-permit form-control" id="" value="{{ $datePermit }}">
                        @else
                        {{ Form::text('date_permit', ($action == 'edit') ? $permit->date_permit : '', ['class' => 'datepicker-permit form-control', 'readonly' => 'readonly', 'placeholder' => 'Tanggal sakit', 'required']) }}
                        @endif
                        <span class="help-block">{{ ($errors->has('date_permit') ? $errors->first('date_permit') : '') }}</span>
                        <span class="help-block msg-maxdate text-danger mt-2"></span>
                    </div>
                    @if(Auth::user()->id == 1)
                    <div class="form-group {{ ($errors->has('status') ? 'has-error' : '') }}">
                        {{ Form::label('status', 'Status', ['class' => 'control-label']) }}
                        <select class="form-control" name="status" id="status">
                            <option value="pending" {{ $action == 'edit' ? $permit->status == 'pending' ? 'selected' : '' : '' }}>Pending</option>
                            <option value="approved" {{ $action == 'edit' ? $permit->status == 'approved' ? 'selected' : '' : '' }}>Approved</option>
                            <option value="rejected" {{ $action == 'edit' ? $permit->status == 'rejected' ? 'selected' : '' : '' }}>Rejected</option>
                        </select>
                        <span class="help-block">{{ ($errors->has('status') ? $errors->first('status') : '') }}</span>
                    </div>
                    @else
                    <input type="hidden" name="status" value="pending">
                    @endif

                    <div class="form-group foto-izin {{ ($errors->has('foto') ? 'has-error' : '') }}">
                        {{ Form::label('foto', 'Foto Bukti', ['class' => 'control-label']) }}
                        {{ Form::file('foto', ['class' => 'form-control']) }}

                        <span class="help-block">{{ ($errors->has('foto') ? $errors->first('foto') : '') }}</span>
                        @if($action == 'edit' && $permit->foto !== null)
                        <span class="help-block">{{ ($errors->has('foto') ? $errors->first('foto') : 'Kosongkan bila tidak ingin mengganti foto') }}</span>
                            <div class="text-center mt-2 col-md-6">
                                <img src="{{ asset('foto/izin/' . $permit->foto) }}" style="height: 250px" alt="" srcset="">
                            </div>
                        @endif
                    </div>
                    <div class="form-group {{ ($errors->has('note') ? 'has-error' : '') }}">
                        {{ Form::label('note', 'Catatan', ['class' => 'control-label']) }}
                        {{ Form::textarea('note', ($action == 'edit') ? $permit->note : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Catatan izin', 'required']) }}
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
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    @if($action == 'edit')
    setTimeout(() => {
        @if($permit->type_permit == 'akademis')
        $('.foto-izin').show();
        @else
        $('.foto-izin').hide();
        @endif
    }, 500)
    @endif

setDatePicker();
    
    $('[name=type_permit]').change(function(){
        $('.datepicker-permit').click();
        $('.clear').click();
        $('.datepicker-permit').val('');

        console.warn('si');
        
        if($(this).val() == 'akademis'){
            $('.foto-izin').show();
        } else {
            $('.foto-izin').hide();
        }
        $(".datepicker-permit").datepicker('update');
    });
});


    function setDatePicker(){
        $(".datepicker-permit").datepicker({
            format: "yyyy-mm-dd",
            multidate: 10,
            daysOfWeekDisabled: [0, 6],
            clearBtn: true,
            todayHighlight: true,
            // daysOfWeekHighlighted: [1, 2, 3, 4, 5]
        }).attr("readonly", "readonly").css({"cursor":"pointer", "background":"white"})
        .on("changeDate", function(evt){
            var length = $("[name=date_permit]").val().split(",").length
    
            if(length > 2 && $('[name=type_permit]').val() == 'khusus'){
                $('.msg-maxdate').html('Maksimal 2 hari Untuk izin Khusus');
                $(':input[type="submit"]').prop('disabled', true);
            } else {
                $('.msg-maxdate').html('');
                $(':input[type="submit"]').prop('disabled', false);
            }
        });
    }
</script>
@endsection