@layout('layout.admin.dashboard')

@section('style')

@endsection

@section('javascript')

@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">
            Halaman Dashboard Admin <span>Halaman Utama Dashboard Admin</span>
        </h1>
    </div>
    <div id="main-content">
        <ul class="stats-container">
            <li>
                <a href="{{ URL::to_route('viewuser') }}" rel="tooltip" data-placement="top" title="Jumlah Seluruh Mahasiswa Yang Telah Terdaftar" class="stat summary">
                    <span class="icon icon-circle bg-green">
                        <i class="icon-th-list"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Jumlah Mahasiswa</span>
                        {{ $jml_mhs }} Orang
                    </span>
                </a>
            </li>
            <li>
                <a href="" rel="tooltip" data-placement="top" title="Jumlah Seluruh Dosen" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-user"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Jumlah Dosen</span>
                        {{ $jml_dsn }} Orang
                    </span>
                </a>
            </li>
            <li>
                <a href="" rel="tooltip" data-placement="top" title="Jumlah Mahasiwa yang Belum Mendapatkan Hasil Seminar Proposal" class="stat summary">
                    <span class="icon icon-circle bg-green">
                        <i class="icon-th-list"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Belum Ada Hasil Sempro</span>
                        {{ $jml_hsl_sempro }} Orang
                    </span>
                </a>
            </li>
            <li>
                <a href="" rel="tooltip" data-placement="top" title="Jumlah Mahasiwa yang Belum Mendapatkan Hasil Ujian TA" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-user"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Belum Ada Hasil Ujian TA</span>
                        {{ $jml_hsl_ujian }} Orang
                    </span>
                </a>
            </li>
        </ul>
        <ul class="stats-container">
            <li>
                <a href="" rel="tooltip" data-placement="top" title="Jumlah Mahasiswa yang Belum Terjadwal Seminar Proposal" class="stat summary">
                    <span class="icon icon-circle bg-green">
                        <i class="icon-th-list"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Belum Terjadwal Sempro</span>
                        {{ $jml_jdw_sempro }} Orang
                    </span>
                </a>
            </li>
            <li>
                <a href="" rel="tooltip" data-placement="top" title="Jumlah Mahasiswa yang Belum Terjadwal Seminar Hasil" class="stat summary">
                    <span class="icon icon-circle bg-orange">
                        <i class="icon-user"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Belum Terjadwal Semhas</span>
                        {{ $jml_jdw_semhas }} Orang
                    </span>
                </a>
            </li>
            <li>
                <a href="" rel="tooltip" data-placement="top" title="Jumlah Mahasiswa yang Belum Terjadwal Ujian TA" class="stat summary">
                    <span class="icon icon-circle bg-green">
                        <i class="icon-stats"></i>
                    </span>
                    <span class="digit">
                        <span class="text">Belum Terjadwal Ujian</span>
                        {{ $jml_jdw_ujian }} Buah
                    </span>
                </a>
            </li>
        </ul>
    </div>
</section>
@endsection

@section('script')

@endsection
