@layout('layout.admin.dashboard')

@section('style')

@endsection

@section('javascript')
<?= HTML::script('mhsdosen/custom-plugins/bootstrap-inputmask.min.js'); ?>
<?= HTML::script('mhsdosen/assets/js/demo/ui_comps.js'); ?>
@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">
            @if($menu2 == 'Seminar Proposal')
            Halaman Jadwal Seminar Proposal Mahasiswa <span>Halaman Untuk Melakukan Penjadwalan Seminar Proposal</span>
            @elseif($menu2 == 'Seminar Hasil')
            Halaman Jadwal Seminar Hasil Mahasiswa <span>Halaman Untuk Melakukan Penjadwalan Seminar Hasil</span>
            @else
            Halaman Jadwal Ujian TA Mahasiswa <span>Halaman Untuk Melakukan Penjadwalan Ujian TA</span>
            @endif
        </h1>
    </div>
    <div id="main-content">
        <div class="widget">
            @if(Session::has('message'))
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p id="message">{{ Session::get('message') }}</p>
            </div>
            @endif
            <div class="widget">
                <div class="widget-content form-container">
                    <div class="control-group">
                        <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Menjadwalkan Mahasiswa Yang Telah Terdaftar Seminar Proposal, Seminar Hasil Atau Ujian TA</b>
                    </div>
                </div>
            </div>
            <div class="widget-header">
                <span class="title"><i class="icol-arrow-right"></i> Daftar Mahasiswa Yang Telah Dijadwal</span>
                <div class="toolbar">
                    <div class="btn-group">
                        <span class="btn dropdown-toggle" data-toggle="dropdown">
                            <i class="icos-arrow-down icos-white"></i> &nbsp; Menu Jadwal &nbsp;<i class="caret"></i>
                        </span>
                        <ul class="dropdown-menu pull-right">
                            @if($menu2 == 'Seminar Proposal')
                            <li><a href="" data-target="#myModal" data-toggle="modal"><i class="icol-calendar-2"></i> Jadwalkan Seminar Proposal</a></li>
                            @elseif($menu2 == 'Seminar Hasil')
                            <li><a href="" data-target="#myModal" data-toggle="modal"><i class="icol-calendar-2"></i> Jadwalkan Seminar Hasil</a></li>
                            @else
                            <li><a href="" data-target="#myModal" data-toggle="modal"><i class="icol-calendar-2"></i> Jadwalkan Ujian TA</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
                <div class="modal-header">
                    @if($menu2 == 'Seminar Proposal')
                    <h3 id="myModalLabel">Mahasiswa Belum Terdaftar Seminar Proposal</h3>
                    @elseif($menu2 == 'Seminar Hasil')
                    <h3 id="myModalLabel">Mahasiswa Belum Terdaftar Seminar Hasil</h3>
                    @else
                    <h3 id="myModalLabel">Mahasiswa Belum Terdaftar Ujian TA</h3>
                    @endif
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        @if($menu2 == 'Seminar Proposal')
                        {{ Form::open('admin/jadwal/sempro', 'POST') }}
                        @elseif($menu2 == 'Seminar Hasil')
                        {{ Form::open('admin/jadwal/semhas', 'POST') }}
                        @else
                        {{ Form::open('admin/jadwal/ujian', 'POST') }}
                        @endif
                        {{ Form::token() }}
                        <thead>
                            <tr>
                                <th>Pilih Tanggal & Waktu</th>
                                <th>Pilih Ruang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input id="demo-datepicker-01" type="text" class="span2 datepicker-basic" name="tanggal" placeholder="08/05/2013" required>
                                    <input type="text" name="jam" data-mask="$9:@9" data-definitions='{ "$": "[0-2]", "@": "[0-6]" }' class="span1" placeholder="09:00" required>
                                </td>
                                <td>
                                    <input type="text" name="ruang" list="listruang" placeholder="Ketik No Ruang" required>
                                    <datalist id="listruang" >
                                        <option>418 GKB3
                                        <option>316 GKB3
                                        <option>604 GKB3
                                        <option>503 GKB3
                                        <option>407 GKB3
                                        <option>402 GKB3
                                        <option>Ruang Sidang
                                    </datalist>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($menu2 == 'Seminar Proposal')
                            @foreach($terdaftarsempro as $data)
                            <tr>
                                <td>{{ Form::checkbox('iddaftar[]', $data->id) }}</td>
                                <td><b>{{ $data->proposal->nim }}</b></td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ date("d-m-Y", strtotime($data->created_at)) }}</td>
                            </tr>
                            @endforeach
                            @elseif($menu2 == 'Seminar Hasil')
                            @foreach($terdaftarsemhas as $data)
                            <tr>
                                <td>{{ Form::checkbox('iddaftar[]', $data->id) }}</td>
                                <td><b>{{ $data->proposal->nim }}</b></td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ date("d-m-Y", strtotime($data->updated_at)) }}</td>
                            </tr>
                            @endforeach
                            @else
                            @foreach($terdaftarujian as $data)
                            <tr>
                                <td>{{ Form::checkbox('iddaftar[]', $data->id) }}</td>
                                <td><b>{{ $data->proposal->nim }}</b></td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ date("d-m-Y", strtotime($data->updated_at)) }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="return confirm('Apakah Anda Yakin Akan Jadwal Ini ?');">Jadwalkan</button>
                </div>
                {{ Form::close() }}
            </div>
            <div class="widget-content table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Ruang</th>
                            <th>Hasil</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($menu2 == 'Seminar Proposal')
                        @if(!empty($datajadwalsempro))
                        @foreach($datajadwalsempro as $data)
                        <tr>
                            <td><b>{{ $data->daftar->proposal->nim }}</b></td>
                            <td>{{ $data->daftar->nama }}</td>
                            <td>{{ Str::words($data->daftar->judul, 5) }}</td>
                            <td>
                                @if(date("Y-m-d") == $data->tanggal)
                                <span class="badge badge-info">Hari Ini</span>
                                @elseif(date("Y-m-d") > $data->tanggal)
                                <span class="badge badge-info">Selesai</span>
                                @else
                                <span>{{ date("d-m-Y", strtotime($data->tanggal)) }}</span>
                                @endif                              
                            </td>
                            <td>{{ date("H:i", strtotime($data->jam)) }}</td>
                            <td>{{ $data->ruang }}</td>
                            <td>@if($data->daftar->hasil->hasil_sempro == 0) <span class="badge badge-important">Belum</span> @else <span class="badge badge-warning">Sudah</span> @endif</td>
                            <td class="action-col">
                                <span class="btn-group">
                                    <a href="{{ URL::to_route('deletepenjadwalansempro', array($data->tanggal, $data->jam, Str::slug($data->ruang))) }}" class="btn btn-mini btn-primary" onclick="return confirm('Anda Yakin Jadwal Dan Seluruh Mahasiswa Yang Bersangkutan Akan Dihapus ?');">Hapus</a>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>Belum Ada Yang Dijadwal</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                        @elseif($menu2 == 'Seminar Hasil')
                        @if(!empty($datajadwalsemhas))
                        @foreach($datajadwalsemhas as $data)
                        <tr>
                            <td><b>{{ $data->daftar->proposal->nim }}</b></td>
                            <td>{{ $data->daftar->nama }}</td>
                            <td>{{ Str::words($data->daftar->judul, 8) }}</td>
                            <td>
                                @if(date("Y-m-d") == $data->tanggal)
                                <span class="badge badge-info">Hari Ini</span>
                                @elseif(date("Y-m-d") > $data->tanggal)
                                <span class="badge badge-info">Selesai</span>
                                @else
                                <span>{{ date("d-m-Y", strtotime($data->tanggal)) }}</span>
                                @endif                              
                            </td>
                            <td>{{ date("H:i", strtotime($data->jam)) }}</td>
                            <td>{{ $data->ruang }}</td>
                            <th>--</th>
                            <td class="action-col">
                                <span class="btn-group">
                                    <a href="{{ URL::to_route('deletepenjadwalansemhas', array($data->tanggal, $data->jam, Str::slug($data->ruang))) }}" class="btn btn-mini btn-primary" onclick="return confirm('Anda Yakin Jadwal Dan Seluruh Mahasiswa Yang Bersangkutan Akan Dihapus ?');">Hapus</a></span>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>Belum Ada Yang Dijadwal</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                        @else
                        @if(!empty($datajadwalujian))
                        @foreach($datajadwalujian as $data)
                        <tr>
                            <td><b>{{ $data->daftar->proposal->nim }}</b></td>
                            <td>{{ $data->daftar->nama }}</td>
                            <td>{{ Str::words($data->daftar->judul, 8) }}</td>
                            <td>
                                @if(date("Y-m-d") == $data->tanggal)
                                <span class="badge badge-info">Hari Ini</span>
                                @elseif(date("Y-m-d") > $data->tanggal)
                                <span class="badge badge-info">Selesai</span>
                                @else
                                <span>{{ date("d-m-Y", strtotime($data->tanggal)) }}</span>
                                @endif                              
                            </td>
                            <td>{{ date("H:i", strtotime($data->jam)) }}</td>
                            <td>{{ $data->ruang }}</td>
                            <th>
                                @if($data->daftar->hasil->hasil_ujian == 0 || $data->daftar->hasil->hasil_ujian == 1) 
                                -- 
                                @elseif($data->daftar->hasil->hasil_ujian == 2) 
                                <span class="badge badge-important">Ujian Ulang</span> 
                                @else 
                                <span class="badge badge-warning">Sudah</span> 
                                @endif
                            </th>
                            <td class="action-col">
                                <span class="btn-group">
                                    <a href="{{ URL::to_route('deletepenjadwalanujian', array($data->tanggal, $data->jam, Str::slug($data->ruang))) }}" class="btn btn-mini btn-primary" onclick="return confirm('Anda Yakin Jadwal Dan Seluruh Mahasiswa Yang Bersangkutan Akan Dihapus ?');">Hapus</a> 
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>Belum Ada Yang Dijadwal</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
