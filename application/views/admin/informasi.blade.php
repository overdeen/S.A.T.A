@layout('layout.admin.dashboard')

@section('style')
<?= HTML::style('mhsdosen/plugins/cleditor/jquery.cleditor.css'); ?>
@endsection

@section('javascript')
<?= HTML::script('mhsdosen/custom-plugins/bootstrap-fileinput.min.js'); ?>
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
        <h1 id="main-heading">
            Halaman Informasi <span>Halaman Untuk Melakukan Pengaturan Informasi</span>
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
            @if($errors->has())
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                @foreach($errors->all() as $message)
                <p id="message">{{ $message }}</p>
                @endforeach
            </div>
            @endif
            <div class="widget-content form-container">
                <div class="control-group">
                    <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Menambahkan Informasi Terkait Tugas Akhir Teknik Informatika</b>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icon-edit"></i> Tambahkan Informasi Baru</span>
                </div>
                <div class="widget-content form-container">
                    @if($detailinfo == 'not detail')
                    {{ Form::open_for_files('admin/informasi', 'POST', array('class' => 'form-vertical')) }}{{ Form::token() }}
                    @else
                    {{ Form::open_for_files('admin/informasi', 'PUT', array('class' => 'form-vertical')) }}{{ Form::token() }}
                    @endif
                    @if($detailinfo == 'not detail') <input type="hidden" name="id" value="{{ $user->id }}"> @else <input type="hidden" name="id" value="{{ $detailinfo->id }}"> @endif
                    <div class="control-group">
                        <label class="control-label">Judul Informasi</label>
                        <div class="controls">
                            @if($detailinfo == 'not detail') <input type="text" name="judul" class="span12" required> @else <input type="text" name="judul" class="span12" value="{{ $detailinfo->judul }}"> @endif
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Isi Informasi</label>
                        <div class="controls">
                            <textarea id="cleditor" name="isi" required>@if($detailinfo == 'not detail') @else {{ $detailinfo->isi }} @endif</textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">File Berkas Informasi ( Jika Ada )</label>
                        <div class="controls">
                            <input type="file" name="fileinformasi" data-provide="fileinput"><span class="badge badge-important">File Dokumen ( .Doc , .Xls , .Ppt )</span>
                        </div>
                    </div>
                    <div class="form-actions">
                        @if($detailinfo == 'not detail')
                        <button type="submit" class="btn btn-primary">Tambah Informasi</button>
                        @else
                        <button type="submit" class="btn btn-primary">Update Informasi</button>
                        <a href="{{ URL::to_route('informasi') }}" class="btn btn-primary">Informasi Baru</a>
                        @endif                       
                    </div>
                    {{ Form::close() }}
                </div>									
            </div>
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Daftar Informasi Terbaru</span>
                </div>
                <div class="widget-content summary-list">
                    <ul>
                        @if(empty($informasi->results))
                        <li>
                            <span class="key"><i class="icon-calendar"></i> --</span>
                            <span class="val">
                                <span class="text-nowrap">Tidak Ada Informasi</span>&nbsp;&nbsp;
                                <span class="text-nowrap"></span>
                            </span>
                        </li>
                        @else
                        @foreach($informasi->results as $data)
                        <li>
                            <span class="key"><i class="icol-application-view-list"></i> Petugas Jurusan</span>
                            <span class="val">
                                <span class="text-nowrap" rel="tooltip" title="Edit Informasi" data-placement="top"><a href="{{ URL::to_route('editinformasi', array($data->id, Str::slug(str::words($data->judul, 15)))) }}">{{ Str::limit_exact($data->judul, 35) }}</a></span>&nbsp;&nbsp;
                                <span class="text-nowrap"><b>{{ date("d-m-Y", strtotime($data->tanggal)) }}</b></span>
                            </span>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="pagination pagination-centered">{{ $informasi->links() }}</div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
