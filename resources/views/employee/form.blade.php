@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-10">
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
                <div class="card-body active-page-1">
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
                        <div class="col-4 form-group {{ ($errors->has('phone_mobile') ? 'has-error' : '') }}">
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
                    <div class="form-group">
                        {{ Form::label('label', 'Bila terjadi sesuatu pada diri Anda, kami dapat menghubungi:', ['class' => 'control-label']) }}
                    </div>
                    <div class="form-group {{ ($errors->has('nama_darurat') ? 'has-error' : '') }}">
                        {{ Form::label('nama_darurat', 'Nama', ['class' => 'control-label']) }}
                        {{ Form::text('nama_darurat', ($action == 'edit') ? $user->nama_darurat : '', ['class' => 'form-control', 'placeholder' => 'Nama kerabat', 'required']) }}
                        <span class="help-block">{{ ($errors->has('nama_darurat') ? $errors->first('nama_darurat') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('address_darurat') ? 'has-error' : '') }}">
                        {{ Form::label('address_darurat', 'Alamat lengkap', ['class' => 'control-label']) }}
                        {{ Form::textarea('address_darurat', ($action == 'edit') ? $user->address_darurat : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Alamat kerabat', 'required']) }}
                        <span class="help-block">{{ ($errors->has('address_darurat') ? $errors->first('address_darurat') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('tlp_darurat') ? 'has-error' : '') }}">
                        {{ Form::label('tlp_darurat', 'No. Telp', ['class' => 'control-label']) }}
                        {{ Form::text('tlp_darurat', ($action == 'edit') ? $user->tlp_darurat : '', ['class' => 'form-control', 'onkeypress' => 'if ( isNaN( String.fromCharCode(event.keyCode) )) return false;', 'placeholder' => 'Telp. kerabat', 'required']) }}
                        <span class="help-block">{{ ($errors->has('phone_mobile') ? $errors->first('tlp_darurat') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('nama_ayah') ? 'has-error' : '') }}">
                        {{ Form::label('nama_ayah', 'Nama Ayah', ['class' => 'control-label']) }}
                        {{ Form::text('nama_ayah', ($action == 'edit') ? $user->nama_ayah : '', ['class' => 'form-control', 'placeholder' => 'Nama ayah', 'required']) }}
                        <span class="help-block">{{ ($errors->has('nama_ayah') ? $errors->first('nama_ayah') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('pekerjaan_ayah') ? 'has-error' : '') }}">
                        {{ Form::label('pekerjaan_ayah', 'Pekerjaan', ['class' => 'control-label']) }}
                        {{ Form::text('pekerjaan_ayah', ($action == 'edit') ? $user->pekerjaan_ayah : '', ['class' => 'form-control', 'placeholder' => 'Pekerjaan ayah', 'required']) }}
                        <span class="help-block">{{ ($errors->has('pekerjaan_ayah') ? $errors->first('pekerjaan_ayah') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('alamat_ayah') ? 'has-error' : '') }}">
                        {{ Form::label('alamat_ayah', 'Alamat lengkap', ['class' => 'control-label']) }}
                        {{ Form::textarea('alamat_ayah', ($action == 'edit') ? $user->alamat_ayah : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Alamat tinggal ayah', 'required']) }}
                        <span class="help-block">{{ ($errors->has('alamat_ayah') ? $errors->first('alamat_ayah') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('nama_ibu') ? 'has-error' : '') }}">
                        {{ Form::label('nama_ibu', 'Nama Ibu', ['class' => 'control-label']) }}
                        {{ Form::text('nama_ibu', ($action == 'edit') ? $user->nama_ibu : '', ['class' => 'form-control', 'placeholder' => 'Nama ibu', 'required']) }}
                        <span class="help-block">{{ ($errors->has('nama_ibu') ? $errors->first('nama_ibu') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('pekerjaan_ibu') ? 'has-error' : '') }}">
                        {{ Form::label('pekerjaan_ibu', 'Pekerjaan', ['class' => 'control-label']) }}
                        {{ Form::text('pekerjaan_ibu', ($action == 'edit') ? $user->pekerjaan_ibu : '', ['class' => 'form-control', 'placeholder' => 'Pekerjaan ibu', 'required']) }}
                        <span class="help-block">{{ ($errors->has('pekerjaan_ibu') ? $errors->first('pekerjaan_ibu') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('alamat_ibu') ? 'has-error' : '') }}">
                        {{ Form::label('alamat_ibu', 'Alamat lengkap', ['class' => 'control-label']) }}
                        {{ Form::textarea('alamat_ibu', ($action == 'edit') ? $user->alamat_ibu : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Alamat tinggal ibu', 'required']) }}
                        <span class="help-block">{{ ($errors->has('alamat_ibu') ? $errors->first('alamat_ibu') : '') }}</span>
                    </div>
                </div>
                {{-- page 1 --}}
                <div class="card-body active-page-2">
                    <h4>Pendidikan Formal</h4>
                    <hr>
                    <div class="d-flex">
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Pendidikan</label>
                            <label for="anak" class="control-label">Sekolah Dasar</label>
                            <input class="form-control" type="hidden" name="anak[]" id="" value="Sekolah Dasar">
                        </div>
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Nama sekolah</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-4">
                            <label for="anak" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="anak" class="control-label">Tahun Lulus</label>
                            <input class="form-control" type="text" name="anak[]"  onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Pendidikan</label>
                            <br>
                            <label for="anak" class="control-label">SMP</label>
                            <input class="form-control" type="hidden" name="anak[]" id="" value="Sekolah Dasar">
                        </div>
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Nama sekolah</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-4">
                            <label for="anak" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="anak" class="control-label">Tahun Lulus</label>
                            <input class="form-control" type="text" name="anak[]"  onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Pendidikan</label>
                            <br>
                            <label for="anak" class="control-label">SLTA</label>
                            <input class="form-control" type="hidden" name="anak[]" id="" value="Sekolah Dasar">
                        </div>
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Nama sekolah</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-4">
                            <label for="anak" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="anak" class="control-label">Tahun Lulus</label>
                            <input class="form-control" type="text" name="anak[]"  onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Pendidikan</label>
                            <br>
                            <label for="anak" class="control-label">Akademi/universitas</label>
                            <input class="form-control" type="hidden" name="anak[]" id="" value="Sekolah Dasar">
                        </div>
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Nama sekolah</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-4">
                            <label for="anak" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="anak" class="control-label">Tahun Lulus</label>
                            <input class="form-control" type="text" name="anak[]"  onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Pendidikan</label>
                            <br>
                            <label for="anak" class="control-label">Universitas</label>
                            <input class="form-control" type="hidden" name="anak[]" id="" value="Sekolah Dasar">
                        </div>
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Nama sekolah</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-4">
                            <label for="anak" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="anak[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="anak" class="control-label">Tahun Lulus</label>
                            <input class="form-control" type="text" name="anak[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h4>Pendidikan Non - Formal</h4>
                        <hr>
                        <div class="d-flex">
                            <div class="form-group col-3">
                                <label for="nonformal" class="control-label">Macam</label>
                                <input class="form-control" type="text" name="nonformal[]" id="">
                            </div>
                            <div class="form-group col-3">
                                <label for="nonformal" class="control-label">Instansi</label>
                                <input class="form-control" type="text" name="nonformal[]" id="">
                            </div>
                            <div class="form-group col-3">
                                <label for="nonformal" class="control-label">Tempat</label>
                                <input class="form-control" type="text" name="nonformal[]" id="">
                            </div>
                            <div class="form-group col-2">
                                <label for="nonformal" class="control-label">Tahun</label>
                                <input class="form-control" type="text" name="nonformal[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                            </div>
                            <div class="col-1">
                                {{-- <i data-feather="x"></i> --}}
                            </div>
                        </div>
                        <div class="pendidikan-nonformal">
                        </div>
                        <div class="text-center mt-2">
                            <span class="btn btn-success btn-sm btn-add-nonformal">Tambah Pendidikan</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>Kehidupan Berorganisasi</h4>
                        <hr>
                        <div class="d-flex">
                            <div class="form-group col-3">
                                <label for="organisasi" class="control-label">Nama Organisasi</label>
                                <input class="form-control" type="text" name="organisasi[]" id="">
                            </div>
                            <div class="form-group col-3">
                                <label for="organisasi" class="control-label">Jabatan</label>
                                <input class="form-control" type="text" name="organisasi[]" id="">
                            </div>
                            <div class="form-group col-2">
                                <label for="organisasi" class="control-label">Tahun</label>
                                <input class="form-control" type="text" name="organisasi[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                            </div>
                            <div class="form-group col-3">
                                <label for="organisasi" class="control-label">Tempat</label>
                                <input class="form-control" type="text" name="organisasi[]">
                            </div>
                            <div class="col-1">
                                {{-- <i data-feather="x"></i> --}}
                            </div>
                        </div>
                        <div class="kehidupan-berorganisasi"></div>
                        <div class="text-center mt-2">
                            <span class="btn btn-success btn-sm btn-add-berorganisasi">Tambah Organisasi</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>Pengalaman Bekerja</h4>
                        <hr>
                        <div class="d-flex">
                            <div class="form-group col-2">
                                <label for="pengalamanKerja" class="control-label">Perusahaan</label>
                                <input class="form-control" type="text" name="pengalamanKerja[]" id="">
                            </div>
                            <div class="form-group col-2">
                                <label for="pengalamanKerja" class="control-label">Jabatan</label>
                                <input class="form-control" type="text" name="pengalamanKerja[]" id="">
                            </div>
                            <div class="form-group col-2">
                                <label for="pengalamanKerja" class="control-label">Tahun Awal</label>
                                <input class="form-control" type="text" name="pengalamanKerja[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                            </div>
                            <div class="form-group col-2">
                                <label for="pengalamanKerja" class="control-label">Tahun Akhir</label>
                                <input class="form-control" type="text" name="pengalamanKerja[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                            </div>
                            <div class="form-group col-3">
                                <label for="pengalamanKerja" class="control-label">Alasan Berhenti</label>
                                <input class="form-control" type="text" name="pengalamanKerja[]">
                            </div>
                            <div class="col-1">
                                {{-- <i data-feather="x"></i> --}}
                            </div>
                        </div>
                        <div class="pengalaman-bekerja"></div>
                        <div class="text-center mt-2">
                            <span class="btn btn-success btn-sm btn-add-bekerja">Tambah Pengalaman</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>Pengalaman Mengajar</h4>
                        <hr>
                        <div class="d-flex">
                            <div class="form-group col-2">
                                <label for="pengalamanMengajar" class="control-label">Lembaga</label>
                                <input class="form-control" type="text" name="pengalamanMengajar[]" id="">
                            </div>
                            <div class="form-group col-2">
                                <label for="pengalamanMengajar" class="control-label">Materi</label>
                                <input class="form-control" type="text" name="pengalamanMengajar[]" id="">
                            </div>
                            <div class="form-group col-2">
                                <label for="pengalamanMengajar" class="control-label">Tahun Awal</label>
                                <input class="form-control" type="text" name="pengalamanMengajar[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                            </div>
                            <div class="form-group col-2">
                                <label for="pengalamanMengajar" class="control-label">Tahun Akhir</label>
                                <input class="form-control" type="text" name="pengalamanMengajar[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                            </div>
                            <div class="form-group col-3">
                                <label for="pengalamanMengajar" class="control-label">Alasan Berhenti</label>
                                <input class="form-control" type="text" name="pengalamanMengajar[]">
                            </div>
                            <div class="col-1">
                                {{-- <i data-feather="x"></i> --}}
                            </div>
                        </div>
                        <div class="pengalaman-mengajar"></div>
                        <div class="text-center mt-2">
                            <span class="btn btn-success btn-sm btn-add-mengajar">Tambah Pengalaman</span>
                        </div>
                    </div>
                </div>
                {{-- page 2 --}}
                <div class="card-body active-page-3">3</div>
                {{-- page 2 --}}
                <div class="card-footer d-flex justify-content-between">
                    <div>
                        <nav aria-label="...">
                            <ul class="pagination">
                                <li class="page page-item active" data-number="1"><a class="page-link" href="#">1</a></li>
                                <li class="page page-item" data-number="2">
                                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page page-item" data-number="3"><a class="page-link" href="#">3</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div>
                        {{ Form::submit(($action == 'create') ? 'Tambahkan Data' : 'Simpan Data', ['class' => 'btn btn-primary save-btn-js']) }}
                    </div>
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
    //paging
    $('.active-page-1').show();
    $('.active-page-2').hide();
    $('.active-page-3').hide();
    $('.save-btn-js').hide();

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

    var page = 1;

    $('.page').click(function(){
        $('.page').removeClass('active');
        $(this).addClass('active');
        // console.warn($(this).attr('data-number'));
        if($(this).attr('data-number') == 1){
            $('.active-page-1').show();
            $('.active-page-2').hide();
            $('.active-page-3').hide();
            $('.save-btn-js').hide();
        } else if($(this).attr('data-number') == 2){
            $('.active-page-1').hide();
            $('.active-page-2').show();
            $('.active-page-3').hide();
            $('.save-btn-js').hide();
        } else if($(this).attr('data-number') == 3){
            $('.active-page-1').hide();
            $('.active-page-2').hide();
            $('.active-page-3').show();
            $('.save-btn-js').show();
        }
    });

    $('.btn-add-nonformal').click(function(){
        const html = `
                    <div class="form-nonformal-css d-flex align-items-center">
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Macam</label>
                            <input class="form-control" type="text" name="nonformal[]" id="">
                        </div>
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Instansi</label>
                            <input class="form-control" type="text" name="nonformal[]" id="">
                        </div>
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="nonformal[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="anak" class="control-label">Tahun</label>
                            <input class="form-control" type="text" name="nonformal[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                        <span class="col-1" onClick="$(this).parent().remove()">
                            <i data-feather="x"></i>
                        </span>
                    </div>`;

        // $('.pendidikan-nonformal').html('');
        $('.pendidikan-nonformal').append(html);
        replacefeather();
    });

    $('.btn-add-berorganisasi').click(function(){
        const html = `
                    <div class="d-flex align-items-center">
                        <div class="form-group col-3">
                            <label for="organisasi" class="control-label">Nama Organisasi</label>
                            <input class="form-control" type="text" name="organisasi[]" id="">
                        </div>
                        <div class="form-group col-3">
                            <label for="organisasi" class="control-label">Jabatan</label>
                            <input class="form-control" type="text" name="organisasi[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="organisasi" class="control-label">Tahun</label>
                            <input class="form-control" type="text" name="organisasi[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                        <div class="form-group col-3">
                            <label for="organisasi" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="organisasi[]">
                        </div>
                        <span class="col-1" onClick="$(this).parent().remove()">
                            <i data-feather="x"></i>
                        </span>
                    </div>`;

        // $('.pendidikan-nonformal').html('');
        $('.kehidupan-berorganisasi').append(html);
        replacefeather();
    });

    $('.btn-add-bekerja').click(function(){
        const html = `
                    <div class="d-flex align-items-center">
                        <div class="form-group col-2">
                            <label for="pengalamanKerja" class="control-label">Perusahaan</label>
                            <input class="form-control" type="text" name="pengalamanKerja[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="pengalamanKerja" class="control-label">Jabatan</label>
                            <input class="form-control" type="text" name="pengalamanKerja[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="pengalamanKerja" class="control-label">Tahun Awal</label>
                            <input class="form-control" type="text" name="pengalamanKerja[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                        <div class="form-group col-2">
                            <label for="pengalamanKerja" class="control-label">Tahun Akhir</label>
                            <input class="form-control" type="text" name="pengalamanKerja[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                        <div class="form-group col-3">
                            <label for="pengalamanKerja" class="control-label">Alasan Berhenti</label>
                            <input class="form-control" type="text" name="pengalamanKerja[]">
                        </div>
                        <span class="col-1" onClick="$(this).parent().remove()">
                            <i data-feather="x"></i>
                        </span>
                    </div>`;

        // $('.pendidikan-nonformal').html('');
        $('.pengalaman-bekerja').append(html);
        replacefeather();
    });

    $('.btn-add-mengajar').click(function(){
        const html = `
                    <div class="d-flex align-items-center">
                        <div class="form-group col-2">
                            <label for="pengalamanMengajar" class="control-label">Lembaga</label>
                            <input class="form-control" type="text" name="pengalamanMengajar[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="pengalamanMengajar" class="control-label">Materi</label>
                            <input class="form-control" type="text" name="pengalamanMengajar[]" id="">
                        </div>
                        <div class="form-group col-2">
                            <label for="pengalamanMengajar" class="control-label">Tahun Awal</label>
                            <input class="form-control" type="text" name="pengalamanMengajar[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                        <div class="form-group col-2">
                            <label for="pengalamanMengajar" class="control-label">Tahun Akhir</label>
                            <input class="form-control" type="text" name="pengalamanMengajar[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                        <div class="form-group col-3">
                            <label for="pengalamanMengajar" class="control-label">Alasan Berhenti</label>
                            <input class="form-control" type="text" name="pengalamanMengajar[]">
                        </div>
                        <span class="col-1" onClick="$(this).parent().remove()">
                            <i data-feather="x"></i>
                        </span>
                    </div>`;

        // $('.pendidikan-nonformal').html('');
        $('.pengalaman-mengajar').append(html);
        replacefeather();
    });
</script>
@endsection