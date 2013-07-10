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
            @if($menu2 == 'Jadwal Seminar Proposal')
            Halaman Jadwal Seminar Proposal <span>Halaman Untuk Melihat Jadwal Seminar Proposal</span>
            @elseif($menu2 == 'Jadwal Seminar Hasil')
            Halaman Jadwal Seminar Hasil <span>Halaman Untuk Melihat Jadwal Seminar Hasil</span>
            @else
            Halaman Jadwal Ujian TA <span>Halaman Untuk Melihat Jadwal Ujian TA</span>
            @endif
        </h1>
    </div>

    <div id="main-content">
        <div class="widget">
            <div class="widget-content form-container">
                <form class="form-horizontal">
                    <div class="control-group">
                        <ul>
                            <li>Pada Halaman Ini Berisikan Informasi Dari Proposal Yang telah Didaftarkan Dan Waktu Pelaksanaan.</li>
                            <li>Jika Mahasiswa Yang Bersangkutan Belum Dijadwalkan Oleh Petugas Dimohon Untuk Bersabar.</li>
                            <li>Jika Mahasiswa Yang Bersangkutan Telah Dijadwalkan Oleh Petugas, Akan Terlihat Waktu Pelaksanaan Mulai Dari Tanggal, Waktu, Dan Ruang.</li>
                            @if($menu2 == 'Jadwal Seminar Proposal')
                            <li>Jika Telah Selesai Melakukan Seminar Proposal Atau Ujian TA, Mahasiswa Dapat Melihat Hasil Pada Menu <a href="{{ URL::to_route('hasilsempro') }}">Hasil Seminar Proposal.</a></li>
                            @elseif($menu2 == 'Jadwal Seminar Hasil')
                            <li>Hasil Seminar Hasil Akan Dijadikan Satu Dengan Hasil Ujian TA.</li>
                            @else
                            <li>Jika Telah Selesai Melakukan Seminar Atau Ujian TA, Mahasiswa Dapat Melihat Hasil Pada Menu <a href="{{ URL::to_route('hasilujian') }}">Hasil Ujian TA.</a></li>
                            @endif
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span5 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Informasi Proposal</span>
                </div>
                <div class="widget-content table-container">
                    @if(empty($proposal))
                    <table class="table table-striped table-detail-view">
                        <thead>
                            <tr>
                                <th colspan="2">Maaf Anda Belum Dapat Dijadwalkan Pada Seminar Proposal, Seminar Hasil, Atau Ujian TA Dikarenakan Anda Belum Menambahkan Proposal</th>
                            </tr>
                        </thead>
                    </table>
                    @elseif(empty($daftar))
                    <table class="table table-striped table-detail-view">
                        <thead>
                            <tr>
                                @if($menu2 == 'Jadwal Seminar Proposal')
                                <th colspan="2">Maaf Anda Belum Dapat Dijadwalkan Pada Seminar Proposal Dikarenakan Anda Belum Mendaftar Seminar Proposal</th>
                                @elseif($menu2 == 'Jadwal Seminar Hasil')
                                <th colspan="2">Maaf Anda Belum Dapat Dijadwalkan Pada Seminar Hasil Dikarenakan Anda Belum Mendaftar Seminar Hasil</th>
                                @else
                                <th colspan="2">Maaf Anda Belum Dapat Dijadwalkan Pada Ujian TA Dikarenakan Anda Belum Mendaftar Ujian TA</th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                    @elseif(empty($jadwal))
                    <table class="table table-striped table-detail-view">
                        <thead>
                            <tr>
                                @if($menu2 == 'Jadwal Seminar Proposal')
                                <th colspan="2">Maaf Anda Belum Dijadwalkan, Mohon Untuk Bersabar</th>
                                @elseif($menu2 == 'Jadwal Seminar Hasil')
                                <th colspan="2">Maaf Anda Belum Dijadwalkan, Mohon Untuk Bersabar</th>
                                @else
                                <th colspan="2">Maaf Anda Belum Dijadwalkan, Mohon Untuk Bersabar</th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                    @else
                    <table class="table table-striped table-detail-view">
                        <tbody>
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <td>{{ $daftar->nama }}</td>
                            </tr>
                            <tr>
                                <th>Judul Proposal</th>
                                <td>{{ $daftar->judul }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Proposal</th>
                                <td>{{ $proposal->tahun }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
            <div class="span5 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Waktu Pelaksanaan</span>
                </div>
                @if(empty($proposal) || empty($daftar) || empty($jadwal))
                <div class="widget-content goal">
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span12">
                                <small>Belum Ada Waktu Pelaksanaan</small>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="widget-content goal">
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span6" rel="tooltip" data-placement="top" title="Tanggal Pelaksanaan">
                                {{ date("d-m-Y", strtotime($jadwal->tanggal)) }}
                                <small>Tanggal</small>
                            </div>
                            <div class="info span6" rel="tooltip" data-placement="top" title="Jam Pelaksanaan">
                                {{ date("H:i", strtotime($jadwal->jam)) }}
                                <small>Pukul</small>
                            </div>
                        </div>
                    </div>
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span6" rel="tooltip" data-placement="top" title="Ruang Pelaksanaan">
                                {{ $jadwal->ruang }}
                                <small>Ruang</small>
                            </div>
                            <div class="info span6" rel="tooltip" data-placement="top" title="Sisa Hari Menuju Hari Pelaksanaan">
                                {{ $sisawaktu }}
                                <small>Menuju Pelaksanaan</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="span2 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Nomor Urut</span>
                </div>
                @if(empty($proposal) || empty($daftar) || empty($jadwal))
                <div class="widget-content goal">
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span12">
                                <small>Belum Ada</small>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="widget-content goal">
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span12" rel="tooltip" data-placement="top" title="Nomor Urutan Maju Pada Saat Pelaksaan">
                                {{ $jadwal->nourut }}
                                <small>Urutan Maju</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @if(empty($proposal) || empty($daftar) || empty($jadwal))
        @else
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Seluruh Mahasiswa Di Ruang {{ $jadwal->ruang }} Pelaksanaan {{ date("d-m-Y", strtotime($jadwal->tanggal)) }} Pukul {{ date("H:i", strtotime($jadwal->waktu)) }}</span>
                </div>
                <div class="widget-content table-container">
                    <table id="demo-dtable-03" class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Pelaksanaan</th>
                                <th>No</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allsaturuang as $saturuang)
                            <tr>
                                <td><a href="{{ URL::to_route('lihatstatus', Crypter::encrypt($saturuang->daftar->proposal->id)) }}" rel="tooltip" data-placement="top" title="Lihat Profil Mahasiswa">{{ $saturuang->daftar->proposal->nim }}</a></td>
                                <td><b>{{ $saturuang->daftar->nama }}</b></td>
                                <td>{{ Str::words($saturuang->daftar->judul, 100) }}</td>
                                <td>{{ date("d-m-Y", strtotime($saturuang->tanggal ))}} {{ date("H:i", strtotime($saturuang->waktu)) }} {{ $saturuang->ruang }}</td>
                                <td><b>{{ $saturuang->nourut }}</b></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@section('script')

@endsection
