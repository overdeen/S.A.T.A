@layout('layout.default')

@section('style')
<?= HTML::style('adm/assets/css/typica-login-admin.css'); ?>
@endsection

@section('javascript')

@endsection

@section('content')
<div id="login-wraper">  
    <div id="register-form" class="form">
        <legend>LOGIN <span class="blue">ADMIN</span></legend>
        <div class="body">
            {{ Form::open('it-admin', 'POST') }}
            {{ Form::token() }}
            @if(Session::has('message'))
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p id="message">{{ Session::get('message') }}</p>
            </div>
            @endif
            <div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
                <label class="control-label" for="username">{{ $errors->has('username') ? '<p class="text-error">' . $errors->first('username') . '</p>' : 'User Name' }}</label>
                <div class="controls">
                    <input name="username" class="input-huge required" type="text" value="<?= Input::old('username'); ?>">                            
                </div>
            </div>
            <div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
                <label class="control-label" for="password">{{ $errors->has('password') ? '<p class="text-error">' . $errors->first('password') . '</p>' : 'Password' }}</label>
                <div class="controls">
                    <input name="password" class="input-huge required" type="password">
                </div>
            </div>
            <div class="footer">
                <button type="submit" class="btn btn-danger">LOGIN</button>
            </div>
            {{ Form::close() }}
        </div>
    </div><br/>
    <div class="info">Login Ke Dashboard Dosen<a href="<?= URL::base() ?>" class="btn btn-link">LOGIN DOSEN</a></div>
</div>
@endsection

@section('script')

@endsection