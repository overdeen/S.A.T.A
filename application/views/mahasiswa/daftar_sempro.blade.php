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
            Halaman Daftar Seminar Proposal<span>Halaman Untuk Melakukan Pendaftaran Seminar Proposal</span>
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
            @elseif($countpembimbingapp != 2)
            <div class="widget">
                <div class="widget-content form-container">
                    <div class="control-group">
                        <span class="badge badge-warning">Peringatan !!</span>&nbsp;&nbsp; <b>Anda Belum Mendapatkan <span class="badge badge-info">2 Approval</span>. Anda Dapat Melihat Status Proposal Melalui Menu <a href="{{ URL::to_route('proposalmahasiswa') }}"> Manage Proposal</a></b>
                    </div>
                </div>
            </div>
            @else
            <div class="span12 widget">
                <div class="widget">
                    <div class="widget-content form-container">
                        <div class="control-group">
                            <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Melakukan Pendaftaran Seminar Proposal</b>
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
                    <span class="title"><i class="icol-arrow-right"></i>Form Pendaftaran Seminar Proposal Judul Tugas Akhir</span>
                </div>
                <div class="widget-content form-container">
                    {{ Form::open_for_files('daftar/sempro', 'POST', array('id' => 'validate-5', 'class' => 'form-horizontal')) }}{{ Form::token() }}
                    <fieldset>
                        <legend>Detail Informasi Proposal Judul Tugas Akhir Mahasiswa</legend>
                        <input type="hidden" name="idproposal" value="{{ $proposal->id }}"/>
                        <div class="control-group">
                            <label class="control-label">Nama Mahasiswa</label>
                            <div class="controls">
                                <input type="text" name="nama" class="span5" value="{{ $user->namadepan }} {{ $user->namabelakang }}" readonly="readonly"/> &nbsp;<input type="text" class="span2" value="{{ Auth::user()->username }}" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Judul Proposal</label>
                            <div class="controls">
                                <textarea id="pass2" name="judul" readonly="readonly" class="span12">{{ $proposal->judul }}</textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Kategori Pendaftaran</label>
                            <div class="controls">
                                <input type="hidden" name="kategori" value="1" />
                                <span class="badge badge-important">Seminar Proposal</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">File Proposal</label>
                            <div class="controls">
                                <input type="text" name="dokumen" value="{{ $proposal->dokumen }}"  class="span4" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <label class="checkbox">
                                    <input type="checkbox" id="cekdaftar" name="cekdaftar" class="uniform"> Saya Siap Mendaftar Seminar Proposal judul Tugas Akhir
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions">
                        @if(empty($datadaftar))
                        <input type="submit" value="Daftar Seminar Proposal" class="btn btn-primary pull-right" onclick="return confirm('Apakah Anda Yakin Akan Mendaftar Seminar Proposal ?');"/>
                        @else
                        <input type="submit" value="Anda Telah Terdaftar Di Seminar Proposal" class="btn btn-primary pull-right" disabled/>
                        @endif
                    </div>
                    @if(!empty($datadaftar))
                    <fieldset>
                        <div class="control-group">
                            Silahkan Anda Melihat Jadwal Seminar Proposal Pada Menu <b><a href="{{ URL::to_route('jadwalsempro') }}">Jadwal Seminar Proposal</a></b>, dan Anda Dapat Melihat Hasil Sempro Pada Menu <b><a href="{{ URL::to_route('hasilsempro') }}">Hasil Seminar Proposal</a></b>
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
