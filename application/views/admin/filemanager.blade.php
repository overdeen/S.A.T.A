@layout('layout.admin.dashboard')

@section('style')
<?= HTML::style('mhsdosen/plugins/elfinder/css/elfinder.min.css'); ?>
@endsection

@section('javascript')
<?= HTML::script('mhsdosen/plugins/elfinder/js/elfinder.full.js'); ?>
<?= HTML::script('mhsdosen/assets/js/demo/file_manager.js'); ?>
@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">
            Halaman File Manager <span>Halaman File Manager Admin</span>
        </h1>
    </div>
    <div id="main-content">
        <div class="row-fluid">
            <div class="span12 widget">
                <div id="elfinder-demo"></div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
