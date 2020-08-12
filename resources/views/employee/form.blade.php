@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Tambah Staf</div>
                </div>
                @if(isset($mitra))
                {!! Form::model($mitra,['route' => ['employee.put', $mitra->id_kyc_mitras],
                'method'=>'put', "enctype"=>"multipart/form-data", "id"=>"form"]) !!}
                @else
                {!! Form::open(['route'=>'employee.post', "enctype"=>"multipart/form-data",
                "id"=>"form"]) !!}
                @endif
                <div class="card-body">
                    <div class="form-group {{ ($errors->has('name') ? 'has-error' : '') }}">
                        {{ Form::label('name', 'Nama lengkap', ['class' => 'control-label']) }}
                        {{ Form::text('name', ($action == 'edit') ? $user->name : '', ['class' => 'form-control', 'placeholder' => 'Nama karyawan', 'required']) }}
                        <span class="help-block">{{ ($errors->has('name') ? $errors->first('name') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('nick_name') ? 'has-error' : '') }}">
                        {{ Form::label('nick_name', 'Nama panggilan', ['class' => 'control-label']) }}
                        {{ Form::text('nick_name', ($action == 'edit') ? $user->nick_name : '', ['class' => 'form-control', 'placeholder' => 'Nama panggilan', 'required']) }}
                        <span class="help-block">{{ ($errors->has('nick_name') ? $errors->first('nick_name') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('birth_city') ? 'has-error' : '') }}">
                        {{ Form::label('birth_city', 'Kota kelahiran', ['class' => 'control-label']) }}
                        {{ Form::text('birth_city', ($action == 'edit') ? $user->birth_city : '', ['class' => 'form-control', 'placeholder' => 'Kota kelahiran', 'required']) }}
                        <span class="help-block">{{ ($errors->has('birth_city') ? $errors->first('birth_city') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('birth_date') ? 'has-error' : '') }}">
                        {{ Form::label('birth_date', 'Tanggal lahir', ['class' => 'control-label']) }}
                        {{ Form::text('birth_date', ($action == 'edit') ? $user->birth_date : '', ['class' => 'dob form-control', 'readonly' => 'readonly', 'placeholder' => 'Tanggal kelahiran', 'required']) }}
                        <span class="help-block">{{ ($errors->has('birth_date') ? $errors->first('birth_date') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('address') ? 'has-error' : '') }}">
                        {{ Form::label('address', 'Alamat lengkap', ['class' => 'control-label']) }}
                        {{ Form::textarea('address', ($action == 'edit') ? $user->address : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Alamat lengkap', 'required']) }}
                        <span class="help-block">{{ ($errors->has('address') ? $errors->first('address') : '') }}</span>
                    </div>
                    <div class="d-flex">
                        <div class="col-6 form-group {{ ($errors->has('address_city') ? 'has-error' : '') }}">
                            {{ Form::label('address_city', 'Tinggal di kota', ['class' => 'control-label']) }}
                            {{ Form::text('address_city', ($action == 'edit') ? $user->address_city : '', ['class' => 'form-control', 'placeholder' => 'Tinggal di kota', 'required']) }}
                            <span class="help-block">{{ ($errors->has('address_city') ? $errors->first('address_city') : '') }}</span>
                        </div>
                        <div class="col-6 form-group {{ ($errors->has('address_postal_code') ? 'has-error' : '') }}">
                            {{ Form::label('address_postal_code', 'Kode POS', ['class' => 'control-label']) }}
                            {{ Form::text('address_postal_code', ($action == 'edit') ? $user->address_postal_code : '', ['class' => 'form-control', 'id' => 'intOnly6', 'placeholder' => 'Kode POS', 'required']) }}
                            <span class="help-block">{{ ($errors->has('address_postal_code') ? $errors->first('address_postal_code') : '') }}</span>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="col-4 form-group {{ ($errors->has('phone_home') ? 'has-error' : '') }}">
                            {{ Form::label('phone_home', 'Telp. Rumah', ['class' => 'control-label']) }}
                            {{ Form::text('phone_home', ($action == 'edit') ? $user->phone_home : '', ['class' => 'form-control', 'id' => 'intOnly9', 'placeholder' => 'Telp. Rumah', 'required']) }}
                            <span class="help-block">{{ ($errors->has('phone_home') ? $errors->first('phone_home') : '') }}</span>
                        </div>
                        <div class="col-4 form-group {{ ($errors->has('address_postal_code') ? 'has-error' : '') }}">
                            {{ Form::label('phone_mobile', 'No. Handphone', ['class' => 'control-label']) }}
                            {{ Form::text('phone_mobile', ($action == 'edit') ? $user->phone_mobile : '', ['class' => 'form-control', 'id' => 'intOnly13', 'placeholder' => 'Telp. Handphone', 'required']) }}
                            <span class="help-block">{{ ($errors->has('phone_mobile') ? $errors->first('phone_mobile') : '') }}</span>
                        </div>
                        <div class="col-4 form-group {{ ($errors->has('phone_office') ? 'has-error' : '') }}">
                            {{ Form::label('phone_office', 'Telp. Kantor', ['class' => 'control-label']) }}
                            {{ Form::text('phone_office', ($action == 'edit') ? $user->phone_office : '', ['class' => 'form-control', 'id' => 'intOnly9Office', 'placeholder' => 'Telp. Kantor', 'required']) }}
                            <span class="help-block">{{ ($errors->has('phone_office') ? $errors->first('phone_office') : '') }}</span>
                        </div>
                    </div>
                    <div class="form-group {{ ($errors->has('email') ? 'has-error' : '') }}">
                        {{ Form::label('email', 'Email', ['class' => 'control-label']) }}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            {{ Form::email('email', ($action == 'edit') ? $user->email : '', ['class' => 'form-control', 'placeholder' => '', 'required']) }}
                        </div>
                        <span class="help-block">{{ ($errors->has('email') ? $errors->first('email') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('religion') ? 'has-error' : '') }}">
                        {{ Form::label('religion', 'Agama', ['class' => 'control-label']) }}
                        <div class="d-flex align-items-center">
                            {{ Form::radio('religion', 'Islam', false, ['class' => 'mr-2']) }} <span class="mr-2">Islam</span>
                            {{ Form::radio('religion', 'Katholik', false, ['class' => 'mr-2']) }} <span class="mr-2">Katholik</span>
                            {{ Form::radio('religion', 'Kristen', false, ['class' => 'mr-2']) }} <span class="mr-2">Kristen</span>
                            {{ Form::radio('religion', 'Budha', false, ['class' => 'mr-2']) }} <span class="mr-2">Budha</span>
                            {{ Form::radio('religion', 'Hindu', false, ['class' => 'mr-2']) }} <span class="mr-2">Hindu</span>
                        </div>
                        <span class="help-block">{{ ($errors->has('religion') ? $errors->first('religion') : '') }}</span>
                    </div>
                    
                    <div class="form-group {{ ($errors->has('card_identity_number') ? 'has-error' : '') }}">
                        {{ Form::label('card_identity_number', 'No. KTP', ['class' => 'control-label']) }}
                        {{ Form::text('card_identity_number', ($action == 'edit') ? $user->card_identity_number : '', ['class' => 'form-control', 'id' => 'intOnly16', 'placeholder' => 'No. KTP', 'required']) }}
                        <span class="help-block">{{ ($errors->has('card_identity_number') ? $errors->first('card_identity_number') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('number_of_siblings') ? 'has-error' : '') }}">
                        {{ Form::label('number_of_siblings', 'Anak Ke', ['class' => 'control-label']) }}
                        {{ Form::text('number_of_siblings', ($action == 'edit') ? $user->number_of_siblings : '', ['class' => 'form-control', 'id' => 'intOnly2', 'placeholder' => 'Anak Ke ..', 'required']) }}
                        <span class="help-block">{{ ($errors->has('number_of_siblings') ? $errors->first('number_of_siblings') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('status') ? 'has-error' : '') }}">
                        {{ Form::label('status', 'Status', ['class' => 'control-label']) }}
                        <div class="d-flex align-items-center">
                            {{ Form::radio('status', 'Menikah', false, ['class' => 'mr-2']) }} <span class="mr-2">Menikah</span>
                            {{ Form::radio('status', 'Belum Menikah', false, ['class' => 'mr-2']) }} <span class="mr-2">Belum Menikah</span>
                            {{ Form::radio('status', 'Janda', false, ['class' => 'mr-2']) }} <span class="mr-2">Janda</span>
                            {{ Form::radio('status', 'Duda', false, ['class' => 'mr-2']) }} <span class="mr-2">Duda</span>
                        </div>
                        <span class="help-block">{{ ($errors->has('status') ? $errors->first('status') : '') }}</span>
                    </div>
                    <div id="isNotSingle">
                        <div class="form-group {{ ($errors->has('nama_istri_suami') ? 'has-error' : '') }}">
                            {{ Form::label('nama_istri_suami', 'Nama Istri / Suami', ['class' => 'control-label']) }}
                            {{ Form::text('nama_istri_suami', ($action == 'edit') ? $user->nama_istri_suami : '', ['class' => 'form-control', 'placeholder' => 'Nama Istri / Suami', 'required']) }}
                            <span class="help-block">{{ ($errors->has('nama_istri_suami') ? $errors->first('nama_istri_suami') : '') }}</span>
                        </div>
                        <div class="form-group {{ ($errors->has('pekerjaan_istri_suami') ? 'has-error' : '') }}">
                            {{ Form::label('pekerjaan_istri_suami', 'Pekerjaan Istri / Suami', ['class' => 'control-label']) }}
                            {{ Form::text('pekerjaan_istri_suami', ($action == 'edit') ? $user->pekerjaan_istri_suami : '', ['class' => 'form-control', 'placeholder' => 'Pekerjaan Istri / Suami', 'required']) }}
                            <span class="help-block">{{ ($errors->has('pekerjaan_istri_suami') ? $errors->first('pekerjaan_istri_suami') : '') }}</span>
                        </div>
                        <div class="form-group {{ ($errors->has('jumlah_anak') ? 'has-error' : '') }}">
                            {{ Form::label('jumlah_anak', 'Jumlah Anak', ['class' => 'control-label']) }}
                            {{ Form::text('jumlah_anak', ($action == 'edit') ? $user->jumlah_anak : '', ['class' => 'form-control', 'id' => 'intOnly2Anak', 'placeholder' => 'Jumlah Anak', 'required']) }}
                            <span class="help-block">{{ ($errors->has('jumlah_anak') ? $errors->first('jumlah_anak') : '') }}</span>
                        </div>
                    </div>
                    <div class="form-group form-anak {{ ($errors->has('anak') ? 'has-error' : '') }}">
                        {{ Form::label('anak', 'Keterangan Anak', ['class' => 'control-label']) }}
                        <div class="form-anak-dynamic d-flex">
                            <div class="form-group col-3">
                                {{ Form::label('anak', 'Nama anak', ['class' => 'control-label']) }}
                                <input class="form-control" type="text" name="anak[]" id="">
                            </div>
                            <div class="form-group col-3">
                                {{ Form::label('anak', 'Jenis Kelamin', ['class' => 'control-label']) }}
                                <select class="form-control" name="anak[]" id="">
                                    <option value="l">L</option>
                                    <option value="p">P</option>
                                </select>
                            </div>
                            <div class="form-group col-3">
                                {{ Form::label('anak', 'Tanggal lahir', ['class' => 'control-label']) }}
                                <input class="dob form-control" type="text" name="anak[]" id="" readonly>
                            </div>
                            <div class="form-group col-3">
                                {{ Form::label('anak', 'Pekerjaan / Pendidikan', ['class' => 'control-label']) }}
                                <input class="form-control" type="text" name="anak[]" id="">
                            </div>
                        </div>
                        <div class="add-anak">
                            
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <div class="mr-auto">
                        
                    </div>
                    {{ Form::submit(($action == 'create') ? 'Tambahkan Data' : 'Simpan Data', ['class' => 'btn btn-primary']) }}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $('#intOnly2Anak').val(0);
    $('.form-anak').hide();

    $('input[type=radio][name=status]').change(function(){
        if (this.value == 'Belum Menikah') {
            $('#isNotSingle').hide();
            $('#isNotSingle').find('input[type=text]').removeAttr('required');
            $('#intOnly2Anak').val(0);
            $('.add-anak').html('');
        } else {
            $('#isNotSingle').show();
            $('#isNotSingle input[type=text]').each(function() {
                $(this).attr('required', true);
            });
        }
        $('#intOnly2Anak').keyup();
    });

    $('#intOnly2Anak').keyup(function(){
        if(this.value > 0){
            $('.form-anak').show();
            showFormDataAnak();
        } else {
            $('.form-anak').hide();
            $('.add-anak').html('');
        }
    });

    function showFormDataAnak(){

        const html = `<div class="form-anak-dynamic d-flex">
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Nama anak</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Jenis Kelamin</label>
                            <select class="form-control" name="anak[]" id="">
                                <option value="l">L</option>
                                <option value="p">P</option>
                            </select>
                        </div>
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Tanggal lahir</label>
                            <input class="dob form-control" type="text" name="anak[]" id="" readonly="">
                        </div>
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Pekerjaan / Pendidikan</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                    </div>`;

        $('.add-anak').html('');
        for(var i = 1;i < $('#intOnly2Anak').val();i++){
            $('.add-anak').append(html);
        }
    }
</script>
@endsection