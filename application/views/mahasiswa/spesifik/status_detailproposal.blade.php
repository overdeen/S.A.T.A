@layout('layout.dashboard')

@section('style')

@endsection

@section('javascript')
<?= HTML::script('mhsdosen/custom-plugins/bootstrap-fileinput.min.js'); ?>
<?= HTML::script('mhsdosen/plugins/validate/jquery.validate.min.js'); ?>
<?= HTML::script('mhsdosen/assets/js/demo/form_validation.js'); ?>
@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">Halaman Status Dan Detail Proposal <span>Halaman untuk Melihat Status Approval Dan Detail Proposal</span></h1>
    </div>

    <div id="main-content">
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
        <div class="profile">
            <div class="clearfix">
                <div class="profile-head clearfix">
                    <div class="profile-info pull-left">
                        <h1 class="profile-username">{{ $profiluser->mahasiswa->namadepan }} {{ $profiluser->mahasiswa->namabelakang }} <a href="https://facebook.com/{{ $profiluser->mahasiswa->user->profil->facebook }}" target="_blank" rel="tooltip" title="{{ $profiluser->mahasiswa->namadepan }} Facebook" data-placement="top"><i class="icon-facebook"></i></a> <a href="http://twitter.com/{{ $profiluser->mahasiswa->user->profil->twitter }}" target="_blank" rel="tooltip" title="{{ $profiluser->mahasiswa->namadepan }} Twitter" data-placement="top"><i class="icon-twitter"></i></a></h1>
                        <ul class="profile-attributes">
                            <li><i class="icos-male-contour"></i> <b>Teknik Informatika</b> Angkatan Tahun <b>{{ $profiluser->mahasiswa->user->profil->angkatan }}</b> --- NIM : <b style="font-size: 14px;">{{ $profiluser->mahasiswa->user->username }}</b></li>
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
                        {{ HTML::image(URL::base().'/uploads/'.$profiluser->mahasiswa->user->username.'/'.$profiluser->mahasiswa->user->profil->foto, 'Profil Image'); }}
                        @endif
                    </div>
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="active"><a href="#" data-target="#profile" data-toggle="tab"><i class="icos-user"></i>{{ $profiluser->mahasiswa->namadepan }} {{ $profiluser->mahasiswa->namabelakang }} Profil</a></li>
                    </ul>
                </div>
                <div class="profile-content">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <h4 class="sub"><span>BIOGRAFI</span></h4>{{ $profiluser->mahasiswa->user->profil->biografi }}
                            <h4 class="sub"><span>KONTAK</span></h4>
                            <address>
                                <abbr title="Alamat">ALAMAT :</abbr> <b>{{ $profiluser->mahasiswa->user->profil->alamat }}</b><br><br/>
                                <abbr title="Nomor Telepon">NO. TELEPHONE :</abbr> <b>{{ $profiluser->mahasiswa->user->profil->notelp }}</b><br>
                                <abbr title="Nomor Handphone">NO. HANDPHONE :</abbr> <b>{{ $profiluser->mahasiswa->user->profil->nohp }}</b>
                            </address>
                        </div>
                    </div>
                    <div><i class="icos-alarm-clock"></i> Profil Terakhir Diupdate Pada <b>{{ $profiluser->mahasiswa->user->profil->updated_at }}</b></div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Detail Proposal Judul Tugas Akhir</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped table-detail-view">
                        <thead>
                            <tr><th colspan="2"><i class="icol-doc-text-image"></i> Informasi Proposal Judul Tugas Akhir</th></tr>
                        </thead>
                        <tbody>
                            <tr><th>Judul</th><td>{{ $proposal->judul }}</td></tr>
                            <tr><th>Deskripsi</th><td>{{ $proposal->deskripsi }}</td></tr>
                            <tr><th>Tahun</th><td>{{ $proposal->tahun }}</td></tr>
                            <tr><th>Ditambahkan Pada</th><td>{{ $proposal->created_at }}</td></tr>
                        </tbody>
                        <thead>
                            <tr><th colspan="2"><i class="icol-user"></i> Informasi Mahasiswa Pemilik Proposal Judul Tugas Akhir</th></tr>
                        </thead>
                        <tbody>
                            <tr><th>Nomor Induk Mahasiswa</th><td>{{ $mahasiswausers->username }}</td>
                            </tr>
                            <tr><th>Nama Depan</th><td>{{ $mahasiswausers->mahasiswa->namadepan }}</td>
                            </tr>
                            <tr><th>Nama Belakang</th><td>{{ $mahasiswausers->mahasiswa->namabelakang }}</td>
                            </tr>
                            <tr><th>Angkatan</th><td>{{ $mahasiswausers->profil->angkatan }}</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr><th colspan="2"><i class="icol-drive"></i> Data Proposal Judul Tugas Akhir</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Download Proposal</th>
                                @if(Auth::user()->username != $mahasiswausers->username)
                                <td>{{ $proposal->dokumen }} &nbsp<button class="btn btn-small btn-primary" disabled>DOWNLOAD</button> &nbsp<i>--- maaf anda bukan pemilik dokumen ---</i>
                                    @else
                                <td>{{ $proposal->dokumen }} &nbsp<a href="{{ URL::to_route('downloadproposal', Crypter::encrypt($proposal->dokumen)) }}"><button class="btn btn-small btn-primary">DOWNLOAD</button></a>
                                    @endif            
                            </tr>
                            <tr>
                                <th>Update Proposal</th>
                                @if(Auth::user()->username != $mahasiswausers->username)
                                <td>{{ $proposal->dokumen }} &nbsp<button class="btn btn-small btn-primary" disabled>UPDATE PROPOSAL</button> &nbsp<i>--- maaf anda bukan pemilik dokumen ---</i></td>
                                @else
                                @if(empty($datadaftar))
                                <td>{{ $proposal->dokumen }} &nbsp<button class="btn btn-small btn-info" data-target="#update-proposal" data-toggle="modal">UPDATE PROPOSAL</button> &nbsp;( Update File Proposal Hanya Jika Mahasiswa Belum Mendaftar Seminar Proposal )
                                    @else
                                <td>{{ $proposal->dokumen }} &nbsp<button class="btn btn-small btn-info" disabled>UPDATE PROPOSAL</button> &nbsp;( Anda Telah Terdaftar Di Seminar Proposal )
                                    @endif
                                    @endif            
                            </tr>
                        </tbody>
                    </table>
                    <div id="update-proposal" class="modal hide">
                        <div class="span12 widget">
                            <div class="widget-header">
                                <span class="title"><i class="icol-arrow-right"></i>Form Update File Proposal</span>
                            </div>
                            <div class="widget-content form-container">
                                {{ Form::open_for_files('proposal/update', 'PUT', array('id' => 'validate-1', 'class' => 'form-horizontal')) }}{{ Form::token() }}
                                <fieldset>
                                    <input type="hidden" name="idproposal" value="{{ $proposal->id }}">
                                    <div class="control-group">
                                        <label class="control-label">Password Anda <span class="required">*</span></label>
                                        <div class="controls">
                                            <input type="password" name="password" id="input11" class="required span12">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">File Proposal</label>
                                        <div class="controls">
                                            <input type="file" id="input04" name="fileproposal" data-provide="fileinput" class="required"><br/><br/><span class="badge badge-important">Dokumen .Doc / .Docx</span>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-actions">
                                    <input type="submit" value="UPDATE PROPOSAL" class="btn btn-primary pull-right" />
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <div id="lupapassword" class="modal hide">
                        <div class="span12 widget">
                            <div class="widget-header">
                                <span class="title"><i class="icol-arrow-right"></i>Form Lupa Password</span>
                            </div>
                            <div class="widget-content form-container">
                                {{ Form::open('lupa/password', 'POST', array('id' => 'validate-1', 'class' => 'form-horizontal')) }}{{ Form::token() }}
                                <fieldset>
                                    <input type="hidden" name="nim" value="{{ Auth::user()->username }}">
                                    <div class="control-group">
                                        <label class="control-label">Email Terdaftar</label>
                                        <div class="controls">
                                            <input type="email" name="email" class="span12" required>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-actions">
                                    <input type="submit" value="KIRIM PASSWORD" class="btn btn-primary pull-right" />
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::user()->username != $mahasiswausers->username)
        <!--No Data-->
        @else
        @if ($countpembimbingapp != 2)
        <!--No Data-->
        @else
        <div class="widget">
            <div class="widget-content form-container">
                <form class="form-horizontal">
                    <div class="control-group">
                        <center>Persyaratan Untuk Mendaftar Seminar Proposal Telah Terpenuhi ( <b>2 Tanda Persetujuan / <i>Approval</i></b> )<br/>Silahkan Mendaftar Melalui Tombol Dibawah Atau Memilih Menu <b><a href="{{ URL::to_route('daftarsempro') }}" rel="tooltip" data-placement="top" title="Pendaftaran Seminar Proposal">Daftar Seminar Proposal</a></b></center>
                    </div>
                    <div class="control-group">
                        @if(empty($datadaftar))
                        <center><a href="{{ URL::to_route('daftarsempro') }}" class="btn btn-large btn-success">DAFTAR SEMINAR PROPOSAL</a></center>
                        @else
                        <center><a class="btn btn-large btn-success" disabled>TERDAFTAR DI SEMINAR PROPOSAL</a></center>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        @endif
        @endif       
        @if(Auth::user()->username != $mahasiswausers->username)
        <!--No Data-->
        @else
        @if($countpembimbing != 0)
        <div class="row-fluid">
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Dosen Pembimbing 1 Dan Status Approval</span>
                </div>
                <div class="widget-content user-box">
                    <div class="thumbnail">
                        @if( $dosenarray['approval1'] == 1 )
                        <img alt="" src="{{ URL::base() }}/sample/approve.jpg">
                        @else
                        <img alt="" src="{{ URL::base() }}/sample/noapprove.jpg">
                        @endif
                    </div>
                    <div class="info">
                        <span class="name">{{ $dosenarray['fullnamedosen1'] }}<small>NIP / NIDN : <b>{{ $dosenarray['nipdosen1'] }}</b></small></span>
                        <ul class="attributes">
                            <li><abbr title="Catatan Dari Dosen"><b>CATATAN :</b></abbr> {{ $dosenarray['catatandosen1'] }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Dosen Pembimbing 2 Dan Status Approval</span>
                </div>
                @if ($countpembimbing != 2)
                <div class="widget-content user-box">Anda Belum Memilih Dosen Pembimbing</div>
                @else
                <div class="widget-content user-box">
                    <div class="thumbnail">
                        @if( $dosenarray['approval2'] == 1 )
                        <img alt="" src="{{ URL::base() }}/sample/approve.jpg">
                        @else
                        <img alt="" src="{{ URL::base() }}/sample/noapprove.jpg">
                        @endif
                    </div>
                    <div class="info">
                        <span class="name">{{ $dosenarray['fullnamedosen2'] }}<small>NIP / NIDN : <b>{{ $dosenarray['nipdosen2'] }}</b></small></span>
                        <ul class="attributes">
                            <li><abbr title="Catatan Dari Dosen"><b>CATATAN :</b></abbr> {{ $dosenarray['catatandosen2'] }}</li>
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="row-fluid">
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Dosen Pembimbing 1 Dan Status Approval</span>
                </div>
                <div class="widget-content user-box"><b>Anda Belum Memilih Dosen Pembimbing 1</b></div>
            </div>
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Dosen Pembimbing 2 Dan Status Approval</span>
                </div>
                <div class="widget-content user-box"><b>Anda Belum Memilih Dosen Pembimbing 2</b></div>
            </div>
        </div>
        @endif
        @endif
    </div>
</section>
@endsection

@section('script')

@endsection
