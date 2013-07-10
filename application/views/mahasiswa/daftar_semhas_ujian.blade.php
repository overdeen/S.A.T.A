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
        <h1 id="main-heading">
            Halaman Daftar Seminar Hasil Dan Ujian TA<span>Halaman Untuk Melakukan Pendaftaran Seminar Hasil Dan Ujian TA</span>
        </h1>
    </div>

    <div id="main-content">
        <div class="row-fluid">
            @if(empty($proposal))
            <div class="widget">
                <div class="widget-content form-container">
                    <div class="control-group">
                        <span class="badge badge-warning">Peringatan !!</span>&nbsp;&nbsp; <b>Anda Diharuskan Menambahkan Proposal Judul Tugas Akhir Terlebih Dahulu. Silahkan Menambahkan Proposal Melalui Menu <a href="">Tambah Proposal</a></b>
                    </div>
                </div>
            </div>
            @elseif(empty($datadaftarsempro))
            <div class="widget">
                <div class="widget-content form-container">
                    <div class="control-group">
                        <span class="badge badge-warning">Peringatan !!</span>&nbsp;&nbsp; <b>Anda Diharuskan Mendaftar Seminar Proposal Terlebih Dahulu. Silahkan Mendaftar Seminar Proposal Melalui Menu <a href="">Daftar Seminar Proposal</a></b>
                    </div>
                </div>
            </div>
            @elseif($jmlrekom != 2)
            <div class="widget">
                <div class="widget-content form-container">
                    <div class="control-group">
                        <span class="badge badge-warning">Peringatan !!</span>&nbsp;&nbsp; <b>Anda Belum Mendapatkan <span class="badge badge-info">2 Rekomendasi</span> Semhas & Ujian TA. Anda Dapat Melihat Rekomendasi Melalui Menu <a href="{{ URL::to_route('bimbingan') }}">SK & Asistensi Bimbingan</a>.</b>
                    </div>
                </div>
            </div>
            @else
            <div class="span12 widget">
                <div class="widget">
                    <div class="widget-content form-container">
                        <div class="control-group">
                            <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Melakukan Pendaftaran Seminar Hasil Dan Ujian Tugas Akhir</b>
                        </div>
                    </div>
                </div>
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
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Form Daftar Seminar Hasil Dan Ujian TA</span>
                    @if(empty($berkasall))
                    @else
                    <div class="toolbar">
                        <div class="btn-group">
                            <span class="btn dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-pencil"></i> &nbsp; Menu Daftar Semhas Dan Ujian TA &nbsp;<i class="caret"></i>
                            </span>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="" data-target="#myModal" data-toggle="modal"><i class="icol-magnifier"></i> Download Berkas Persyaratan</a></li>
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
                <div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                    <div class="modal-header">
                        <h3 id="myModalLabel">Daftar Berkas Persyaratan</h3>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Berkas</th>
                                    <th>Kategori</th>
                                    <th>Ditambahkan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($berkasall as $berkas)
                                <tr>
                                    <td><a href="{{ URL::to_route('downloadberkaspersyaratan', array(Crypter::encrypt($berkas->kategori), $berkas->file)) }}" rel="tooltip" title="Download File" data-placement="top">{{ $berkas->nama }}</a></td>
                                    <td>
                                        @if($berkas->kategori == 1) 
                                        <span class="badge badge-success">Semhas</span> <span class="badge badge-warning">Ujian TA</span>                                      
                                        @endif
                                    </td>
                                    <td>{{ date("d-m-Y", strtotime($berkas->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer"></div>
                </div>
                <div class="widget-content form-container">
                    {{ Form::open_for_files('daftar/semhas_ujian', 'PUT', array('id' => 'validate-5', 'class' => 'form-horizontal')) }}{{ Form::token() }}
                    <fieldset>
                        <legend>Info Proposal Mahasiswa</legend>
                        <input type="hidden" name="iddaftar" value="{{ $datadaftarsempro->id }}"/>
                        <div class="control-group">
                            <label class="control-label">Nama Mahasiswa</label>
                            <div class="controls">
                                <input type="text" name="nama" class="span5" value="{{ $user->namadepan }} {{ $user->namabelakang }}" readonly="readonly"/> &nbsp;<input type="text" class="span2" value="{{ Auth::user()->username }}" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Judul Proposal</label>
                            <div class="controls">
                                <input type="text" id="pass2" name="judul" value="{{ $proposal->judul }}" class="span12" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Kategori Pendaftaran</label>
                            <div class="controls">
                                <input type="hidden" name="kategori" value="1" />
                                <span class="badge badge-important">Seminar Hasil</span> <span class="badge badge-warning">Ujian TA</span>
                            </div>
                        </div>
                        @if(empty($berkasall))
                        @else
                        <div class="control-group">
                            <label class="control-label">Status File</label>
                            <div class="controls">
                                <b>Terdapat File Persyaratan Pendaftaran Semhas Dan Ujian TA. File Dapat Anda Download Pada Menu Daftar Semhas Dan Ujian TA Di Pojok Kanan Atas.</b>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">File Persyaratan</label>
                            <div class="controls">
                                <input type="file" name="filesyarat" data-provide="fileinput" required> &nbsp;&nbsp;&nbsp;<b>*Harus Dikompress Dalam Bentuk .zip</b>
                            </div>
                        </div>
                        @endif
                        <div class="control-group">
                            <div class="controls">
                                <label class="checkbox">
                                    <input type="checkbox" id="cekdaftar" name="cekdaftar" class="uniform"> Saya Siap Mendaftar Seminar Hasil Dan Ujian Tugas Akhir
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions">
                        @if(empty($datadaftarsemhasujian))
                        @if($datahasil->hasil_sempro == 3)
                        <input type="submit" value="Daftar Seminar Hasil Dan Ujian" class="btn btn-primary pull-right" disabled/>
                        @else
                        <input type="submit" value="Daftar Seminar Hasil Dan Ujian" class="btn btn-primary pull-right" onclick="return confirm('Apakah Anda Yakin Akan Mendaftar Seminar Hasil & Ujian TA ?');"/>
                        @endif
                        @else
                        <input type="submit" value="Anda Telah Terdaftar Di Seminar Hasil Dan Ujian TA" class="btn btn-primary pull-right" disabled/>
                        @endif
                    </div>
                    @if($datahasil->hasil_sempro == 3)
                    <div class="form-actions">
                        asdasd
                    </div>
                    @endif
                    @if(!empty($datadaftarsemhasujian))
                    <fieldset>
                        <div class="control-group">
                            Silahkan Anda Melihat Jadwal Pada Menu <b><a href="{{ URL::to_route('jadwalsemhas') }}">Jadwal Seminar Hasil</a></b> Atau <b><a href="{{ URL::to_route('jadwalujian') }}">Jadwal Ujian TA</a></b>, dan Anda Dapat Melihat Hasil Ujian TA Pada Menu <b><a href="{{ URL::to_route('hasilujian') }}">Hasil Ujian TA</a></b>
                        </div>
                    </fieldset>
                    @endif
                    {{ Form::close() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
