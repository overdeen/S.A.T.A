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
            @if($menu2 == 'Penguji Seminar Proposal')
            Halaman Jadwal Penguji Seminar Proposal <span>Halaman Untuk Melakukan Penjadwalan Penguji Seminar Proposal</span>
            @elseif($menu2 == 'Penguji Seminar Hasil')
            Halaman Jadwal Penguji Seminar Hasil <span>Halaman Untuk Melakukan Penjadwalan Penguji Seminar Hasil</span>
            @else
            Halaman Jadwal Penguji Ujian TA <span>Halaman Untuk Melakukan Penjadwalan Penguji Ujian TA</span>
            @endif
        </h1>
    </div>
    <div id="main-content">
        <div class="row-fluid">
            @if(Session::has('message'))
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p id="message">{{ Session::get('message') }}</p>
            </div>
            @endif
        </div>
        <div class="widget">
            <div class="widget-content form-container">
                <div class="control-group">
                    <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Menjadwalkan Penguji Seminar Proposal, Seminar Hasil Atau Ujian TA</b>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Pilih Tanggal, Jam Dan Ruang Pelaksanaan</span>
                </div>
                <div class="widget-content goal">
                    <table class="table table-striped">
                        @if($menu2 == 'Penguji Seminar Proposal')
                        {{ Form::open('admin/jadwalpenguji/sempro', 'POST') }}
                        @elseif($menu2 == 'Penguji Seminar Hasil')
                        {{ Form::open('admin/jadwalpenguji/semhas', 'POST') }}
                        @else
                        {{ Form::open('admin/jadwalpenguji/ujian', 'POST') }}
                        @endif
                        {{ Form::token() }}
                        <thead>
                            <tr>
                                <th>Pilih Tanggal Dan Jam</th>
                                <th>Pilih Ruang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input id="demo-datepicker-01" type="text" class="span6 datepicker-basic" name="tanggal" placeholder="08/05/2013" required>
                                    <input type="text" name="jam" data-mask="$9:@9" data-definitions='{ "$": "[0-2]", "@": "[0-6]" }' class="span4" placeholder="09:00" required>
                                </td>
                                <td>
                                    <input type="text" name="ruang" list="listruang" class="span12" placeholder="Ketik Ruang" required>
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
                                <td>
                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                </td>
                            </tr>
                        </tbody>
                        {{ Form::close() }}
                    </table>
                </div>
            </div>
            @if(empty($tanggal))
            @else
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-table"></i> Tanggal, Jam, dan Ruang Pilihan</span>
                </div>
                <div class="widget-content goal">
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span4">
                                {{ date("d-m-Y", strtotime($tanggal)) }}
                                <small>Tanggal</small>
                            </div>
                            <div class="info span4">
                                {{ $jam }}
                                <small>Pukul</small>
                            </div>
                            <div class="info span4">
                                {{ $ruang }}
                                <small>Ruang</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Daftar Mahasiswa Telah Terjadwal</span>
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
                            </tr>
                        </thead>
                        <tbody>
                            @if($menu2 == 'Penguji Seminar Proposal')
                            <!-- -->
                            @if(!empty($datajadwalsempro))
                            @foreach($datajadwalsempro as $data)
                            <tr>
                                <td><b>{{ $data->daftar->proposal->nim }}</b></td>
                                <td>{{ $data->daftar->nama }}</td>
                                <td>{{ Str::words($data->daftar->judul, 10) }}</td>
                                <td><b>{{ date("d-m-Y", strtotime($data->tanggal)) }}</b></td>
                                <td><b>{{ date("H:i", strtotime($data->jam)) }}</b></td>
                                <td><b>{{ $data->ruang }}</b></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Data</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            <!-- -->
                            @elseif($menu2 == 'Penguji Seminar Hasil')
                            <!-- -->
                            @if(!empty($datajadwalsemhas))
                            @foreach($datajadwalsemhas as $data)
                            <tr>
                                <td><b>{{ $data->daftar->proposal->nim }}</b></td>
                                <td>{{ $data->daftar->nama }}</td>
                                <td>{{ Str::words($data->daftar->judul, 10) }}</td>
                                <td><b>{{ date("d-m-Y", strtotime($data->tanggal)) }}</b></td>
                                <td><b>{{ date("H:i", strtotime($data->jam)) }}</b></td>
                                <td><b>{{ $data->ruang }}</b></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Data</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            <!-- -->
                            @else
                            <!-- -->
                            @if(!empty($datajadwalujian))
                            @foreach($datajadwalujian as $data)
                            <tr>
                                <td><b>{{ $data->daftar->proposal->nim }}</b></td>
                                <td>{{ $data->daftar->nama }}</td>
                                <td>{{ Str::words($data->daftar->judul, 10) }}</td>
                                <td><b>{{ date("d-m-Y", strtotime($data->tanggal)) }}</b></td>
                                <td><b>{{ date("H:i", strtotime($data->jam)) }}</b></td>
                                <td><b>{{ $data->ruang }}</b></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Data</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            <!-- -->
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6 widget">
                @if($menu2 == 'Penguji Seminar Proposal')
                {{ Form::open('admin/jadwalpenguji/sempro', 'POST', array('class' => 'form-horizontal')) }}
                @elseif($menu2 == 'Penguji Seminar Hasil')
                {{ Form::open('admin/jadwalpenguji/semhas', 'POST', array('class' => 'form-horizontal')) }}
                @else
                {{ Form::open('admin/jadwalpenguji/ujian', 'POST', array('class' => 'form-horizontal')) }}
                @endif
                {{ Form::token() }}
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Dosen Penguji Belum Terjadwal</span>
                </div>
                <div class="widget-content table-container">
                    @if(!empty($datajadwalsempro) || !empty($datajadwalsemhas) || !empty($datajadwalujian))
                    <input type="hidden" name="tanggal" value="{{ $tanggal }}"><input type="hidden" name="jam" value="{{ $jam }}"><input type="hidden" name="ruang" value="{{ $ruang }}">
                    @endif
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>NIP/NIDP</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($menu2 == 'Penguji Seminar Proposal')
                            @if(!empty($datajadwalsempro))
                            <!-- Awal Data Jadwal Penguji Sempro Belum Terjadwal -->
                            @foreach($datadosenterjadwal as $data)
                            <tr>
                                <td>{{ Form::checkbox('idpenguji[]', $data->id) }}</td>
                                <td><b>{{ $data->user->username }}</b></td>
                                <td>{{ $data->namadepan }} {{ $data->namabelakang }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Data</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            <!-- Akhir Data Jadwal Penguji Sempro Belum Terjadwal -->
                            @elseif($menu2 == 'Penguji Seminar Hasil')
                            @if(!empty($datajadwalsemhas))
                            <!-- Awal Data Jadwal Penguji Sempro Belum Terjadwal -->
                            @foreach($datadosenterjadwal as $data)
                            <tr>
                                <td>{{ Form::checkbox('idpenguji[]', $data->id) }}</td>
                                <td><b>{{ $data->user->username }}</b></td>
                                <td>{{ $data->namadepan }} {{ $data->namabelakang }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Data</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            <!-- Akhir Data Jadwal Penguji Semhas Belum Terjadwal -->
                            @else
                            @if(!empty($datajadwalujian))
                            <!-- Awal Data Jadwal Penguji Ujian Belum Terjadwal -->
                            @foreach($datadosenterjadwal as $data)
                            <tr>
                                <td>{{ Form::checkbox('idpenguji[]', $data->id) }}</td>
                                <td><b>{{ $data->user->username }}</b></td>
                                <td>{{ $data->namadepan }} {{ $data->namabelakang }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Data</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            <!-- Akhir Data Jadwal Penguji Ujian Belum Terjadwal -->
                            @endif
                        </tbody>
                    </table>
                    @if($menu2 == 'Penguji Seminar Proposal')
                    @if(!empty($datajadwalsempro)) <button style="float:right;" class="btn btn-primary">Jadwalkan</button> @else  @endif
                    @elseif($menu2 == 'Penguji Seminar Hasil')
                    @if(!empty($datajadwalsemhas)) <button style="float:right;" class="btn btn-primary">Jadwalkan</button> @else  @endif
                    @else
                    @if(!empty($datajadwalujian)) <button style="float:right;" class="btn btn-primary">Jadwalkan</button> @else  @endif
                    @endif 
                </div>
                {{ Form::close() }}
            </div>
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Dosen Penguji Terjadwal</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIP/NIDP</th>
                                <th>Nama</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($menu2 == 'Penguji Seminar Proposal')
                            <!-- Awal Data Jadwal Penguji Sempro Terjadwal -->
                            @if(!empty($datajadwalsempro))
                            @foreach($datadosen as $data)
                            <tr>
                                <td><b>{{ $data->dosen->user->username }}</b></td>
                                <td>{{ $data->dosen->namadepan }} {{ $data->dosen->namabelakang }}</td>
                                <td class="action-col">
                                    <span class="btn-group">
                                        <a href="{{ URL::to_route('deletepenjadwalanpengujisempro', Crypter::encrypt($data->id)) }}" class="btn btn-mini btn-primary" onclick="return confirm('Anda Yakin Dosen Yang Bersangkutan Akan Dihapus Dari Jadwal ?');">Hapus</a>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Data</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            <!-- Akhir Data Jadwal Penguji Sempro Terjadwal -->
                            @elseif($menu2 == 'Penguji Seminar Hasil')
                            <!-- Awal Data Jadwal Penguji Semhas Terjadwal -->
                            @if(!empty($datajadwalsemhas))
                            @foreach($datadosen as $data)
                            <tr>
                                <td><b>{{ $data->dosen->user->username }}</b></td>
                                <td>{{ $data->dosen->namadepan }} {{ $data->dosen->namabelakang }}</td>
                                <td class="action-col">
                                    <span class="btn-group">
                                        <a href="{{ URL::to_route('deletepenjadwalanpengujisemhas', Crypter::encrypt($data->id)) }}" class="btn btn-mini btn-primary" onclick="return confirm('Anda Yakin Dosen Yang Bersangkutan Akan Dihapus Dari Jadwal ?');">Hapus</a>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Data</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            <!-- Akhir Data Jadwal Penguji Semhas Terjadwal -->
                            @else
                            <!-- Awal Data Jadwal Penguji Ujian Terjadwal -->
                            @if(!empty($datajadwalujian))
                            @foreach($datadosen as $data)
                            <tr>
                                <td><b>{{ $data->dosen->user->username }}</b></td>
                                <td>{{ $data->dosen->namadepan }} {{ $data->dosen->namabelakang }}</td>
                                <td class="action-col">
                                    <span class="btn-group">
                                        <a href="{{ URL::to_route('deletepenjadwalanpengujiujian', Crypter::encrypt($data->id)) }}" class="btn btn-mini btn-primary" onclick="return confirm('Anda Yakin Dosen Yang Bersangkutan Akan Dihapus Dari Jadwal ?');">Hapus</a>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Data</td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            <!-- Akhir Data Jadwal Penguji Ujian Terjadwal -->
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
