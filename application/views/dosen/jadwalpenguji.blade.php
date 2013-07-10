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
            Halaman Jadwal Penguji Seminar Proposal <span>Halaman Untuk Melihat Jadwal Penguji Seminar Proposal</span>
            @elseif($menu2 == 'Jadwal Penguji Seminar Hasil')
            Halaman Jadwal Penguji Seminar Hasil<span>Halaman Untuk Melihat Jadwal Penguji Seminar Hasil</span>
            @else
            Halaman Jadwal Penguji Ujian TA <span>Halaman Untuk Melihat Jadwal Penguji Ujian TA</span>
            @endif
        </h1>
    </div>

    <div id="main-content">
        <div class="widget">
            <div class="widget-content form-container">
                <form class="form-horizontal">
                    <div class="control-group">
                        <ul>
                            <li>Pada Halaman Ini Berisikan Jadwal Menjadi Penguji Yang Telah Dijadwalkan Oleh Petugas.</li>
                            <li>Jika Dosen Yang Bersangkutan Belum Dijadwalkan Oleh Petugas Dimohon Untuk Bersabar.</li>
                            <li>Jika Dosen Yang Bersangkutan Telah Dijadwalkan Oleh Petugas, Akan Terlihat Waktu Pelaksanaan Mulai Dari Tanggal, Waktu, Dan Ruang.</li>
                            <li>Dosen Yang Bersangkuat Dapat Melihat Detail Dari Jadwal Penguji Dengan Menekan Tombol ' <b>Lihat Detail Jadwal Penguji</b> '</li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <div class="row-fluid">
            <div class="widget span12">
                <div class="widget-header">
                    <span class="title">
                        @if($menu2 == 'Jadwal Penguji Seminar Proposal')
                        <i class="icol-arrow-right"></i> Jadwal Menjadi Dosen Penguji Seminar Proposal
                        @elseif($menu2 == 'Jadwal Penguji Seminar Hasil')
                        <i class="icol-arrow-right"></i> Jadwal Menjadi Dosen Penguji Seminar Hasil
                        @else
                        <i class="icol-arrow-right"></i> Jadwal Menjadi Dosen Penguji Ujian Tugas Akhir
                        @endif    
                    </span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIP / NIDP</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Ruang</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($jadwalpengujis))
                            @foreach($jadwalpengujis->results as $jadwalpenguji)
                            <tr>
                                <td><b>{{ $jadwalpenguji->dosen->user->username }}</b></td>
                                <td>{{ $jadwalpenguji->dosen->namadepan }} {{ $jadwalpenguji->dosen->namabelakang }}</td>
                                <td>
                                    @if( date('Y-m-d') > $jadwalpenguji->tanggal )
                                    <span class="badge badge-important">Selesai</span>
                                    @elseif(date('Y-m-d') <= $jadwalpenguji->tanggal)
                                    <b>{{ date('d-m-Y', strtotime($jadwalpenguji->tanggal)) }}</b>
                                    @endif
                                </td>
                                <td><b>{{ date('H:i', strtotime($jadwalpenguji->jam)) }}</b></td>
                                <td><b>{{ $jadwalpenguji->ruang }}</b></td>
                                <td class="action-col">
                                    <span class="btn-group">
                                        @if($menu2 == 'Jadwal Penguji Seminar Proposal')
                                        <a href="{{ URL::to_route('jadwalpengujisemprodetail', array(date('d-m-Y',strtotime($jadwalpenguji->tanggal)), date('H:i',strtotime($jadwalpenguji->jam)), Str::slug($jadwalpenguji->ruang))) }}" title="Lihat Detail Jadwal Penguji Sempro" class="btn btn-small"><i class="icon-search"></i></a>
                                        @elseif($menu2 == 'Jadwal Penguji Seminar Hasil')
                                        <a href="{{ URL::to_route('jadwalpengujisemhasdetail', array(date('d-m-Y',strtotime($jadwalpenguji->tanggal)), date('H:i',strtotime($jadwalpenguji->jam)), Str::slug($jadwalpenguji->ruang))) }}" title="Lihat Detail Jadwal Penguji Semhas" class="btn btn-small"><i class="icon-search"></i></a>
                                        @else
                                        <a href="{{ URL::to_route('jadwalpengujiujiandetail', array(date('d-m-Y',strtotime($jadwalpenguji->tanggal)), date('H:i',strtotime($jadwalpenguji->jam)), Str::slug($jadwalpenguji->ruang))) }}" title="Lihat Detail Jadwal Penguji Ujian TA" class="btn btn-small"><i class="icon-search"></i></a>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @if(!empty($jadwalpengujis))
            <center>{{ $jadwalpengujis->links() }}</center>
            @else
            @endif
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection