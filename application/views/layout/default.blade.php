<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layout.meta')
        <!-- Core Style -->
        <?= HTML::style('mhsdosen/bootstrap/css/bootstrap-cust.css'); ?>
        <!-- Additional Style -->
        @yield('style')
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>
    <!-- Core Javascript -->
    <?= HTML::script('mhsdosen/assets/js/libs/jquery-1.8.3.min.js'); ?>
    <?= HTML::script('mhsdosen/bootstrap/js/bootstrap.js'); ?>
    <!-- additional Javasript -->
    @yield('javascript')
    <!-- Custom Script -->
    @yield('script')
</html>