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
            Halaman Pengaturan Proposal <span>Halaman Untuk Melakukan Pengaturan Proposal Mahasiswa</span>
        </h1>
    </div>

    <div id="main-content">
        <div class="row-fluid">
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
            <div class="widget">
                <div class="widget-content form-container">
                    <form class="form-horizontal">
                        <div class="control-group">
                            <ul>
                                <li>Melihat Apakah Judul Tugas Akhir Milik Anda Sudah Ada yang Menggunakan. Anda Dapat Melihat Melalui Menu <a href="{{ URL::to_route('TAterdaftar') }}"> Judul TA Terdaftar</a>.</li>
                                <li>Menambahkan Proposal Dengan Menekan Tombol <b>TAMBAH PROPOSAL</b> Dibawah Jika Anda Belum Menambahkan.</li>
                                <li>Menambahkan Dosen Pembimbing Untuk <b><i>Approval</i></b> Terhadap Proposal Anda. Anda Dapat Melihat Melalui Menu <a href="{{ URL::to_route('dosenpembimbing') }}"> Dosen Pembimbing</a>.</li>
                                <li>Melakukan Pendaftaran Seminar Proposal Jika 2 Orang Dosen Pengampu Telah Memberikan <b><i>Approval</i> / Tanda Persetujuan</b> Terhadap Proposal Anda.</li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            @if(empty($proposal))
            <div class="widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Proposal Milik : {{ $user->namadepan }} {{ $user->namabelakang }}</span>
                </div>
                <div class="widget-content form-container">
                    <form class="form-horizontal">
                        <div class="control-group">
                            <center><b>ANDA HARUS MENAMBAHKAN PROPOSAL JUDUL TUGAS AKHIR ANDA TERLEBIH DAHULU</b></center>
                        </div>
                        <div class="control-group">
                            <center><button data-target="#header-modal" data-toggle="modal" class="btn btn-large btn-danger">TAMBAH PROPOSAL</button></center>
                        </div>
                    </form>
                    <div id="header-modal" class="modal hide">
                        <div class="span12 widget">
                            <div class="widget-header">
                                <span class="title"><i class="icol-arrow-right"></i>Form Tambah Proposal</span>
                            </div>
                            <div class="widget-content form-container">
                                {{ Form::open_for_files('proposal/add', 'POST', array('id' => 'wizard-demo-2', 'class' => 'form-horizontal', 'data-forward-only' => 'false')) }}
                                {{ Form::token() }}
                                <fieldset class="wizard-step">
                                    <legend class="wizard-label">Data Proposal</legend>
                                    <div class="control-group">
                                        <label class="control-label">NIM</label>
                                        <div class="controls">
                                            <input type="text" name="nim" value="{{ Auth::user()->username }}" readonly="readonly" class="required span4"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Judul Proposal <span class="required">*</span></label>
                                        <div class="controls">
                                            <input type="text" name="judul" class="required span12" minlength="30"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Deskripsi <span class="required">*</span></label>
                                        <div class="controls">
                                            <textarea type="text" name="deskripsi" id="input26" class="required span12" minlength="30"></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Tahun</label>
                                        <div class="controls">
                                            <input type="text" name="tahun" value="{{ date('Y') }}" id="input26" class="span3" readonly="readonly">
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="wizard-step">
                                    <legend class="wizard-label">Upload Dokumen</legend>
                                    <div class="control-group">
                                        <label class="control-label">Dokumen <span class="required">*</span></label>
                                        <div class="controls">
                                            <input type="file" id="input04" name="dokumen" data-provide="fileinput" class="required"><br/><br/><span class="badge badge-important">Dokumen .Doc / .Docx</span>
                                        </div> 
                                    </div>
                                </fieldset>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Proposal Milik : {{ $user->namadepan }} {{ $user->namabelakang }}</span>
                    <div class="toolbar">
                        <div class="btn-group">
                            <span class="btn dropdown-toggle" data-toggle="dropdown">
                                <i class="icos-arrow-down icos-white"></i> &nbsp; Menu Proposal &nbsp;<i class="caret"></i>
                            </span>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ URL::to_route('lihatstatus', Crypter::encrypt($proposal->id)) }}"><i class="icol-magnifier"></i> Lihat Status Approval  & Detail Proposal</a></li>
                                <li><a href="{{ URL::to_route('deleteproposal', Crypter::encrypt($proposal->id)) }}" onclick="return confirm('Apakah Anda Yakin Akan Menghapus Proposal Judul Tugas Akhir Anda ?');"><i class="icol-cross"></i> Hapus Proposal Judul Tugas Akhir</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped table-detail-view">
                        <thead>
                            <tr>
                                <th colspan="2"><i class="icol-exclamation"></i> Informasi Proposal Judul Tugas Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Judul Tugas Akhir</th>
                                <td>{{ $proposal->judul }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ Str::words($proposal->deskripsi, 10); }}</td>
                            </tr>
                            <tr>
                                <th>Tahun</th>
                                <td>{{ $proposal->tahun }}</td>
                            </tr>
                            <tr>
                                <th>Ditambahkan Pada</th>
                                <td>{{ $proposal->created_at }}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>Lihat Selengkapnya Di <b>Halaman Status Approval dan Detail Proposal</b> ( Menu Proposal -> Lihat Status Approval & Detail Proposal )</td>
                            </tr>
                            <tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
