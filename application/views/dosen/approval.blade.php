@layout('layout.dashboard')

@section('style')

@endsection

@section('javascript')
<?= HTML::script('mhsdosen/plugins/validate/jquery.validate.min.js'); ?>
<?= HTML::script('mhsdosen/custom-plugins/bootstrap-inputmask.min.js'); ?>
<?= HTML::script('mhsdosen/custom-plugins/bootstrap-fileinput.min.js'); ?>
<?= HTML::script('mhsdosen/custom-plugins/wizard/jquery.form.min.js'); ?>
<?= HTML::script('mhsdosen/assets/js/demo/form_validation.js'); ?>
@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">
            Halaman Permintaan Approval Proposal <span>Halaman Untuk Melihat Daftar Proposal Mahasiswa Yang Meminta Approval</span>
        </h1>
    </div>
    <div id="main-content">
        <div class="widget">
            <div class="widget-content form-container">
                <div class="control-group">
                    <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Memberikan Approval Kepada Proposal Judul Tugas Akhir Mahasiswa</b>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title">
                        <i class="icol-arrow-right"></i> Daftar Proposal Judul Tugas Akhir Mahasiswa
                    </span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>NIM</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Penambahan</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($pembimbingsorderby->results))
                            <tr>
                                <td></td>
                                <td>Belum Ada Permintaan</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @else
                            @foreach($pembimbingsorderby->results as $pembimbing)
                            <tr>
                                <td>
                                    @if($pembimbing->readeable == 0)
                                    <span class="badge badge-info">New</span>
                                    @endif
                                </td>
                                <td><b>{{ Proposal::find($pembimbing->proposal_id)->nim }}</b></td>
                                <td>{{ Str::words(Proposal::find($pembimbing->proposal_id)->judul, 15) }}</td>
                                <td>{{ Str::words(Proposal::find($pembimbing->proposal_id)->deskripsi, 10) }}</td>
                                <td>{{ date('d-m-Y H:i:s', strtotime($pembimbing->created_at)) }}</td>
                                <td>
                                    @if($pembimbing->approval == 0)
                                    <span class="badge badge-warning">Not Approve</span>
                                    @else
                                    <span class="badge badge-success">Approve</span>
                                    @endif
                                </td>
                                <td class="action-col">
                                    <span class="btn-group">
                                        <a href="{{ URL::to_route('proposalview', array(Crypter::encrypt($pembimbing->proposal_id), $pembimbing->dosen_id)) }}" title="Lihat Detail Proposal" class="btn btn-small"><i class="icon-search"></i></a>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <center>{{ $pembimbingsorderby->links() }}</center>    
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection