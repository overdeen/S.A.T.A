@layout('layout.dashboard')

@section('style')
<?= HTML::style('mhsdosen/custom-plugins/wizard/wizard.css'); ?>
@endsection

@section('javascript')
<?= HTML::script('mhsdosen/plugins/validate/jquery.validate.min.js'); ?>
<?= HTML::script('mhsdosen/custom-plugins/bootstrap-inputmask.min.js'); ?>
<?= HTML::script('mhsdosen/custom-plugins/bootstrap-fileinput.min.js'); ?>
<?= HTML::script('mhsdosen/custom-plugins/wizard/wizard.min.js'); ?>
<?= HTML::script('mhsdosen/custom-plugins/wizard/jquery.form.min.js'); ?>
<?= HTML::script('mhsdosen/assets/js/demo/form_wizard.js'); ?>
<?= HTML::script('mhsdosen/assets/js/demo/form_validation.js'); ?>
@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">
            Halaman Pengaturan Profil <span>Halaman Untuk Melakukan Pengaturan Profil Dan Akun</span>
        </h1>
    </div>

    <div id="main-content">
        <div class="profile">
            <div class="clearfix">
                <div class="profile-head clearfix">
                    <div class="profile-info pull-left">
                        <h1 class="profile-username">{{ $user->namadepan }} {{ $user->namabelakang }} <a href="https://facebook.com/{{ $profil->facebook }}" target="_blank" rel="tooltip" title="{{ $user->namadepan }} Facebook" data-placement="top"><i class="icon-facebook"></i></a> <a href="http://twitter.com/{{ $profil->twitter }}" target="_blank" rel="tooltip" title="{{ $user->namadepan }} Twitter" data-placement="top"><i class="icon-twitter"></i></a></h1>
                        <ul class="profile-attributes">
                            @if(Auth::user()->role == 3)
                            <li><i class="icos-male-contour"></i> <b>Teknik Informatika</b> Angkatan Tahun <b>{{ $profil->angkatan }}</b> --- NIM : <b style="font-size: 14px;">{{ Auth::user()->username }}</b></li>
                            @else
                            <li><i class="icos-male-contour"></i> <b>Dosen Teknik Informatika</b> --- NIP / NIDN : <b style="font-size: 14px;">{{ Auth::user()->username }}</b></li>
                            @endif
                        </ul>
                    </div>
                    <div class="btn-toolbar pull-right">

                    </div>
                </div>
                <div class="profile-sidebar">
                    <div class="thumbnail">
                        @if(empty($profil->foto))
                        {{ HTML::image(URL::base().'/sample/default.jpeg', 'Default Profil Image'); }}
                        @else
                        {{ HTML::image(URL::base().'/uploads/'.Auth::user()->username.'/'.$profil->foto, 'Profil Image'); }}
                        @endif
                    </div>
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="active"><a href="#" data-target="#profile" data-toggle="tab"><i class="icos-user"></i> {{ $user->namadepan }} {{ $user->namabelakang }} Profil</a></li>
                        <li><a href="#" data-target="#coba" data-toggle="tab"><i class="icos-cog"></i> Pengaturan Profil</a></li>
                    </ul>
                </div>
                <div class="profile-content">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            @if(Session::has('message'))
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <p id="message">{{ Session::get('message') }}</p>
                            </div>
                            @endif
                            @if($errors->has())
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                @foreach($errors->all() as $message)
                                <p id="message">{{ $message }}</p>
                                @endforeach
                            </div>
                            @endif
                            <h4 class="sub"><span>BIOGRAFI</span></h4>{{ $profil->biografi }}
                            <h4 class="sub"><span>KONTAK</span></h4>
                            <address>
                                <abbr title="Alamat">ALAMAT :</abbr> <b>{{ $profil->alamat }}</b><br><br/>
                                <abbr title="Nomor Telepon">NO. TELEPHONE :</abbr> <b>{{ $profil->notelp }}</b><br>
                                <abbr title="Nomor Handphone">NO. HANDPHONE :</abbr> <b>{{ $profil->nohp }}</b>
                            </address>
                            @if(Auth::user()->role == 2)
                            <h4 class="sub"><span>JADWAL BIMBINGAN</span></h4>
                            <div>
                                <ul>
                                    <li><b>SENIN :</b> {{ $user->senin }}</li>
                                    <li><b>SELASA :</b> {{ $user->selasa }}</li>
                                    <li><b>RABU :</b> {{ $user->rabu }}</li>
                                    <li><b>KAMIS :</b> {{ $user->kamis }}</li>
                                    <li><b>JUMAT :</b> {{ $user->jumat }}</li>
                                    <li><b>SABTU :</b> {{ $user->sabtu }}</li>
                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="coba">
                            <div id="dashboard-demo" class="tabbable analytics-tab paper-stack">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#" data-target="#editprofil" data-toggle="tab"><i class="icos-admin-user-2"></i> Edit Profil</a></li>
                                    @if(Auth::user()->role == 2)
                                    <li><a href="#" data-target="#jadwalbimbingan" data-toggle="tab"><i class="icos-calendar-today"></i> Edit Jadwal Bimbingan</a></li>
                                    @endif
                                    <li><a href="#" data-target="#changepassword" data-toggle="tab"><i class="icos-locked"></i> Edit Password</a></li>
                                    <li><a href="#" data-target="#fotoprofil" data-toggle="tab"><i class="icos-image-2"></i> Edit Foto Profil</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="editprofil" class="tab-pane active">
                                        <div class="analytics-tab-content">
                                            <div class="row-fluid">
                                                <div class="span12 widget">
                                                    <div class="widget-header">
                                                        <span class="title">Form Edit Profil</span>
                                                    </div>
                                                    <div class="widget-content form-container">
                                                        {{ Form::open('profil/update', 'PUT', array('id' => 'wizard-demo-2', 'class' => 'form-horizontal', 'data-forward-only' => 'false')) }}{{ Form::token() }}
                                                        <fieldset class="wizard-step">
                                                            <legend class="wizard-label">Profil</legend>
                                                            <div class="control-group">
                                                                <label class="control-label">Biografi <span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <textarea name="biografi" class="required span12" minlength="10"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Alamat <span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="alamat" value="{{ $profil->alamat }}" class="required span12" />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Nomor Telepon <span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="notelp" id="input26" value="{{ $profil->notelp }}" class="required span12">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Nomor Handphone <span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="nohape" id="input26" value="{{ $profil->nohp }}" class="required span12">
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset class="wizard-step">
                                                            <legend class="wizard-label">Sosial Media</legend>
                                                            <div class="control-group">
                                                                <label class="control-label">Facebook <span class="required"></span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="facebook" value="{{ $profil->facebook }}" id="input11">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">twitter <span class="required"></span></label>
                                                                <div class="controls">
                                                                    <div class="input-prepend">
                                                                        <span class="add-on">@</span><input type="text" name="twitter" value="{{ $profil->twitter }}" id="input11">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset class="wizard-step">
                                                            <legend class="wizard-label">Konfirmasi</legend>
                                                            <div class="control-group">
                                                                <label class="control-label">Password Anda <span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="password" name="password" id="input11" class="span12 required">
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        {{ Form::close() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(Auth::user()->role == 2)
                                    <div id="jadwalbimbingan" class="tab-pane">
                                        <div class="analytics-tab-content">
                                            <div class="row-fluid">
                                                <div class="span12 widget">
                                                    <div class="widget-header">
                                                        <span class="title">Form Edit Jadwal Bimbingan</span>
                                                    </div>
                                                    <div class="widget-content form-container">
                                                        {{ Form::open('profil/update/jadwalbimbingan', 'PUT', array('class' => 'form-horizontal')) }}{{ Form::token() }}
                                                        <fieldset>
                                                            <div class="control-group">
                                                                <label class="control-label"><i>Contoh</i></label>
                                                                <div class="controls">
                                                                    <input type="text" value="09.00 - 15.00 Ruang Dosen" class="span12" disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset class="da-form-inline">
                                                            <div class="control-group">
                                                                <label class="control-label"><b>Senin</b></label>
                                                                <div class="controls">
                                                                    <input type="text" name="senin" class="span12" value="{{ $user->senin }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label"><b>Selasa</b></label>
                                                                <div class="controls">
                                                                    <input type="text" name="selasa" class="span12" value="{{ $user->selasa }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label"><b>Rabu</b></label>
                                                                <div class="controls">
                                                                    <input type="text" name="rabu" class="span12" value="{{ $user->rabu }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label"><b>Kamis</b></label>
                                                                <div class="controls">
                                                                    <input type="text" name="kamis" class="span12" value="{{ $user->kamis }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label"><b>Jumat</b></label>
                                                                <div class="controls">
                                                                    <input type="text" name="jumat" class="span12" value="{{ $user->jumat }}"/>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label"><b>Sabtu</b></label>
                                                                <div class="controls">
                                                                    <input type="text" name="sabtu" class="span12" value="{{ $user->sabtu }}"/>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="form-actions">
                                                            <input type="reset" value="RESET" class="btn" />
                                                            <input type="submit" value="SIMPAN JADWAL BIMBINGAN" class="btn btn-primary pull-right" />
                                                        </div>
                                                        {{ Form::close() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div id="changepassword" class="tab-pane">
                                        <div class="analytics-tab-content">
                                            <div class="row-fluid">
                                                <div class="span12 widget">
                                                    <div class="widget-header">
                                                        <span class="title">Form Edit Password</span>
                                                    </div>
                                                    <div class="widget-content form-container">
                                                        {{ Form::open('profil/update/password', 'PUT', array('id' => 'validate-4', 'class' => 'form-horizontal')) }}{{ Form::token() }}
                                                        <fieldset>
                                                            <div class="control-group">
                                                                <label class="control-label">Password Lama <span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="password" name="passwordlama" class="span12" />
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset class="da-form-inline">
                                                            <div class="control-group">
                                                                <label class="control-label">Password Baru <span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input id="passwordbaru" type="password" name="passwordbaru" class="span12" />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Confirm Password <span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="password" name="cpasswordbaru" class="span12" />
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="form-actions">
                                                            <input type="reset" value="RESET" class="btn" />
                                                            <input type="submit" value="UBAH PASSWORD" class="btn btn-primary pull-right" />
                                                        </div>
                                                        {{ Form::close() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="fotoprofil" class="tab-pane">
                                        <div class="analytics-tab-content">
                                            <div class="row-fluid">
                                                <div class="span12 widget">
                                                    <div class="widget-header">
                                                        <span class="title">Form Edit Foto Profil</span>
                                                    </div>
                                                    <div class="widget-content form-container">
                                                        {{ Form::open_for_files('profil/update/foto', 'PUT', array('id' => 'validate-1', 'class' => 'form-horizontal')) }}{{ Form::token() }}
                                                        <fieldset>
                                                            <div class="control-group">
                                                                <label class="control-label">Password Anda <span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="password" name="password" id="input11" class="required span12">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Upload Foto</label>
                                                                <div class="controls">
                                                                    <input type="file" name="foto" data-provide="fileinput" class="required"> &nbsp;<span class="badge badge-important">File .Jpg Dan Max 1 MB</span>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="form-actions">
                                                            <input type="reset" value="RESET" class="btn" />
                                                            <input type="submit" value="UPLOAD FOTO" class="btn btn-primary pull-right" />
                                                        </div>
                                                        {{ Form::close() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div><i class="icos-alarm-clock"></i> Profil Terakhir Diupdate Pada <b>{{ $profil->updated_at }}</b></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
