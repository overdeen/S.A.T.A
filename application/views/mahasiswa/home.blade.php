@layout('layout.dashboard')

@section('style')

@endsection

@section('javascript')

@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">
            Halaman Dashboard Mahasiswa <span>Halaman Utama Dashboard Mahasiswa</span>
        </h1>
    </div>
    <div id="main-content">
        @if(Session::has('message'))
        <div class="widget">
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p id="message">{{ Session::get('message') }}</p>
            </div>
        </div>
        @endif
        <ul class="stats-container">
            <li>
                <a href="" rel="tooltip" data-placement="top" title="Jumlah Approval Proposal Judul Untuk Syarat Mendaftar Seminar Proposal" class="stat summary">
                    <span class="icon icon-circle bg-red">
                        <i class="icon-check"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Approval</span>
                        @if(empty($proposal) || $approvalcount == 'null')
                        --
                        @else
                        {{ $approvalcount }} Approval
                        @endif
                    </span>
                </a>
            </li>
            <li>
                <a href="" rel="tooltip" data-placement="top" title="Jumlah Rekomendasi Untuk Syarat Mendaftar Seminar Hasil Dan Ujian TA" class="stat summary">
                    <span class="icon icon-circle bg-red">
                        <i class="icon-ok-sign"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Rekomendasi</span>
                        @if(empty($proposal) || $rekomendasi == 'null')
                        --
                        @else
                        {{ $rekomendasi }} Rekomendasi
                        @endif
                    </span>
                </a>
            </li>
            <li>
                <a href="" rel="tooltip" data-placement="top" title="Hasil Seminar Proposal Telah Keluar Ataukah Belum" class="stat summary">
                    <span class="icon icon-circle bg-blue">
                        <i class=" icon-file"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Hasil Sempro</span>
                        @if(empty($hasil) || $hasil == 'null' || $hasil->hasil_sempro == 0)
                        --
                        @else
                        Ada
                        @endif
                    </span>
                </a>
            </li>
            <li>
                <a href="" rel="tooltip" data-placement="top" title="Hasil Ujian TA ( Nilai ) Telah Keluar Ataukah Belum" class="stat summary">
                    <span class="icon icon-circle bg-blue">
                        <i class=" icon-file"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Hasil Ujian TA ( Nilai )</span>
                        @if(empty($hasil) || $hasil == 'null' || $hasil->hasil_ujian == 4 || empty($hasil->nilai_ujian))
                        --
                        @else
                        Ada
                        @endif
                    </span>
                </a>
            </li>
        </ul>
        <ul class="stats-container">
            <li>
                <a href="{{ URL::to_route('jadwalsempro') }}" rel="tooltip" data-placement="top" title="Jadwal Seminar Proposal Terdekat" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-table"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Jadwal Sempro Terdekat</span>
                        @if(empty($jadwalsempro) || $jadwalsempro == 'null')
                        --
                        @else
                        @if(date('Y-m-d') > $jadwalsempro->tanggal)
                        --
                        @elseif(date('Y-m-d') <= $jadwalsempro->tanggal)
                        {{ date('d-m-Y', strtotime($jadwalsempro->tanggal)) }}
                        @endif
                        @endif
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ URL::to_route('jadwalsemhas') }}" rel="tooltip" data-placement="top" title="Jadwal Seminar Hasil Terdekat" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-table"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Jadwal Semhas Terdekat</span>
                        @if(empty($jadwalsemhas) || $jadwalsemhas == 'null')
                        --
                        @else
                        @if(date('Y-m-d') > $jadwalsemhas->tanggal)
                        --
                        @elseif(date('Y-m-d') <= $jadwalsemhas->tanggal)
                        {{ date('d-m-Y', strtotime($jadwalsemhas->tanggal)) }}
                        @endif
                        @endif
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ URL::to_route('jadwalujian') }}" rel="tooltip" data-placement="top" title="Jadwal Ujian Tugas Akhir Terdekat" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-table"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Jadwal Ujian Terdekat</span>
                        @if(empty($jadwalujian) || $jadwalujian == 'null')
                        --
                        @else
                        @if(date('Y-m-d') > $jadwalujian->tanggal)
                        --
                        @elseif(date('Y-m-d') <= $jadwalujian->tanggal)
                        {{ date('d-m-Y', strtotime($jadwalujian->tanggal)) }}
                        @endif
                        @endif
                    </span>
                </a>
            </li>
        </ul>
        @if(!empty($detailinformasi))
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Detail Informasi Terkait</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped table-detail-view">
                        <tbody>
                            <tr>
                                <th>Tanggal Informasi</th>
                                <td><b>{{ date('l, d-m-Y', strtotime($detailinformasi->tanggal)) }}</b></td>
                            </tr>
                            <tr>
                                <th>Judul Informasi</th>
                                <td>{{ $detailinformasi->judul }}</td>
                            </tr>
                            <tr>
                                <th>Isi Informasi</th>
                                <td>{{ $detailinformasi->isi }}</td>
                            </tr>
                            <tr>
                                <th>File Terkait</th>
                                <td>
                                    @if(empty($detailinformasi->file))
                                    Tidak Ada File Terkait
                                    @else
                                    <a href="{{ URL::to_route('downloadfileinformasi', Crypter::encrypt($detailinformasi->file)) }}">{{ $detailinformasi->file }}</a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        @endif
        <div class="row-fluid">
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Mahasiswa Terdaftar Terbaru</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Depan</th>
                                <th>Nama Belakang</th>
                                <th>Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userall as $all)
                            <tr>
                                <td><a href="{{ URL::to_route('detailprofilmahasiswa', Crypter::encrypt($all->id)) }}" rel="tooltip" data-placement="top" title="Lihat Profil {{ $all->mahasiswa->namadepan }}">{{ $all->username }}</a></td>
                                <td>{{ $all->mahasiswa->namadepan }}</td>
                                <td>{{ $all->mahasiswa->namabelakang }}</td>
                                <td><b>{{ date('d-m-Y', strtotime($all->created_at)) }}</b></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Daftar Informasi Terbaru Terkait Tugas Akhir</span>
                </div>
                <div class="widget-content summary-list">
                    <ul>
                        @if(empty($informasi->results))
                        <li>
                            <span class="key"><i class="icol-application-view-list"></i> --</span>
                            <span class="val">
                                <span class="text-nowrap">Tidak Ada Informasi</span>&nbsp;&nbsp;
                                <span class="text-nowrap"></span>
                            </span>
                        </li>
                        @else
                        @foreach($informasi->results as $data)
                        <li>
                            <span class="key"><i class="icol-application-view-list"></i> Petugas Jurusan</span>
                            <span class="val">
                                <span class="text-nowrap"><a href="{{ URL::to_route('lihatinformasiTA', array($data->id, Str::slug($data->judul))) }}" rel="tooltip" data-placement="top" title="Lihat Detail Informasi">{{ Str::limit_exact($data->judul, 35) }}</a></span>&nbsp;&nbsp;
                                <span class="text-nowrap"><b>{{ date("d-m-Y", strtotime($data->tanggal)) }}</b></span>
                            </span>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <div class="pagination pagination-centered">{{ $informasi->links() }}</div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
