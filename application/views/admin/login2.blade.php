<!DOCTYPE html>
<!--[if lt IE 7]>
  <html class="lt-ie9 lt-ie8 lt-ie7" lang="en">
<![endif]-->

<!--[if IE 7]>
  <html class="lt-ie9 lt-ie8" lang="en">
<![endif]-->

<!--[if IE 8]>
  <html class="lt-ie9" lang="en">
<![endif]-->

<!--[if gt IE 8]>
<!-->
<html lang="en">
    <!--
  <![endif]-->
    <head>
        @include('layout.meta')
        <!--[if lte IE 7]>
        <script src="css/icomoon-font/lte-ie7.js"></script>
        <![endif]-->
        <!-- bootstrap css -->
        <?= HTML::style('mhsdosen/assets/css/fonts/icomoon/style.css'); ?>
        <?= HTML::style('adm/assets/css/main.css'); ?>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span4 offset4">
                    <div class="signin">
                        <h2 class="center-align-text">Halaman Login Admin</h2>
                        {{ Form::open('login/admin', 'POST', array('class'=>'signin-wrapper')) }}
                        {{ Form::token() }}
                        <div class="content">
                            @if(Session::has('message'))
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <p id="message">{{ Session::get('message') }}</p>
                            </div>
                            @endif
                            <div class="controls">
                                <input name="username" class="input input-block-level" placeholder="Username" type="text" value="<?= Input::old('username'); ?>" required>                            
                            </div>
                            <div class="controls">
                                <input name="password" class="input input-block-level" placeholder="Password" type="password" required>
                            </div>
                        </div>
                        <div class="actions">
                            <input class="btn btn-danger pull-right" type="submit" value="LOGIN"/>
                            <a href="{{ URL::base() }}" class="btn btn-link" title="Menuju Login Untuk Dosen"><b>Login Dosen</b></a>
                            <div class="clearfix"></div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <?= HTML::script('mhsdosen/assets/js/libs/jquery-1.8.3.min.js'); ?>
        <?= HTML::script('mhsdosen/bootstrap/js/bootstrap.min.js'); ?>
    </body>
</html>