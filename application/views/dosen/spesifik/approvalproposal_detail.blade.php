@layout('layout.dashboard')

@section('style')
<?= HTML::style('mhsdosen/plugins/cleditor/jquery.cleditor.css'); ?>
@endsection

@section('javascript')
<?= HTML::script('mhsdosen/plugins/cleditor/jquery.cleditor.min.js'); ?>
<?= HTML::script('mhsdosen/plugins/cleditor/jquery.cleditor.icon.min.js'); ?>
<?= HTML::script('mhsdosen/plugins/cleditor/jquery.cleditor.table.min.js'); ?>
<?= HTML::script('mhsdosen/plugins/cleditor/jquery.cleditor.xhtml.min.js'); ?>
<?= HTML::script('mhsdosen/assets/js/demo/wysiwyg.js'); ?>
@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">Halaman Detail Proposal <span>Halaman untuk Melihat Detail Proposal</span></h1>
    </div>

    <div id="main-content">
        <div class="row-fluid">
            <div class="widget">
                @if(Session::has('message'))
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p id="message">{{ Session::get('message') }}</p>
                </div>
                @endif
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Detail Proposal Milik : {{ $mahasiswausers->mahasiswa->namadepan }} {{ $mahasiswausers->mahasiswa->namabelakang }}</span>
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
                                <th>File Dokumen</th>
                                <td>{{ $proposal->dokumen }} &nbsp<a href="{{ URL::to_route('downloadapprovalproposal', array(Crypter::encrypt($proposal->nim), $proposal->dokumen)) }}"><button class="btn btn-small btn-primary">DOWNLOAD</button></a>           
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Approve Proposal Judul Tugas Akhir Mahasiswa</span>
                </div>
                <div class="widget-content form-container">
                    {{ Form::open('dosen/approval/proposal/update', 'PUT', array('class' => 'form-horizontal')) }}{{ Form::token() }}
                    <input type="hidden" name="idpembimbing" value="{{ $pembimbingid }}" class="uniform">
                    <div class="control-group">
                        <label class="control-label">Status Approval</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="approval" value="1" class="uniform">
                                Approve
                            </label>
                            <label class="radio">
                                <input type="radio" name="approval" value="0" class="uniform">
                                Don't Approve
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Catatan</label>
                        <div class="controls">
                            <textarea id="cleditor" name="catatan" class="span12"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
