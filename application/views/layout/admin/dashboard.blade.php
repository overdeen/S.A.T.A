<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en"><!--<![endif]-->
    <head>
        @include('layout.meta')
        <!-- Core Style -->
        <?= HTML::style('mhsdosen/bootstrap/css/bootstrap.min.css'); ?>
        <?= HTML::style('mhsdosen/assets/jui/css/jquery-ui.css'); ?>
        <?= HTML::style('mhsdosen/assets/jui/jquery-ui.custom.css'); ?>
        <?= HTML::style('mhsdosen/assets/jui/timepicker/jquery-ui-timepicker.css'); ?>
        <?= HTML::style('mhsdosen/plugins/uniform/css/uniform.default.css'); ?>
        <?= HTML::style('adm/assets/css/main-style.css'); ?>
        <?= HTML::style('mhsdosen/assets/css/fonts/icomoon/style.css'); ?>
        <!-- Additional Style -->
        @yield('style')
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>

    <body data-show-sidebar-toggle-button="false" data-fixed-sidebar="true">
        <div id="wrapper" class="full">
            <header id="header" class="navbar navbar-inverse">
                <div class="navbar-inner">
                    @include('layout.admin.topnavbar')
                </div>
            </header>

            <div id="content-wrap">
                <div id="content">
                    <div id="content-outer">
                        <div id="content-inner">
                            @include('layout.admin.leftnavbar')
                            <div id="sidebar-separator"></div>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Core Javascript -->
        <?= HTML::script('mhsdosen/assets/js/libs/jquery-1.8.3.min.js'); ?>
        <?= HTML::script('mhsdosen/bootstrap/js/bootstrap.min.js'); ?>
        <?= HTML::script('mhsdosen/assets/js/libs/jquery.placeholder.min.js'); ?>
        <?= HTML::script('mhsdosen/assets/js/libs/jquery.mousewheel.min.js'); ?>
        <?= HTML::script('mhsdosen/assets/js/template.js'); ?>
        <?= HTML::script('mhsdosen/assets/js/setup.js'); ?>
        <?= HTML::script('mhsdosen/assets/js/customizer.js'); ?>
        <?= HTML::script('mhsdosen/plugins/uniform/jquery.uniform.min.js'); ?>
        <?= HTML::script('mhsdosen/assets/jui/js/jquery-ui-1.9.2.min.js'); ?>
        <?= HTML::script('mhsdosen/assets/jui/jquery-ui.custom.min.js'); ?>
        <?= HTML::script('mhsdosen/assets/jui/timepicker/jquery-ui-timepicker.min.js'); ?>
        <?= HTML::script('mhsdosen/assets/jui/jquery.ui.touch-punch.min.js'); ?>
        <!-- Additional Javasript -->
        @yield('javascript')
        <!-- Custom Script -->
        @yield('script')
    </body>
</html>
