@layout('layout.admin.dashboard')

@section('style')
<?= HTML::style('mhsdosen/custom-plugins/wizard/wizard.css'); ?>
@endsection

@section('javascript')
<?= HTML::script('mhsdosen/custom-plugins/bootstrap-fileinput.min.js'); ?>
<?= HTML::script('mhsdosen/plugins/validate/jquery.validate.min.js'); ?>
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
            Halaman Manage Data Mahasiswa IT <span>Halaman Untuk Melakukan Pengaturan Data Mahasiswa IT</span>
        </h1>
    </div>
    <div id="main-content">
        @if(Session::has('message'))
        <div class="widget">
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p id="message">{{ Session::get('message') }}</p>
            </div>
        </div>
        @endif
        <div class="widget">
            <div class="widget-content form-container">
                <div class="control-group">
                    <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Menambahkan Data Mahasiswa Teknik Informatika</b>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Data Mahasiswa Teknik Informatika</span>
                    <div class="toolbar">
                        <div class="btn-group">
                            <span class="btn dropdown-toggle" data-toggle="dropdown">
                                <i class="icos-arrow-down icos-white"></i> &nbsp; Menu Data Mahasiswa IT &nbsp;<i class="caret"></i>
                            </span>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="" data-target="#header-modal" data-toggle="modal"><i class="icol-add"></i> Tambah Data Mahasiswa IT</a></li>
                                <li><a href="" data-target="#header-modal-2" data-toggle="modal"><i class="icol-drive-go"></i> Import Data Mahasiswa IT</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="header-modal" class="modal hide">
                    <div class="widget-header">
                        <span class="title">Form Tambah Data Mahasiswa IT</span>
                    </div>
                    <div class="widget-content form-container">
                        {{ Form::open('admin/user/datamahasiswa/add', 'POST', array('id' => 'wizard-demo-2', 'class' => 'form-horizontal', 'data-forward-only' => 'false')) }}
                        {{ Form::token() }}
                        <fieldset class="wizard-step">
                            <legend class="wizard-label">Data Mahasiswa IT</legend>
                            <div class="control-group">
                                <label class="control-label">NIM <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="nim" class="required span12"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nama Depan <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="namadepan" class="required span12"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nama Belakang <span class="required">*</span></label>
                                <div class="controls">
                                    <input type="text" name="namabelakang" class="required span12"/>
                                </div>
                            </div>
                        </fieldset>
                        {{ Form::close() }}
                    </div>
                </div>
                <div id="header-modal-2" class="modal hide">
                    <div class="widget-header">
                        <span class="title">Form Import Data Mahasiswa IT</span>
                    </div>
                    <div class="widget-content form-container">
                        {{ Form::open_for_files('admin/user/datamahasiswa/export', 'POST', array('id' => 'wizard-demo-3', 'class' => 'form-horizontal', 'data-forward-only' => 'false')) }}
                        {{ Form::token() }}
                        <fieldset class="wizard-step">
                            <legend class="wizard-label">Import Dari File Excel</legend>
                            <div class="control-group">
                                <div class="controls">
                                    *File Harus Berformat Microsoft Excel 97-2003 Worksheet (.xls)
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">File Excel<span class="required">*</span></label>
                                <div class="controls">
                                    <input type="file" name="filedatamahasiswa" data-provide="fileinput" class="required"> 
                                </div>
                            </div>

                        </fieldset>
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Depan</th>
                                <th>Nama Belakang</th>
                                <th>Ditambahkan Tanggal</th>
                                <th>Ditambahkan Pukul</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usersall->results as $users)
                            <tr>
                                <td><b>{{ $users->nim }}</b></td>
                                <td>{{ $users->nmdepan }}</td>
                                <td>{{ $users->nmbelakang }}</td>
                                <td>{{ date('d F Y', strtotime($users->created_at)) }}</td>
                                <td>{{ date('H:i:s', strtotime($users->created_at)) }}</td>
                                <td class="action-col">
                                    <span class="btn-group">
                                        <a href="{{ URL::to_route('deletedatamahasiswa', Crypter::encrypt($users->id)) }}" title="Delete User" class="btn btn-small" onclick="return confirm('Apakah Anda Yakin Akan Menghapus Mahasiswa IT Yang Bersangkutan ?');"><i class="icos-acces-denied-sign"></i></a>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div><center>{{ $usersall->links() }}</center></div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
