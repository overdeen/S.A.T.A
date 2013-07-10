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
            Halaman Dashboard Dosen <span>Halaman Utama Dashboard Dosen</span>
        </h1>
    </div>
    <div id="main-content">
        <ul class="stats-container">
            <li>
                <a href="{{ URL::to_route('approval') }}" rel="tooltip" data-placement="top" title="Jumlah Permintaan Approval Proposal Judul Mahasiswa" class="stat summary">
                    <span class="icon icon-circle bg-green">
                        <i class="icon-archive"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Permintaan Approval Mahasiswa</span>
                        {{ $pembimbing }} Permintaan
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ URL::to_route('asistensibimbingan') }}" rel="tooltip" data-placement="top" title="Jumlah Mahasiswa Bimbingan Tugas Akhir" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-users"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Mahasiswa Bimbingan Tugas Akhir</span>
                        {{ $totalmhsbimbingan }} Mahasiswa
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ URL::to_route('asistensibimbingan') }}" rel="tooltip" data-placement="top" title="Jumlah Mahasiswa Yang Butuh Rekomendasi Semhas & Ujian TA" class="stat summary">
                    <span class="icon icon-circle bg-green">
                        <i class="icon-ok-sign"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Butuh Rekomendasi Semhas & Ujian TA</span>
                        {{ $bthrekomendasi }} Mahasiswa
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
                        <thead>
                        </thead>
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
                                    <a href="{{ URL::to_route('downloadfileinformasidosen', Crypter::encrypt($detailinformasi->file)) }}">{{ $detailinformasi->file }}</a>
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
                    <span class="title"><i class="icol-arrow-right"></i>Daftar Informasi Terbaru Terkait Tugas Akhir</span>
                </div>
                <div class="widget-content summary-list">
                    <ul>
                        @if(empty($informasi->results))
                        <li>
                            <span class="key"><i class="icon-calendar"></i> --</span>
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
                                <span class="text-nowrap"><a href="{{ URL::to_route('lihatinfodosen', array($data->id, Str::slug($data->judul))) }}" rel="tooltip" data-placement="top" title="Lihat Detail Informasi">{{ Str::limit_exact($data->judul, 35) }}</a></span>&nbsp;&nbsp;
                                <span class="text-nowrap"><b>{{ date("d-m-Y", strtotime($data->tanggal)) }}</b></span>
                            </span>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <div class="pagination pagination-centered">{{ $informasi->links() }}</div>
            </div>
            <div class="span6 widget">
                <div class="widget-content goal">
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span12">
                                @if(empty($jadwalpsemproterdekat))
                                Belum Ada Jadwal Penguji
                                <small>Jadwal Penguji Sempro Terdekat</small>
                                @else
                                @foreach($jadwalpsemproterdekat as $jadwalpsempro)
                                @if(date('Y-m-d') > $jadwalpsempro->tanggal)
                                Belum Ada Jadwal Penguji
                                @elseif(date('Y-m-d') <= $jadwalpsempro->tanggal)
                                <a href="{{ URL::to_route('jadwalpengujisempro') }}">{{ date('d-m-Y', strtotime($jadwalpsempro->tanggal)) }} {{ date('H:i', strtotime($jadwalpsempro->jam)) }} {{ $jadwalpsempro->ruang }}</a>
                                @endif
                                @endforeach
                                <small>Jadwal Penguji Sempro Terdekat</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span12">
                                @if(empty($jadwalpsemhasterdekat))
                                Belum Ada Jadwal Penguji
                                <small>Jadwal Penguji Semhas Terdekat</small>
                                @else
                                @foreach($jadwalpsemhasterdekat as $jadwalpsemhas)
                                @if(date('Y-m-d') > $jadwalpsemhas->tanggal)
                                Belum Ada Jadwal Penguji
                                @else
                                <a href="{{ URL::to_route('jadwalpengujisemhas') }}">{{ date('d-m-Y', strtotime($jadwalpsemhas->tanggal)) }} {{ date('H:i', strtotime($jadwalpsemhas->jam)) }} {{ $jadwalpsemhas->ruang }}</a>
                                @endif
                                @endforeach
                                <small>Jadwal Penguji Semhas Terdekat</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span12">
                                @if(empty($jadwalpujianterdekat))
                                Belum Ada Jadwal Penguji
                                <small>Jadwal Penguji Ujian TA Terdekat</small>
                                @else
                                @foreach($jadwalpujianterdekat as $jadwalpujian)
                                @if(date('Y-m-d') > $jadwalpujian->tanggal)
                                Belum Ada Jadwal Penguji
                                @else
                                <a href="{{ URL::to_route('jadwalpengujiujian') }}">{{ date('d-m-Y', strtotime($jadwalpujian->tanggal)) }} {{ date('H:i', strtotime($jadwalpujian->jam)) }} {{ $jadwalpujian->ruang }}</a>
                                @endif
                                @endforeach
                                <small>Jadwal Penguji Ujian TA Terdekat</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
