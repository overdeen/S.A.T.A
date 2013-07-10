@layout('layout.admin.dashboard')

@section('style')
<?= HTML::style('mhsdosen/custom-plugins/wizard/wizard.css'); ?>
@endsection

@section('javascript')
<?= HTML::script('mhsdosen/plugins/validate/jquery.validate.min.js'); ?>
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
            Halaman Manage User Terdaftar <span>Halaman Untuk Melakukan Pengaturan User Yang Telah Terdaftar</span>
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
            <div class="widget">
                <div class="widget-content form-container">
                    <div class="control-group">
                        <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Melakukan Pengaturan Terhadap User Terdaftar</b>
                    </div>
                </div>
            </div>
            <div class="widget-header">
                <span class="title"><i class="icol-arrow-right"></i>Daftar User Terdaftar</span>
                <div class="toolbar">
                    <div class="btn-group">
                        <span class="btn dropdown-toggle" data-toggle="dropdown">
                            <i class="icos-arrow-down icos-white"></i> &nbsp; Menu User &nbsp;<i class="caret"></i>
                        </span>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="" data-target="#modal-mahasiswa" data-toggle="modal"><i class="icol-add"></i> Tambah Mahasiswa</a></li>
                            <li><a href="" data-target="#modal-dosen" data-toggle="modal"><i class="icol-add"></i> Tambah Dosen</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="modal-mahasiswa" class="modal hide">
                <div class="widget-header">
                    <span class="title">Form Tambah Mahasiswa</span>
                </div>
                <div class="widget-content form-container">
                    {{ Form::open('admin/user/add', 'POST', array('id' => 'wizard-demo-2', 'class' => 'form-horizontal', 'data-forward-only' => 'false')) }}
                    {{ Form::token() }}
                    <fieldset class="wizard-step">
                        <legend class="wizard-label">Data Mahasiswa</legend>
                        <div class="control-group">
                            <label class="control-label">Username <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" name="username" class="required span4"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Password <span class="required">*</span></label>
                            <div class="controls">
                                <input type="password" name="password" class="required span4"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Email <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" name="email" class="required span4 email"/>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-step">
                        <legend class="wizard-label">Role User</legend>
                        <div class="control-group">
                            <label class="control-label">Role <span class="required">*</span></label>
                            <div class="controls">
                                <label class="radio">
                                    <input type="radio" name="role" value="3" class="uniform required">
                                    Mahasiswa
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    {{ Form::close() }}
                </div>
            </div>
            <div id="modal-dosen" class="modal hide">
                <div class="widget-header">
                    <span class="title">Form Tambah Dosen</span>
                </div>
                <div class="widget-content form-container">
                    {{ Form::open('admin/user/add', 'POST', array('id' => 'wizard-demo-3', 'class' => 'form-horizontal', 'data-forward-only' => 'false')) }}
                    {{ Form::token() }}
                    <fieldset class="wizard-step">
                        <legend class="wizard-label">Data Dosen [1]</legend>
                        <div class="control-group">
                            <label class="control-label">Username <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" name="username" class="required span4"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Password <span class="required">*</span></label>
                            <div class="controls">
                                <input type="password" name="password" class="required span4"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Email <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" name="email" class="required span4 email"/>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-step">
                        <legend class="wizard-label">Data Dosen [2]</legend>
                        <div class="control-group">
                            <label class="control-label">Nama Depan <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" name="namadepan" class="required span4"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nama Belakang <span class="required">*</span></label>
                            <div class="controls">
                                <input type="text" name="namabelakang" class="required span4"/>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="wizard-step">
                        <legend class="wizard-label">Role User</legend>
                        <div class="control-group">
                            <label class="control-label">Role <span class="required">*</span></label>
                            <div class="controls">
                                <label class="radio">
                                    <input type="radio" name="role" value="2" class="uniform">
                                    Dosen
                                </label>
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
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Admin</th>
                            <th>Ditambahkan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usersall->results as $users)
                        <tr>
                            <td><b>{{ $users->username }}</b></td>
                            <td>
                                @if($users->role == 2)
                                <b>{{ $users->dosen->namadepan }} {{ $users->dosen->namabelakang }}</b>
                                @elseif($users->role == 3)
                                <b>{{ $users->mahasiswa->namadepan }} {{ $users->mahasiswa->namabelakang }}</b>
                                @endif
                            </td>
                            <td>{{ $users->email }}</td>
                            <td>
                                @if($users->role == 2)
                                <span class="badge badge-warning">Dosen</span>
                                @elseif($users->role == 3)
                                <span class="badge badge-info">Mahasiswa</span>
                                @endif
                            </td>
                            <td>
                                @if($users->adm == 1)
                                <span class="badge badge-important">Admin</span>
                                @else

                                @endif
                            </td>
                            <td>{{ $users->created_at }}</td>
                            <td class="action-col">
                                <span class="btn-group">
                                    <a href="{{ URL::to_route('deleteuser', Crypter::encrypt($users->id)) }}" title="Delete User" class="btn btn-small" onclick="return confirm('Apakah Anda Yakin Akan Menghapus User Yang Bersangkutan ?');"><i class="icos-acces-denied-sign"></i></a>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div><center>{{ $usersall->links() }}</center></div>
    </div>
</section>
@endsection

@section('script')

@endsection
