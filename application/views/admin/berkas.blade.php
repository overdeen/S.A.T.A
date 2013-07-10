@layout('layout.admin.dashboard')

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
            Halaman Berkas Persyaratan <span>Halaman Untuk Melakukan Pengaturan Berkas Persyaratan</span>
        </h1>
    </div>
    <div id="main-content">
        <div class="widget">
            @if(Session::has('message'))
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p id="message">{{ Session::get('message') }}</p>
            </div>
            @endif
            <div class="widget-content form-container">
                <div class="control-group">
                    <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Menambahkan Berkas Persyaratan Dari Seminar Proposal Atau Seminar Hasil Dan Ujian Tugas Akhir</b>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span7 widget">
                <div class="widget-header">
                    <span class="title">Form Tambah Berkas Persyaratan</span>
                </div>
                <div class="widget-content form-container">
                    {{ Form::open_for_files('admin/berkas/add', 'POST', array('id' => 'validate-5', 'class' => 'form-horizontal')) }}{{ Form::token() }}
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label">Nama Berkas</label>
                            <input type="hidden" name="idadmin" value="{{ $user->id }}"/>
                            <div class="controls">
                                <input type="text" name="namaberkas" class="span12" required/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Kategori</label>
                            <div class="controls">
                                <label class="radio">
                                    <input type="radio" name="kategori" value="1" class="uniform">
                                    Berkas Seminar Hasil & Ujian TA
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">File Berkas</label>
                            <div class="controls">
                                <input type="file" name="fileberkas" data-provide="fileinput" class="required">
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions">
                        <input type="submit" value="Tambah Berkas Persyaratan" class="btn btn-primary pull-right"/>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="span5 widget">
                <div class="widget-header">
                    <span class="title">Daftar Berkas Persyaratan</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($berkass))
                            <td>Tidak Ada Data</td>
                            <td></td>
                            <td></td>
                            @else
                            @foreach($berkass as $berkas)
                            <tr>
                                <td><a href="{{ URL::to_route('downloadberkas', array(Crypter::encrypt($berkas->kategori), $berkas->file)) }}">{{ Str::words($berkas->nama, 3) }}</a></td>
                                <td>
                                    @if($berkas->kategori == 1)
                                    <span class="badge badge-success">Semhas</span> <span class="badge badge-warning">Ujian TA</span>
                                    @endif
                                </td>
                                <td class="action-col">
                                    <span class="btn-group">
                                        <a href="{{ URL::to_route('hapusberkas', Crypter::encrypt($berkas->id)) }}" title="Hapus Berkas Persyaratan" class="btn btn-small" onclick="return confirm('Apakah Anda Yakin Akan Menghapus File Berkas Persyaratan ?');"><i class="icos-acces-denied-sign"></i></a>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
