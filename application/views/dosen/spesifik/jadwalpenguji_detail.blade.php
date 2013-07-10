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
            @if($menu2 == 'Jadwal Penguji Seminar Proposal')
            Halaman Detail Jadwal Penguji Seminar Proposal <span>Halaman Untuk Melihat Detail Jadwal Penguji Seminar Proposal</span>
            @elseif($menu2 == 'Jadwal Penguji Seminar Hasil')
            Halaman Detail Jadwal Penguji Seminar Hasil <span>Halaman Untuk Melihat Detail Jadwal Penguji Seminar Hasil</span>
            @else
            Halaman Detail Jadwal Penguji Ujian TA <span>Halaman Untuk Melihat Detail Jadwal Penguji Ujian TA</span>
            @endif
        </h1>
    </div>

    <div id="main-content">
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    @if($menu2 == 'Jadwal Penguji Seminar Proposal')
                    <span class="title"><i class="icol-arrow-right"></i>Waktu Pelaksanaan Seminar Proposal</span>
                    @elseif($menu2 == 'Jadwal Penguji Seminar Hasil')
                    <span class="title"><i class="icol-arrow-right"></i>Waktu Pelaksanaan Seminar Hasil</span>
                    @else
                    <span class="title"><i class="icol-arrow-right"></i>Waktu Pelaksanaan Ujian TA</span>
                    @endif
                </div>
                <div class="widget-content goal">
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span3" rel="tooltip" data-placement="top" title="Tanggal Pelaksanaan">
                                {{ date('d-m-Y', strtotime($tanggal)) }}
                                <small>Tanggal</small>
                            </div>
                            <div class="info span3" rel="tooltip" data-placement="top" title="Jam Pelaksanaan">
                                {{ date('H:i', strtotime($jam)) }}
                                <small>Pukul</small>
                            </div>
                            <div class="info span3" rel="tooltip" data-placement="top" title="Ruang Pelaksanaan">
                                {{ $ruang }}
                                <small>Ruang</small>
                            </div>
                            <div class="info span3" rel="tooltip" data-placement="top" title="Sisa Hari Menuju Hari Pelaksanaan">
                                {{ $sisawaktu }}
                                <small>Menuju Pelaksanaan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span5 widget">
                <div class="widget-header">
                    @if($menu2 == 'Jadwal Penguji Seminar Proposal')
                    <span class="title"><i class="icol-arrow-right"></i>Seluruh Dosen Penguji Seminar Proposal</span>
                    @elseif($menu2 == 'Jadwal Penguji Seminar Hasil')
                    <span class="title"><i class="icol-arrow-right"></i>Seluruh Dosen Penguji Seminar Hasil</span>
                    @else
                    <span class="title"><i class="icol-arrow-right"></i>Seluruh Dosen Penguji Ujian TA</span>
                    @endif
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIP / NIDP</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalpengujisall as $all)
                            <tr>
                                <td><b>{{ $all->dosen->user->username }}</b></td>
                                <td>{{ $all->dosen->namadepan }} {{ $all->dosen->namabelakang }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="span7 widget">
                <div class="widget-header">
                    @if($menu2 == 'Jadwal Penguji Seminar Proposal')
                    <span class="title"><i class="icol-arrow-right"></i>Seluruh Peserta Seminar Proposal</span>
                    @elseif($menu2 == 'Jadwal Penguji Seminar Hasil')
                    <span class="title"><i class="icol-arrow-right"></i>Seluruh Peserta Seminar Hasil</span>
                    @else
                    <span class="title"><i class="icol-arrow-right"></i>Seluruh Peserta Ujian TA</span>
                    @endif
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Urutan</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Judul</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($menu2 == 'Jadwal Penguji Seminar Proposal')
                            @foreach($jadwalsempros as $mahasiswa1)
                            <tr>
                                <td>{{ $mahasiswa1->nourut }}</td>
                                <td><b><a href="{{ URL::to_route('lihatsemprodetailproposal', Crypter::encrypt($mahasiswa1->daftar->proposal->mahasiswa_id)) }}" rel="tooltip" data-placement="top" title="Lihat Detail Proposal {{ $mahasiswa1->daftar->nama }}">{{ $mahasiswa1->daftar->proposal->nim }}</a></b></td>
                                <td>{{ $mahasiswa1->daftar->nama }}</td>
                                <td>{{ Str::words($mahasiswa1->daftar->judul, 5) }}</td>
                            </tr>
                            @endforeach
                            @elseif($menu2 == 'Jadwal Penguji Seminar Hasil')
                            @foreach($jadwalsemhass as $mahasiswa2)
                            <tr>
                                <td>{{ $mahasiswa2->nourut }}</td>
                                <td><b>{{ $mahasiswa2->daftar->proposal->nim }}</b></td>
                                <td>{{ $mahasiswa2->daftar->nama }}</td>
                                <td>{{ Str::words($mahasiswa2->daftar->judul, 5) }}</td>
                            </tr>
                            @endforeach
                            @else
                            @foreach($jadwalujians as $mahasiswa3)
                            <tr>
                                <td>{{ $mahasiswa3->nourut }}</td>
                                <td><b>{{ $mahasiswa3->daftar->proposal->nim }}</b></td>
                                <td>{{ $mahasiswa3->daftar->nama }}</td>
                                <td>{{ Str::words($mahasiswa3->daftar->judul, 5) }}</td>
                            </tr>
                            @endforeach
                            @endif
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
