@layout('layout.dashboard')

@section('style')

@endsection

@section('javascript')
<?= HTML::script('mhsdosen/bootstrap/js/bootstrap-ajax.js'); ?>
<?= HTML::script('mhsdosen/plugins/datatables/jquery.dataTables.min.js'); ?>
<?= HTML::script('mhsdosen/plugins/datatables/TableTools/js/TableTools.min.js'); ?>
<?= HTML::script('mhsdosen/plugins/datatables/FixedColumns/FixedColumns.min.js'); ?>
<?= HTML::script('mhsdosen/plugins/datatables/dataTables.bootstrap.js'); ?>
<?= HTML::script('mhsdosen/plugins/datatables/jquery.dataTables.columnFilter.js'); ?>
<?= HTML::script('mhsdosen/assets/js/demo/dataTables.js'); ?>
@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">
            Halaman Judul TA Terdaftar <span>Halaman Untuk Melihat Judul TA Mahasiswa Lain yang Telah Terdaftar</span>
        </h1>
    </div>

    <div id="main-content">
        <div class="row-fluid">           
            <div class="span12">
                <div class="widget">
                    <div class="widget-content form-container">
                        <div class="control-group">
                            <span class="badge badge-info">Pemberitahuan !!</span>&nbsp;&nbsp; <b>Gunakanlah Fitur Pencarian Untuk Mencari Judul Tugas Akhir Terdaftar Yang Ingin Anda Lihat</b>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-header">
                        <span class="title"><i class="icol-arrow-right"></i>Daftar Proposal Judul Tugas Akhir Terdaftar</span>
                    </div>
                    <div class="widget-content table-container">
                        <table id="demo-dtable-01" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Judul Proposal</th>
                                    <th>Deskripsi Singkat</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proposals as $proposal)
                                <tr>
                                    <td><a class="btn_link" href="{{ URL::to_route('lihatstatus', Crypter::encrypt($proposal->id)) }}">{{ $proposal->nim }}</a></td>
                                    <td>{{ Str::limit($proposal->judul, 150) }}</td>
                                    <td>{{ Str::limit($proposal->deskripsi, 50) }}</td>
                                    <td>{{ $proposal->tahun }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
