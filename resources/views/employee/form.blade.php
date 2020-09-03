@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        @include('layouts.menu')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Tambah Staf</div>
                    @if($action == 'edit')
                    <a href="{{ route('schedule.index',$user->id) }}" class="btn btn-success btn-sm"><i data-feather="clock"></i> Schedule Staf</a>
                    @endif
                </div>
                @if(isset($user))
                {!! Form::model($user,['route' => ['employee.put', $user->id],
                'method'=>'put', "enctype"=>"multipart/form-data", "id"=>"form"]) !!}
                @else
                {!! Form::open(['route'=>'employee.post', "enctype"=>"multipart/form-data",
                "id"=>"form"]) !!}
                @endif
                <div class="card-body active-page-1">
                    <div class="row">
                    <div class="form-group col-md-6 {{ ($errors->has('name') ? 'has-error' : '') }}">
                        {{ Form::label('name', 'Nama lengkap', ['class' => 'control-label']) }}
                        {{ Form::text('name', ($action == 'edit') ? $user->name : '', ['class' => 'form-control', 'placeholder' => 'Nama karyawan', 'required']) }}
                        <span class="help-block">{{ ($errors->has('name') ? $errors->first('name') : '') }}</span>
                    </div>
                    <div class="form-group col-md-6 {{ ($errors->has('foto') ? 'has-error' : '') }}">
                        {{ Form::label('foto', 'Foto', ['class' => 'control-label']) }}
                        {{ Form::file('foto', ['class' => 'form-control']) }}

                        <span class="help-block">{{ ($errors->has('foto') ? $errors->first('foto') : '') }}</span>
                        @if($action == 'edit' && $userDetail->foto !== null)
                        <span class="help-block">{{ ($errors->has('foto') ? $errors->first('foto') : 'Kosongkan bila tidak ingin mengganti foto') }}</span>
                            <div class="text-center mt-2">
                                <img src="{{ asset('foto/employee/' . $userDetail->foto) }}" style="height: 250px" alt="" srcset="">
                            </div>
                        @endif
                    </div>
                </div>
                    <div class="form-group {{ ($errors->has('nick_name') ? 'has-error' : '') }}">
                        {{ Form::label('nick_name', 'Nama panggilan', ['class' => 'control-label']) }}
                        {{ Form::text('nick_name', ($action == 'edit') ? $userDetail->nick_name : '', ['class' => 'form-control', 'placeholder' => 'Nama panggilan', 'required']) }}
                        <span class="help-block">{{ ($errors->has('nick_name') ? $errors->first('nick_name') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('birth_city') ? 'has-error' : '') }}">
                        {{ Form::label('birth_city', 'Kota kelahiran', ['class' => 'control-label']) }}
                        {{ Form::text('birth_city', ($action == 'edit') ? $userDetail->birth_city : '', ['class' => 'form-control', 'placeholder' => 'Kota kelahiran', 'required']) }}
                        <span class="help-block">{{ ($errors->has('birth_city') ? $errors->first('birth_city') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('birth_date') ? 'has-error' : '') }}">
                        {{ Form::label('birth_date', 'Tanggal lahir', ['class' => 'control-label']) }}
                        {{ Form::text('birth_date', ($action == 'edit') ? $userDetail->birth_date : '', ['class' => 'dob form-control', 'readonly' => 'readonly', 'placeholder' => 'Tanggal kelahiran', 'required']) }}
                        <span class="help-block">{{ ($errors->has('birth_date') ? $errors->first('birth_date') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('address') ? 'has-error' : '') }}">
                        {{ Form::label('address', 'Alamat lengkap', ['class' => 'control-label']) }}
                        {{ Form::textarea('address', ($action == 'edit') ? $userDetail->address : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Alamat lengkap', 'required']) }}
                        <span class="help-block">{{ ($errors->has('address') ? $errors->first('address') : '') }}</span>
                    </div>
                    <div class="d-flex">
                        <div class="col-6 form-group {{ ($errors->has('address_city') ? 'has-error' : '') }}">
                            {{ Form::label('address_city', 'Tinggal di kota', ['class' => 'control-label']) }}
                            {{ Form::text('address_city', ($action == 'edit') ? $userDetail->address_city : '', ['class' => 'form-control', 'placeholder' => 'Tinggal di kota', 'required']) }}
                            <span class="help-block">{{ ($errors->has('address_city') ? $errors->first('address_city') : '') }}</span>
                        </div>
                        <div class="col-6 form-group {{ ($errors->has('address_postal_code') ? 'has-error' : '') }}">
                            {{ Form::label('address_postal_code', 'Kode POS', ['class' => 'control-label']) }}
                            {{ Form::text('address_postal_code', ($action == 'edit') ? $userDetail->address_postal_code : '', ['class' => 'form-control', 'id' => 'intOnly6', 'placeholder' => 'Kode POS', 'required']) }}
                            <span class="help-block">{{ ($errors->has('address_postal_code') ? $errors->first('address_postal_code') : '') }}</span>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="col-4 form-group {{ ($errors->has('phone_home') ? 'has-error' : '') }}">
                            {{ Form::label('phone_home', 'Telp. Rumah', ['class' => 'control-label']) }}
                            {{ Form::text('phone_home', ($action == 'edit') ? $userDetail->phone_home : '', ['class' => 'form-control', 'id' => 'intOnly9', 'placeholder' => 'Telp. Rumah', 'required']) }}
                            <span class="help-block">{{ ($errors->has('phone_home') ? $errors->first('phone_home') : '') }}</span>
                        </div>
                        <div class="col-4 form-group {{ ($errors->has('phone_mobile') ? 'has-error' : '') }}">
                            {{ Form::label('phone_mobile', 'No. Handphone', ['class' => 'control-label']) }}
                            {{ Form::text('phone_mobile', ($action == 'edit') ? $userDetail->phone_mobile : '', ['class' => 'form-control', 'id' => 'intOnly13', 'placeholder' => 'Telp. Handphone', 'required']) }}
                            <span class="help-block">{{ ($errors->has('phone_mobile') ? $errors->first('phone_mobile') : '') }}</span>
                        </div>
                        <div class="col-4 form-group {{ ($errors->has('phone_office') ? 'has-error' : '') }}">
                            {{ Form::label('phone_office', 'Telp. Kantor', ['class' => 'control-label']) }}
                            {{ Form::text('phone_office', ($action == 'edit') ? $userDetail->phone_office : '', ['class' => 'form-control', 'id' => 'intOnly9Office', 'placeholder' => 'Telp. Kantor', 'required']) }}
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
                            {{ Form::radio('religion', 'Islam', $action == 'edit' ? $userDetail->religion == 'Islam' ? true : false : true, ['class' => 'mr-2']) }} <span class="mr-2">Islam</span>
                            {{ Form::radio('religion', 'Katholik', $action == 'edit' ? $userDetail->religion == 'Katholik' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Katholik</span>
                            {{ Form::radio('religion', 'Kristen', $action == 'edit' ? $userDetail->religion == 'Kristen' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Kristen</span>
                            {{ Form::radio('religion', 'Budha', $action == 'edit' ? $userDetail->religion == 'Budha' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Budha</span>
                            {{ Form::radio('religion', 'Hindu', $action == 'edit' ? $userDetail->religion == 'Hindu' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Hindu</span>
                        </div>
                        <span class="help-block">{{ ($errors->has('religion') ? $errors->first('religion') : '') }}</span>
                    </div>
                    
                    <div class="form-group {{ ($errors->has('card_identity_number') ? 'has-error' : '') }}">
                        {{ Form::label('card_identity_number', 'No. KTP', ['class' => 'control-label']) }}
                        {{ Form::text('card_identity_number', ($action == 'edit') ? $userDetail->card_identity_number : '', ['class' => 'form-control', 'id' => 'intOnly16', 'placeholder' => 'No. KTP', 'required']) }}
                        <span class="help-block">{{ ($errors->has('card_identity_number') ? $errors->first('card_identity_number') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('number_of_siblings') ? 'has-error' : '') }}">
                        {{ Form::label('number_of_siblings', 'Anak Ke', ['class' => 'control-label']) }}
                        {{ Form::text('number_of_siblings', ($action == 'edit') ? $userDetail->number_of_siblings : '', ['class' => 'form-control', 'id' => 'intOnly2', 'placeholder' => 'Anak Ke ..', 'required']) }}
                        <span class="help-block">{{ ($errors->has('number_of_siblings') ? $errors->first('number_of_siblings') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('status') ? 'has-error' : '') }}">
                        {{ Form::label('status', 'Status', ['class' => 'control-label']) }}
                        <div class="d-flex align-items-center">
                            {{ Form::radio('status', 'Menikah', $action == 'edit' ? $userDetail->status == 'Menikah' ? true : false : true, ['class' => 'mr-2']) }} <span class="mr-2">Menikah</span>
                            {{ Form::radio('status', 'Belum Menikah', $action == 'edit' ? $userDetail->status == 'Belum Menikah' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Belum Menikah</span>
                            {{ Form::radio('status', 'Janda', $action == 'edit' ? $userDetail->status == 'Janda' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Janda</span>
                            {{ Form::radio('status', 'Duda', $action == 'edit' ? $userDetail->status == 'Duda' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Duda</span>
                        </div>
                        <span class="help-block">{{ ($errors->has('status') ? $errors->first('status') : '') }}</span>
                    </div>
                    <div id="isNotSingle">
                        <div class="form-group {{ ($errors->has('nama_istri_suami') ? 'has-error' : '') }}">
                            {{ Form::label('nama_istri_suami', 'Nama Istri / Suami', ['class' => 'control-label']) }}
                            {{ Form::text('nama_istri_suami', ($action == 'edit') ? $userDetail->nama_istri_suami : '', ['class' => 'form-control', 'placeholder' => 'Nama Istri / Suami', 'required']) }}
                            <span class="help-block">{{ ($errors->has('nama_istri_suami') ? $errors->first('nama_istri_suami') : '') }}</span>
                        </div>
                        <div class="form-group {{ ($errors->has('pekerjaan_istri_suami') ? 'has-error' : '') }}">
                            {{ Form::label('pekerjaan_istri_suami', 'Pekerjaan Istri / Suami', ['class' => 'control-label']) }}
                            {{ Form::text('pekerjaan_istri_suami', ($action == 'edit') ? $userDetail->pekerjaan_istri_suami : '', ['class' => 'form-control', 'placeholder' => 'Pekerjaan Istri / Suami', 'required']) }}
                            <span class="help-block">{{ ($errors->has('pekerjaan_istri_suami') ? $errors->first('pekerjaan_istri_suami') : '') }}</span>
                        </div>
                        <div class="form-group {{ ($errors->has('jumlah_anak') ? 'has-error' : '') }}">
                            {{ Form::label('jumlah_anak', 'Jumlah Anak', ['class' => 'control-label']) }}
                            {{ Form::text('jumlah_anak', ($action == 'edit') ? $userDetail->jumlah_anak : '', ['class' => 'form-control', 'id' => 'intOnly2Anak', 'placeholder' => 'Jumlah Anak', 'required']) }}
                            <span class="help-block">{{ ($errors->has('jumlah_anak') ? $errors->first('jumlah_anak') : '') }}</span>
                        </div>
                    </div>
                    @if($action == 'create')
                        <div class="form-group form-anak {{ ($errors->has('anak') ? 'has-error' : '') }}">
                            {{ Form::label('anak', 'Keterangan Anak', ['class' => 'control-label']) }}
                            <div class="add-anak">
                                
                            </div>
                        </div>
                    @else
                        <div class="form-group form-anak {{ ($errors->has('anak') ? 'has-error' : '') }}">
                            {{ Form::label('anak', 'Keterangan Anak', ['class' => 'control-label']) }}
                            
                            @if($userDetail->jumlah_anak != 0)
                                <div class="add-anak">
                                    @foreach($userDetail->anak as $anak)
                                    @php
                                        $anak = json_decode($anak);
                                    @endphp
                                    <div class="form-anak-dynamic d-flex">
                                        <div class="form-group col-3">
                                            <label for="anak" class="control-label">Nama anak</label>
                                            <input class="form-control" type="text" name="anak[]" value="{{ $anak->nama }}">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="anak" class="control-label">Jenis Kelamin</label>
                                            <select class="form-control" name="anak[]" id="">
                                                <option value="l" {{ $anak->nama == 'l' ? 'selected' : '' }}>L</option>
                                                <option value="p" {{ $anak->nama == 'p' ? 'selected' : '' }}>P</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="anak" class="control-label">Tanggal lahir</label>
                                            <input class="dob form-control" type="text" name="anak[]"  value="{{ $anak->tgl_lahir }}" readonly="">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="anak" class="control-label">Pekerjaan / Pendidikan</label>
                                            <input class="form-control" type="text" name="anak[]" value="{{ $anak->pendidikan_pekerjaan }}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                            <div class="add-anak">
                                
                            </div>
                            @endif
                        </div>
                    @endif
                    <div class="form-group">
                        {{ Form::label('label', 'Bila terjadi sesuatu pada diri Anda, kami dapat menghubungi:', ['class' => 'control-label']) }}
                    </div>
                    <div class="form-group {{ ($errors->has('nama_darurat') ? 'has-error' : '') }}">
                        {{ Form::label('nama_darurat', 'Nama', ['class' => 'control-label']) }}
                        {{ Form::text('nama_darurat', ($action == 'edit') ? $userDetail->nama_darurat : '', ['class' => 'form-control', 'placeholder' => 'Nama kerabat', 'required']) }}
                        <span class="help-block">{{ ($errors->has('nama_darurat') ? $errors->first('nama_darurat') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('address_darurat') ? 'has-error' : '') }}">
                        {{ Form::label('address_darurat', 'Alamat lengkap', ['class' => 'control-label']) }}
                        {{ Form::textarea('address_darurat', ($action == 'edit') ? $userDetail->address_darurat : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Alamat kerabat', 'required']) }}
                        <span class="help-block">{{ ($errors->has('address_darurat') ? $errors->first('address_darurat') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('tlp_darurat') ? 'has-error' : '') }}">
                        {{ Form::label('tlp_darurat', 'No. Telp', ['class' => 'control-label']) }}
                        {{ Form::text('tlp_darurat', ($action == 'edit') ? $userDetail->tlp_darurat : '', ['class' => 'form-control', 'onkeypress' => 'if ( isNaN( String.fromCharCode(event.keyCode) )) return false;', 'placeholder' => 'Telp. kerabat', 'required']) }}
                        <span class="help-block">{{ ($errors->has('phone_mobile') ? $errors->first('tlp_darurat') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('nama_ayah') ? 'has-error' : '') }}">
                        {{ Form::label('nama_ayah', 'Nama Ayah', ['class' => 'control-label']) }}
                        {{ Form::text('nama_ayah', ($action == 'edit') ? $userDetail->nama_ayah : '', ['class' => 'form-control', 'placeholder' => 'Nama ayah', 'required']) }}
                        <span class="help-block">{{ ($errors->has('nama_ayah') ? $errors->first('nama_ayah') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('pekerjaan_ayah') ? 'has-error' : '') }}">
                        {{ Form::label('pekerjaan_ayah', 'Pekerjaan', ['class' => 'control-label']) }}
                        {{ Form::text('pekerjaan_ayah', ($action == 'edit') ? $userDetail->pekerjaan_ayah : '', ['class' => 'form-control', 'placeholder' => 'Pekerjaan ayah', 'required']) }}
                        <span class="help-block">{{ ($errors->has('pekerjaan_ayah') ? $errors->first('pekerjaan_ayah') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('alamat_ayah') ? 'has-error' : '') }}">
                        {{ Form::label('alamat_ayah', 'Alamat lengkap', ['class' => 'control-label']) }}
                        {{ Form::textarea('alamat_ayah', ($action == 'edit') ? $userDetail->alamat_ayah : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Alamat tinggal ayah', 'required']) }}
                        <span class="help-block">{{ ($errors->has('alamat_ayah') ? $errors->first('alamat_ayah') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('nama_ibu') ? 'has-error' : '') }}">
                        {{ Form::label('nama_ibu', 'Nama Ibu', ['class' => 'control-label']) }}
                        {{ Form::text('nama_ibu', ($action == 'edit') ? $userDetail->nama_ibu : '', ['class' => 'form-control', 'placeholder' => 'Nama ibu', 'required']) }}
                        <span class="help-block">{{ ($errors->has('nama_ibu') ? $errors->first('nama_ibu') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('pekerjaan_ibu') ? 'has-error' : '') }}">
                        {{ Form::label('pekerjaan_ibu', 'Pekerjaan', ['class' => 'control-label']) }}
                        {{ Form::text('pekerjaan_ibu', ($action == 'edit') ? $userDetail->pekerjaan_ibu : '', ['class' => 'form-control', 'placeholder' => 'Pekerjaan ibu', 'required']) }}
                        <span class="help-block">{{ ($errors->has('pekerjaan_ibu') ? $errors->first('pekerjaan_ibu') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('alamat_ibu') ? 'has-error' : '') }}">
                        {{ Form::label('alamat_ibu', 'Alamat lengkap', ['class' => 'control-label']) }}
                        {{ Form::textarea('alamat_ibu', ($action == 'edit') ? $userDetail->alamat_ibu : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Alamat tinggal ibu', 'required']) }}
                        <span class="help-block">{{ ($errors->has('alamat_ibu') ? $errors->first('alamat_ibu') : '') }}</span>
                    </div>
                </div>
                {{-- page 1 --}}
                <div class="card-body active-page-2">
                    <h4>Pendidikan Formal</h4>
                    <hr>
                    @php
                    if($action == 'edit'){
                        $pendFormalSd = json_decode($userDetail->pendidikan_formal[0]);
                        $pendFormalSmp = json_decode($userDetail->pendidikan_formal[1]);
                        $pendFormalSlta = json_decode($userDetail->pendidikan_formal[2]);
                        $pendFormalAkadUniv = json_decode($userDetail->pendidikan_formal[3]);
                        $pendFormalUniv = json_decode($userDetail->pendidikan_formal[4]);
                    }
                    @endphp
                    <div class="d-flex">
                        <div class="form-group col-3">
                            <label for="anak" class="control-label">Pendidikan</label>
                            <label for="pendNormalSd" class="control-label">Sekolah Dasar</label>
                        </div>
                        <div class="form-group col-3">
                            <label for="pendNormalSd" class="control-label">Nama sekolah</label>
                            <input class="form-control" type="text" name="pendNormalSd[]" value="{{ $action == 'edit' ? $pendFormalSd->nama_sekolah : '' }}">
                        </div>
                        <div class="form-group col-4">
                            <label for="pendNormalSd" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="pendNormalSd[]" value="{{ $action == 'edit' ? $pendFormalSd->tempat : '' }}">
                        </div>
                        <div class="form-group col-2">
                            <label for="pendNormalSd" class="control-label">Tahun Lulus</label>
                            <input class="form-control" type="text" name="pendNormalSd[]"  value="{{ $action == 'edit' ? $pendFormalSd->tahun_lulus : '' }}" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group col-3">
                            <label for="pendNormalSmp" class="control-label">Pendidikan</label>
                            <br>
                            <label for="pendNormalSmp" class="control-label">SMP</label>
                        </div>
                        <div class="form-group col-3">
                            <label for="pendNormalSmp" class="control-label">Nama sekolah</label>
                            <input class="form-control" type="text" name="pendNormalSmp[]" value="{{ $action == 'edit' ? $pendFormalSmp->nama_sekolah : '' }}">
                        </div>
                        <div class="form-group col-4">
                            <label for="pendNormalSmp" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="pendNormalSmp[]" value="{{ $action == 'edit' ? $pendFormalSmp->tempat : '' }}">
                        </div>
                        <div class="form-group col-2">
                            <label for="pendNormalSmp" class="control-label">Tahun Lulus</label>
                            <input class="form-control" type="text" name="pendNormalSmp[]"  value="{{ $action == 'edit' ? $pendFormalSmp->tahun_lulus : '' }}" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group col-3">
                            <label for="pendNormalSlta" class="control-label">Pendidikan</label>
                            <br>
                            <label for="pendNormalSlta" class="control-label">SLTA</label>
                        </div>
                        <div class="form-group col-3">
                            <label for="pendNormalSlta" class="control-label">Nama sekolah</label>
                            <input class="form-control" type="text" name="pendNormalSlta[]" value="{{ $action == 'edit' ? $pendFormalSlta->nama_sekolah : '' }}">
                        </div>
                        <div class="form-group col-4">
                            <label for="pendNormalSlta" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="pendNormalSlta[]" value="{{ $action == 'edit' ? $pendFormalSlta->tempat : '' }}">
                        </div>
                        <div class="form-group col-2">
                            <label for="pendNormalSlta" class="control-label">Tahun Lulus</label>
                            <input class="form-control" type="text" name="pendNormalSlta[]"  value="{{ $action == 'edit' ? $pendFormalSlta->tahun_lulus : '' }}" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group col-3">
                            <label for="pendNormalAkadUniv" class="control-label">Pendidikan</label>
                            <br>
                            <label for="pendNormalAkadUniv" class="control-label">Akademi/universitas</label>
                        </div>
                        <div class="form-group col-3">
                            <label for="pendNormalAkadUniv" class="control-label">Nama sekolah</label>
                            <input class="form-control" type="text" name="pendNormalAkadUniv[]" value="{{ $action == 'edit' ? $pendFormalAkadUniv->nama_sekolah : '' }}">
                        </div>
                        <div class="form-group col-4">
                            <label for="pendNormalAkadUniv" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="pendNormalAkadUniv[]" value="{{ $action == 'edit' ? $pendFormalAkadUniv->tempat : '' }}">
                        </div>
                        <div class="form-group col-2">
                            <label for="pendNormalAkadUniv" class="control-label">Tahun Lulus</label>
                            <input class="form-control" type="text" name="pendNormalAkadUniv[]"  value="{{ $action == 'edit' ? $pendFormalAkadUniv->tahun_lulus : '' }}" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group col-3">
                            <label for="pendNormalUniv" class="control-label">Pendidikan</label>
                            <br>
                            <label for="pendNormalUniv" class="control-label">Universitas</label>
                        </div>
                        <div class="form-group col-3">
                            <label for="pendNormalUniv" class="control-label">Nama sekolah</label>
                            <input class="form-control" type="text" name="pendNormalUniv[]" value="{{ $action == 'edit' ? $pendFormalUniv->nama_sekolah : '' }}">
                        </div>
                        <div class="form-group col-4">
                            <label for="pendNormalUniv" class="control-label">Tempat</label>
                            <input class="form-control" type="text" name="pendNormalUniv[]" value="{{ $action == 'edit' ? $pendFormalUniv->tempat : '' }}">
                        </div>
                        <div class="form-group col-2">
                            <label for="pendNormalUniv" class="control-label">Tahun Lulus</label>
                            <input class="form-control" type="text" name="pendNormalUniv[]" value="{{ $action == 'edit' ? $pendFormalUniv->tahun_lulus : '' }}" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h4>Pendidikan Non - Formal</h4>
                        <hr>
                        @if($action == 'create')
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
                        @else
                        <div class="pendidikan-nonformal">
                            @if($userDetail->pendidikan_nonformal != 0)
                                @foreach($userDetail->pendidikan_nonformal as $nonformal)
                                @php
                                    $nonformal = json_decode($nonformal);
                                @endphp
                                <div class="form-nonformal-css d-flex align-items-center">
                                    <div class="form-group col-3">
                                        <label for="nonformal" class="control-label">Macam</label>
                                        <input class="form-control" type="text" name="nonformal[]" id="" value="{{ $nonformal->macam }}">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="nonformal" class="control-label">Instansi</label>
                                        <input class="form-control" type="text" name="nonformal[]" id="" value="{{ $nonformal->instansi }}">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="nonformal" class="control-label">Tempat</label>
                                        <input class="form-control" type="text" name="nonformal[]" id="" value="{{ $nonformal->tempat }}">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="nonformal" class="control-label">Tahun</label>
                                        <input class="form-control" type="text" name="nonformal[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" value="{{ $nonformal->tahun }}">
                                    </div>
                                    <span class="col-1" onClick="$(this).parent().remove()">
                                        <i data-feather="x"></i>
                                    </span>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        @endif
                        <div class="text-center mt-2">
                            <span class="btn btn-success btn-sm btn-add-nonformal">Tambah Pendidikan</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>Kehidupan Berorganisasi</h4>
                        <hr>
                        @if($action == 'create')
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
                        @else
                        <div class="kehidupan-berorganisasi">

                            @if($userDetail->kehidupan_berorganisasi != 0)
                                @foreach($userDetail->kehidupan_berorganisasi as $org)
                                    @php
                                        $org = json_decode($org);
                                    @endphp
                                <div class="d-flex align-items-center">
                                    <div class="form-group col-3">
                                        <label for="organisasi" class="control-label">Nama Organisasi</label>
                                        <input class="form-control" type="text" name="organisasi[]" id="" value="{{ $org->nama_organisasi }}">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="organisasi" class="control-label">Jabatan</label>
                                        <input class="form-control" type="text" name="organisasi[]" id="" value="{{ $org->jabatan }}">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="organisasi" class="control-label">Tahun</label>
                                        <input class="form-control" type="text" name="organisasi[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" value="{{ $org->tahun }}">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="organisasi" class="control-label">Tempat</label>
                                        <input class="form-control" type="text" name="organisasi[]" value="{{ $org->tempat }}">
                                    </div>
                                    <span class="col-1" onClick="$(this).parent().remove()">
                                        <i data-feather="x"></i>
                                    </span>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        @endif
                        <div class="text-center mt-2">
                            <span class="btn btn-success btn-sm btn-add-berorganisasi">Tambah Organisasi</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>Pengalaman Bekerja</h4>
                        <hr>
                        @if($action == 'create')
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
                        @else
                        <div class="pengalaman-bekerja">

                            @if($userDetail->pengalaman_bekerja != 0)
                                @foreach($userDetail->pengalaman_bekerja as $job)
                                    @php
                                        $job = json_decode($job);
                                    @endphp
                                <div class="d-flex align-items-center">
                                    <div class="form-group col-2">
                                        <label for="pengalamanKerja" class="control-label">Perusahaan</label>
                                        <input class="form-control" type="text" name="pengalamanKerja[]" id="" value="{{ $job->nama_perusahaan }}">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="pengalamanKerja" class="control-label">Jabatan</label>
                                        <input class="form-control" type="text" name="pengalamanKerja[]" id="" value="{{ $job->jabatan }}">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="pengalamanKerja" class="control-label">Tahun Awal</label>
                                        <input class="form-control" type="text" name="pengalamanKerja[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" value="{{ $job->tahun_awal }}">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="pengalamanKerja" class="control-label">Tahun Akhir</label>
                                        <input class="form-control" type="text" name="pengalamanKerja[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" value="{{ $job->tahun_akhir }}">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="pengalamanKerja" class="control-label">Alasan Berhenti</label>
                                        <input class="form-control" type="text" name="pengalamanKerja[]" value="{{ $job->alasan }}">
                                    </div>
                                    <span class="col-1" onClick="$(this).parent().remove()">
                                        <i data-feather="x"></i>
                                    </span>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        @endif
                        <div class="text-center mt-2">
                            <span class="btn btn-success btn-sm btn-add-bekerja">Tambah Pengalaman</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>Pengalaman Mengajar</h4>
                        <hr>
                        @if($action == 'create')
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
                        @else
                        <div class="pengalaman-mengajar">
                            @if($userDetail->pengalaman_mengajar != 0)
                                @foreach($userDetail->pengalaman_mengajar as $teach)
                                    @php
                                        $teach = json_decode($teach);
                                    @endphp
                                <div class="d-flex align-items-center">
                                    <div class="form-group col-2">
                                        <label for="pengalamanMengajar" class="control-label">Lembaga</label>
                                        <input class="form-control" type="text" name="pengalamanMengajar[]" id="" value="{{ $teach->nama_lembaga }}">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="pengalamanMengajar" class="control-label">Materi</label>
                                        <input class="form-control" type="text" name="pengalamanMengajar[]" id="" value="{{ $teach->materi }}">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="pengalamanMengajar" class="control-label">Tahun Awal</label>
                                        <input class="form-control" type="text" name="pengalamanMengajar[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" value="{{ $teach->tahun_awal }}">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="pengalamanMengajar" class="control-label">Tahun Akhir</label>
                                        <input class="form-control" type="text" name="pengalamanMengajar[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" value="{{ $teach->tahun_akhir }}">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="pengalamanMengajar" class="control-label">Alasan Berhenti</label>
                                        <input class="form-control" type="text" name="pengalamanMengajar[]" value="{{ $teach->alasan }}">
                                    </div>
                                    <span class="col-1" onClick="$(this).parent().remove()">
                                        <i data-feather="x"></i>
                                    </span>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        @endif
                        <div class="text-center mt-2">
                            <span class="btn btn-success btn-sm btn-add-mengajar">Tambah Pengalaman</span>
                        </div>
                    </div>
                </div>
                {{-- page 2 --}}
                <div class="card-body active-page-3">
                    <h4>Keahlian komputer</h4>
                    <hr>
                    <div class="form-group {{ ($errors->has('kk_mengajar_matkul') ? 'has-error' : '') }}">
                        {{ Form::label('kk_mengajar_matkul', 'Dapat mengajar mata pelajaran', ['class' => 'control-label']) }}
                        {{ Form::text('kk_mengajar_matkul', ($action == 'edit') ? $userDetail->kk_mengajar_matkul : '', ['class' => 'form-control', 'placeholder' => 'Nama mata pelajaran', 'required']) }}
                        <span class="help-block">{{ ($errors->has('kk_mengajar_matkul') ? $errors->first('kk_mengajar_matkul') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('kk_mengajar_matkul') ? 'has-error' : '') }}">
                        {{ Form::label('kk_software_dikuasai', 'Paket software yang dikuasai', ['class' => 'control-label']) }}
                        {{ Form::text('kk_software_dikuasai', ($action == 'edit') ? $userDetail->kk_software_dikuasai : '', ['class' => 'form-control', 'placeholder' => 'Nama software', 'required']) }}
                        <span class="help-block">{{ ($errors->has('kk_software_dikuasai') ? $errors->first('kk_software_dikuasai') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('kk_bahasa_pemograman') ? 'has-error' : '') }}">
                        {{ Form::label('kk_bahasa_pemograman', 'Bahasa pemograman yang dikuasai', ['class' => 'control-label']) }}
                        {{ Form::text('kk_bahasa_pemograman', ($action == 'edit') ? $userDetail->kk_bahasa_pemograman : '', ['class' => 'form-control', 'placeholder' => 'Nama bahasa pemograman', 'required']) }}
                        <span class="help-block">{{ ($errors->has('kk_bahasa_pemograman') ? $errors->first('kk_bahasa_pemograman') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('kk_hardware_dikuasai') ? 'has-error' : '') }}">
                        {{ Form::label('kk_hardware_dikuasai', 'Permasalahan Hardware yang dikuasai', ['class' => 'control-label']) }}
                        {{ Form::text('kk_hardware_dikuasai', ($action == 'edit') ? $userDetail->kk_hardware_dikuasai : '', ['class' => 'form-control', 'placeholder' => 'Nama masalah Hardware', 'required']) }}
                        <span class="help-block">{{ ($errors->has('kk_hardware_dikuasai') ? $errors->first('kk_hardware_dikuasai') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('kk_menguasai_jaringan') ? 'has-error' : '') }}">
                        {{ Form::label('kk_menguasai_jaringan', 'Menguasai Jaringan Komputer', ['class' => 'control-label']) }}
                        <div class="d-flex align-items-center">
                            {{ Form::radio('kk_menguasai_jaringan', 'Ya', $action == 'edit' ? $userDetail->kk_menguasai_jaringan == 'Ya' ? true : false : true, ['class' => 'mr-2']) }} <span class="mr-2">Ya</span>
                            {{ Form::radio('kk_menguasai_jaringan', 'Tidak', $action == 'edit' ? $userDetail->kk_menguasai_jaringan == 'Tidak' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Tidak</span>
                        </div>
                        <span class="help-block">{{ ($errors->has('kk_menguasai_jaringan') ? $errors->first('kk_menguasai_jaringan') : '') }}</span>
                    </div>
                    <div id="input-jaringan-dikuasai-js" class="form-group {{ ($errors->has('kk_jaringan_dikuasai') ? 'has-error' : '') }}">
                        {{ Form::label('kk_jaringan_dikuasai', 'Jika Ya, dalam hal apa', ['class' => 'control-label']) }}
                        {{ Form::text('kk_jaringan_dikuasai', ($action == 'edit') ? $userDetail->kk_jaringan_dikuasai : '', ['class' => 'form-control', 'placeholder' => 'Mengenai hal jaringan', 'required']) }}
                        <span class="help-block">{{ ($errors->has('kk_jaringan_dikuasai') ? $errors->first('kk_jaringan_dikuasai') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('kk_sofware_pernah_dibuat') ? 'has-error' : '') }}">
                        {{ Form::label('kk_sofware_pernah_dibuat', 'Software yang pernah dibuat', ['class' => 'control-label']) }}
                        {{ Form::text('kk_sofware_pernah_dibuat', ($action == 'edit') ? $userDetail->kk_sofware_pernah_dibuat : '', ['class' => 'form-control', 'placeholder' => 'Nama software', 'required']) }}
                        <span class="help-block">{{ ($errors->has('kk_sofware_pernah_dibuat') ? $errors->first('kk_sofware_pernah_dibuat') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('kk_sofware_pernah_dibuat_detail') ? 'has-error' : '') }}">
                        {{ Form::label('kk_sofware_pernah_dibuat_detail', 'Spesifikasi Masalah Software yang pernah dibuat', ['class' => 'control-label']) }}
                        {{ Form::text('kk_sofware_pernah_dibuat_detail', ($action == 'edit') ? $userDetail->kk_sofware_pernah_dibuat_detail : '', ['class' => 'form-control', 'placeholder' => 'Detail software yang pernah dibuat', 'required']) }}
                        <span class="help-block">{{ ($errors->has('kk_sofware_pernah_dibuat_detail') ? $errors->first('kk_sofware_pernah_dibuat_detail') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('kk_sofware_pernah_dibuat_bahasa_pemograman') ? 'has-error' : '') }}">
                        {{ Form::label('kk_sofware_pernah_dibuat_bahasa_pemograman', 'Bahasa Pemograman Software yang pernah dibuat', ['class' => 'control-label']) }}
                        {{ Form::text('kk_sofware_pernah_dibuat_bahasa_pemograman', ($action == 'edit') ? $userDetail->kk_sofware_pernah_dibuat_bahasa_pemograman : '', ['class' => 'form-control', 'placeholder' => 'Bahasa Pemograman software yang pernah dibuat', 'required']) }}
                        <span class="help-block">{{ ($errors->has('kk_sofware_pernah_dibuat_bahasa_pemograman') ? $errors->first('kk_sofware_pernah_dibuat_bahasa_pemograman') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('kk_mengarang_buku') ? 'has-error' : '') }}">
                        {{ Form::label('kk_mengarang_buku', 'Pernah mengarang buku?', ['class' => 'control-label']) }}
                        <div class="d-flex align-items-center">
                            {{ Form::radio('kk_mengarang_buku', 'Ya', $action == 'edit' ? $userDetail->kk_mengarang_buku == 'Ya' ? true : false : true, ['class' => 'mr-2']) }} <span class="mr-2">Ya</span>
                            {{ Form::radio('kk_mengarang_buku', 'Tidak', $action == 'edit' ? $userDetail->kk_mengarang_buku == 'Tidak' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Tidak</span>
                        </div>
                        <span class="help-block">{{ ($errors->has('kk_mengarang_buku') ? $errors->first('kk_mengarang_buku') : '') }}</span>
                    </div>
                    <div id="input-karangan-buku-js">
                        <div class="form-group {{ ($errors->has('kk_mengarang_buku_judul') ? 'has-error' : '') }}">
                            {{ Form::label('kk_mengarang_buku_judul', 'Jika Ya, Judul Buku', ['class' => 'control-label']) }}
                            {{ Form::text('kk_mengarang_buku_judul', ($action == 'edit') ? $userDetail->kk_mengarang_buku_judul : '', ['class' => 'form-control', 'placeholder' => 'Judul buku', 'required']) }}
                            <span class="help-block">{{ ($errors->has('kk_mengarang_buku_judul') ? $errors->first('kk_mengarang_buku_judul') : '') }}</span>
                        </div>
                        <div class="form-group {{ ($errors->has('kk_mengarang_buku_penerbit') ? 'has-error' : '') }}">
                            {{ Form::label('kk_mengarang_buku_penerbit', 'Penerbit', ['class' => 'control-label']) }}
                            {{ Form::text('kk_mengarang_buku_penerbit', ($action == 'edit') ? $userDetail->kk_mengarang_buku_penerbit : '', ['class' => 'form-control', 'placeholder' => 'Nama Penerbit', 'required']) }}
                            <span class="help-block">{{ ($errors->has('kk_mengarang_buku_penerbit') ? $errors->first('kk_mengarang_buku_penerbit') : '') }}</span>
                        </div>
                        <div class="form-group {{ ($errors->has('kk_mengarang_buku_tahun_penerbit') ? 'has-error' : '') }}">
                            {{ Form::label('kk_mengarang_buku_tahun_penerbit', 'Tahun terbit buku', ['class' => 'control-label']) }}
                            {{ Form::text('kk_mengarang_buku_tahun_penerbit', ($action == 'edit') ? $userDetail->kk_mengarang_buku_tahun_penerbit : '', ['class' => 'form-control', 'onkeypress' => 'if ( isNaN( String.fromCharCode(event.keyCode) )) return false;', 'placeholder' => 'Tahun terbit buku', 'required']) }}
                            <span class="help-block">{{ ($errors->has('kk_mengarang_buku_tahun_penerbit') ? $errors->first('kk_mengarang_buku_tahun_penerbit') : '') }}</span>
                        </div>
                    </div>
                    <div class="form-group {{ ($errors->has('kk_keahlian_diluar_komputer') ? 'has-error' : '') }}">
                        {{ Form::label('kk_keahlian_diluar_komputer', 'Keahlian diluar komputer', ['class' => 'control-label']) }}
                        {{ Form::textarea('kk_keahlian_diluar_komputer', ($action == 'edit') ? $userDetail->kk_keahlian_diluar_komputer : '', ['class' => 'form-control', 'rows' => 3, 'cols' => 40, 'placeholder' => 'Deskripsikan', 'required']) }}
                        <span class="help-block">{{ ($errors->has('kk_keahlian_diluar_komputer') ? $errors->first('kk_keahlian_diluar_komputer') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('olah_raga') ? 'has-error' : '') }}">
                        {{ Form::label('olah_raga', 'Olah Raga', ['class' => 'control-label']) }}
                        <div class="d-flex align-items-center">
                            {{ Form::radio('olah_raga', 'Aktif', $action == 'edit' ? $userDetail->olah_raga == 'Aktif' ? true : false : true, ['class' => 'mr-2']) }} <span class="mr-2">Aktif</span>
                            {{ Form::radio('olah_raga', 'Pasif', $action == 'edit' ? $userDetail->olah_raga == 'Pasif' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Pasif</span>
                        </div>
                        <span class="help-block">{{ ($errors->has('olah_raga') ? $errors->first('olah_raga') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('macam_olahraga') ? 'has-error' : '') }}">
                        {{ Form::label('macam_olahraga', 'Macam olah raga', ['class' => 'control-label']) }}
                        {{ Form::text('macam_olahraga', ($action == 'edit') ? $userDetail->macam_olahraga : '', ['class' => 'form-control', 'placeholder' => 'Macam olah raga', 'required']) }}
                        <span class="help-block">{{ ($errors->has('macam_olahraga') ? $errors->first('macam_olahraga') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('sakit_berat') ? 'has-error' : '') }}">
                        {{ Form::label('sakit_berat', 'Pernah sakit berat?', ['class' => 'control-label']) }}
                        <div class="d-flex align-items-center">
                            {{ Form::radio('sakit_berat', 'Ya', $action == 'edit' ? $userDetail->sakit_berat == 'Ya' ? true : false : true, ['class' => 'mr-2']) }} <span class="mr-2">Ya</span>
                            {{ Form::radio('sakit_berat', 'Tidak', $action == 'edit' ? $userDetail->sakit_berat == 'Tidak' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Tidak</span>
                        </div>
                        <span class="help-block">{{ ($errors->has('sakit_berat') ? $errors->first('sakit_berat') : '') }}</span>
                    </div>
                    <div id="input-sakit-berat-js" class="form-group {{ ($errors->has('macam_sakit_berat') ? 'has-error' : '') }}">
                        {{ Form::label('macam_sakit_berat', 'Jika Ya, Macamnya', ['class' => 'control-label']) }}
                        {{ Form::text('macam_sakit_berat', ($action == 'edit') ? $userDetail->macam_sakit_berat : '', ['class' => 'form-control', 'placeholder' => 'Macam sakit berat', 'required']) }}
                        <span class="help-block">{{ ($errors->has('macam_sakit_berat') ? $errors->first('macam_sakit_berat') : '') }}</span>
                    </div>
                    <div class="form-group {{ ($errors->has('kecelakaan_berat') ? 'has-error' : '') }}">
                        {{ Form::label('kecelakaan_berat', 'Pernah mengalami kecelakaan berat?', ['class' => 'control-label']) }}
                        <div class="d-flex align-items-center">
                            {{ Form::radio('kecelakaan_berat', 'Ya', $action == 'edit' ? $userDetail->kecelakaan_berat == 'Ya' ? true : false : true, ['class' => 'mr-2']) }} <span class="mr-2">Ya</span>
                            {{ Form::radio('kecelakaan_berat', 'Tidak', $action == 'edit' ? $userDetail->kecelakaan_berat == 'Tidak' ? true : false : false, ['class' => 'mr-2']) }} <span class="mr-2">Tidak</span>
                        </div>
                        <span class="help-block">{{ ($errors->has('kecelakaan_berat') ? $errors->first('kecelakaan_berat') : '') }}</span>
                    </div>
                    <div id="input-kecelakaan-js">
                        <div class="form-group {{ ($errors->has('jenis_kecelakaan') ? 'has-error' : '') }}">
                            {{ Form::label('jenis_kecelakaan', 'Kecelakaan apa?', ['class' => 'control-label']) }}
                            {{ Form::text('jenis_kecelakaan', ($action == 'edit') ? $userDetail->jenis_kecelakaan : '', ['class' => 'form-control', 'placeholder' => 'Keterangan kecelakaan berat', 'required']) }}
                            <span class="help-block">{{ ($errors->has('jenis_kecelakaan') ? $errors->first('jenis_kecelakaan') : '') }}</span>
                        </div>
                        <div class="form-group {{ ($errors->has('bila_mana_kecelakaan') ? 'has-error' : '') }}">
                            {{ Form::label('bila_mana_kecelakaan', 'Bilamana', ['class' => 'control-label']) }}
                            {{ Form::text('bila_mana_kecelakaan', ($action == 'edit') ? $userDetail->bila_mana_kecelakaan : '', ['class' => 'form-control', 'placeholder' => 'Bilamana', 'required']) }}
                            <span class="help-block">{{ ($errors->has('bila_mana_kecelakaan') ? $errors->first('bila_mana_kecelakaan') : '') }}</span>
                        </div>
                        <div class="form-group {{ ($errors->has('akibat_kecelakaan') ? 'has-error' : '') }}">
                            {{ Form::label('akibat_kecelakaan', 'Apa akibatnya?', ['class' => 'control-label']) }}
                            {{ Form::text('akibat_kecelakaan', ($action == 'edit') ? $userDetail->akibat_kecelakaan : '', ['class' => 'form-control', 'placeholder' => 'Akibatnya ...', 'required']) }}
                            <span class="help-block">{{ ($errors->has('akibat_kecelakaan') ? $errors->first('akibat_kecelakaan') : '') }}</span>
                        </div>
                    </div>
                </div>
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
                        @if(Auth::user()->id == 1)
                        {{ Form::submit(($action == 'create') ? 'Tambahkan Data' : 'Simpan Data', ['class' => 'btn btn-primary save-btn-js']) }}
                        @endif
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
    @if($action == 'create')
        $('#intOnly2Anak').val(0);
        $('.form-anak').hide();
    @endif

    @if($action == 'edit' && $userDetail->status == 'Belum Menikah')
        $('#isNotSingle').hide();
    @endif

    @if($action == 'edit' && $userDetail->kk_menguasai_jaringan == 'Tidak')
        $('#input-jaringan-dikuasai-js').hide();
        $('#input-jaringan-dikuasai-js').find('input[type=text]').removeAttr('required');
        $('[name=kk_jaringan_dikuasai]').val('');
    @endif

    @if($action == 'edit' && $userDetail->kk_mengarang_buku == 'Tidak')
    $('#input-karangan-buku-js').hide();
    $('#input-karangan-buku-js').find('input[type=text]').removeAttr('required');
    $('[name=kk_mengarang_buku_judul]').val('');
    $('[name=kk_mengarang_buku_penerbit]').val('');
    $('[name=kk_mengarang_buku_tahun_penerbit]').val('');
    @endif
    
    @if($action == 'edit' && $userDetail->sakit_berat == 'Tidak')
        $('#input-sakit-berat-js').hide();
        $('#input-sakit-berat-js').find('input[type=text]').removeAttr('required');
        $('[name=macam_sakit_berat]').val('');
    @endif

    @if($action == 'edit' && $userDetail->kecelakaan_berat == 'Tidak')
        $('#input-kecelakaan-js').hide();
        $('#input-kecelakaan-js').find('input[type=text]').removeAttr('required');
        $('[name=jenis_kecelakaan]').val('');
        $('[name=bila_mana_kecelakaan]').val('');
        $('[name=akibat_kecelakaan]').val('');
    @endif

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
        for(var i = 0;i < Number($('#intOnly2Anak').val());i++){
            $('.add-anak').append(html);
        }
        dob();
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

        $('.pengalaman-mengajar').append(html);
        replacefeather();
    });

    $('input[type=radio][name=kk_menguasai_jaringan]').change(function(){
        if(this.value == 'Ya'){
            $('#input-jaringan-dikuasai-js').show();
            $('#input-jaringan-dikuasai-js input[type=text]').each(function() {
                $(this).attr('required', true);
            });
        } else {
            $('#input-jaringan-dikuasai-js').hide();
            $('#input-jaringan-dikuasai-js').find('input[type=text]').removeAttr('required');
            $('[name=kk_jaringan_dikuasai]').val('');
        }
    });

    $('input[type=radio][name=kk_mengarang_buku]').change(function(){
        if(this.value == 'Ya'){
            $('#input-karangan-buku-js').show();
            $('#input-karangan-buku-js input[type=text]').each(function() {
                $(this).attr('required', true);
            });
        } else {
            $('#input-karangan-buku-js').hide();
            $('#input-karangan-buku-js').find('input[type=text]').removeAttr('required');
            $('[name=kk_mengarang_buku_judul]').val('');
            $('[name=kk_mengarang_buku_penerbit]').val('');
            $('[name=kk_mengarang_buku_tahun_penerbit]').val('');
        }
    });


    $('input[type=radio][name=sakit_berat]').change(function(){
        if(this.value == 'Ya'){
            $('#input-sakit-berat-js').show();
            $('#input-sakit-berat-js input[type=text]').each(function() {
                $(this).attr('required', true);
            });
        } else {
            $('#input-sakit-berat-js').hide();
            $('#input-sakit-berat-js').find('input[type=text]').removeAttr('required');
            $('[name=macam_sakit_berat]').val('');
        }
    });

    $('input[type=radio][name=kecelakaan_berat]').change(function(){
        if(this.value == 'Ya'){
            $('#input-kecelakaan-js').show();
            $('#input-kecelakaan-js input[type=text]').each(function() {
                $(this).attr('required', true);
            });
        } else {
            $('#input-kecelakaan-js').hide();
            $('#input-kecelakaan-js').find('input[type=text]').removeAttr('required');
            $('[name=jenis_kecelakaan]').val('');
            $('[name=bila_mana_kecelakaan]').val('');
            $('[name=akibat_kecelakaan]').val('');
        }
    });
</script>
@endsection