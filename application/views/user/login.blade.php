@layout('layout.default')

@section('style')
<?= HTML::style('mhsdosen/assets/css/typica-login.css'); ?>
@endsection

@section('javascript')

@endsection

@section('content')
<div id="login-wraper">  
    <div id="register-form" class="form">
        <legend>SILAHKAN <span class="blue">LOGIN</span></legend>
        <div class="body">
            {{ Form::open('login', 'POST') }}{{ Form::token() }}
            @if(Session::has('message'))
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p id="message">{{ Session::get('message') }}</p>
            </div>
            @endif
            <div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
                <label class="control-label" for="username">{{ $errors->has('username') ? '<p class="text-error">' . $errors->first('username') . '</p>' : 'User Name' }}</label>
                <div class="controls">
                    <input name="username" class="input-huge required" type="text" value="<?= Input::old('username'); ?>" required>                            
                </div>
            </div>
            <div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
                <label class="control-label" for="password">{{ $errors->has('password') ? '<p class="text-error">' . $errors->first('password') . '</p>' : 'Password' }}</label>
                <div class="controls">
                    <input name="password" class="input-huge required" type="password" required>
                </div>
            </div>
            <div class="footer">
                <button type="submit" class="btn btn-danger">LOGIN</button> <a href="" data-target="#lupapassword" data-toggle="modal" class="btn btn-danger">LUPA PASSWORD</a>
            </div>
            {{ Form::close() }}
            <div id="lupapassword" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <h3 id="myModalLabel">Form Lupa Password</h3>
                </div>
                {{ Form::open('lupa/password', 'POST') }}{{ Form::token() }}
                <div class="modal-body">
                    <div class="control-group control-inline">
                        <label for="nim">Nomor Induk Mahasiswa</label>
                        <input name="nim" class="input-huge" type="text" required>
                    </div>
                    <div class="control-group control-inline">
                        <label for="email">Email Terdaftar</label>
                        <input name="email" class="input-huge" type="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <center><button type="submit" class="btn btn-danger">KIRIM PASSWORD</button></center>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div><br/>
    <div class="info">Belum Punya Akun Silahkan<a href="{{ URL::home() }}registrasi" class="btn btn-link">REGISTRASI</a></div>
</div>
@endsection

@section('script')

@endsection