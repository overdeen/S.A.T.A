@layout('layout.dashboard')

@section('style')

@endsection

@section('javascript')

@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">Halaman Detail Proposal <span>Halaman untuk Melihat Detail Proposal Mahasiswa</span></h1>
    </div>
    <div id="main-content">
        <div class="row-fluid">
            <div class="widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Detail Proposal Judul Tugas Akhir</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped table-detail-view">
                        <thead>
                            <tr><th colspan="2"><i class="icol-doc-text-image"></i> Informasi Proposal Judul Tugas Akhir</th></tr>
                        </thead>
                        <tbody>
                            <tr><th>Judul</th><td>{{ $dataproposal->judul }}</td></tr>
                            <tr><th>Deskripsi</th><td>{{ $dataproposal->deskripsi }}</td></tr>
                            <tr><th>Tahun</th><td>{{ $dataproposal->tahun }}</td></tr>
                            <tr><th>Ditambahkan Pada</th><td>{{ $dataproposal->created_at }}</td></tr>
                        </tbody>
                        <thead>
                            <tr><th colspan="2"><i class="icol-user"></i> Informasi Mahasiswa Pemilik Proposal Judul Tugas Akhir</th></tr>
                        </thead>
                        <tbody>
                            <tr><th>Nomor Induk Mahasiswa</th><td>{{ $dataproposal->mahasiswa->user->username }}</td>
                            </tr>
                            <tr><th>Nama Depan</th><td>{{ $dataproposal->mahasiswa->namadepan }}</td>
                            </tr>
                            <tr><th>Nama Belakang</th><td>{{ $dataproposal->mahasiswa->namabelakang }}</td>
                            </tr>
                            <tr><th>Angkatan</th><td>{{ $dataproposal->mahasiswa->user->profil->angkatan }}</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr><th colspan="2"><i class="icol-drive"></i> Data Proposal Judul Tugas Akhir</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Download Proposal</th>
                                <td>{{ $dataproposal->dokumen }} &nbsp<a href="{{ URL::to_route('proposaldetaildownload', array(Crypter::encrypt($dataproposal->mahasiswa->user->username), $dataproposal->dokumen)) }}"><button class="btn btn-small btn-primary">DOWNLOAD</button></a>         
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
