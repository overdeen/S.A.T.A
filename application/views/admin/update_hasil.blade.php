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
            @if($menu2 == 'Update Hasil Seminar Proposal')
            Halaman Update Hasil Seminar Proposal <span>Halaman Untuk Melakukan Update Hasil Seminar Proposal</span>
            @elseif($menu2 == 'Update Hasil Ujian TA')
            Halaman Update Hasil Ujian TA <span>Halaman Untuk Melakukan Update Hasil Ujian TA</span>
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
                    <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Melakukan Update Hasil Seminar Proposal, Seminar Hasil Atau Ujian TA</b>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span7 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Daftar Mahasiswa Terdaftar Dan Terjadwal ( Belum Ada Hasil )</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Pelaksanaan</th>
                                <th>Hasil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($menu2 == 'Update Hasil Seminar Proposal')
                            @if(empty($daftarall->results))
                            <tr>
                                <td>Belum Ada Yang Terjadwal</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @else
                            @foreach($daftarall->results as $data)
                            <tr>
                                <td><b><a href="{{ URL::to_route('editupdatehasilsempro', Crypter::encrypt($data->id)) }}" rel="tooltip" title="Update Hasil" data-placement="top">{{ $data->daftar->proposal->nim }}</a></b></td>
                                <td>{{ $data->daftar->nama }}</td>
                                <td>
                                    @if(date("Y-m-d") == $data->daftar->jadwalsempro->tanggal)
                                    <span class="badge badge-warning">Hari Ini</span>
                                    @elseif(date("Y-m-d") > $data->daftar->jadwalsempro->tanggal)
                                    <span class="badge badge-important">Selesai</span>
                                    @else
                                    <b>{{ date("d-m-Y", strtotime($data->daftar->jadwalsempro->tanggal)) }}</b>
                                    @endif                              
                                </td>
                                <td>
                                    @if($data->hasil_sempro == 2)
                                    <span class="badge badge-info">Revisi</span>
                                    @elseif($data->hasil_sempro == 0)
                                    --
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            @else
                            @if(empty($daftarall->results))
                            <tr>
                                <td>Belum Ada Yang Terjadwal</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @else
                            @foreach($daftarall->results as $data)
                            <tr>
                                <td><b><a href="{{ URL::to_route('editupdatehasilujian', Crypter::encrypt($data->id)) }}" rel="tooltip" title="Update Hasil" data-placement="top">{{ $data->daftar->proposal->nim }}</a></b></td>
                                <td>{{ $data->daftar->nama }}</td>
                                <td>
                                    @if(empty($data->daftar->jadwalujian->tanggal))
                                    <span class="badge badge-success">Ujian Ulang</span>
                                    @elseif($data->hasil_ujian == 2)
                                    @if(date("Y-m-d") == $data->daftar->jadwalujian->tanggal)
                                    <span class="badge badge-warning">Hari Ini</span> <span class="badge badge-success">Ujian Ulang</span>
                                    @elseif(date("Y-m-d") > $data->daftar->jadwalujian->tanggal)
                                    <span class="badge badge-important">Selesai</span> <span class="badge badge-success">Ujian Ulang</span>
                                    @else
                                    <b>{{ date('d-m-Y', strtotime($data->daftar->jadwalujian->tanggal)) }}</b> <span class="badge badge-success">Ujian Ulang</span>
                                    @endif
                                    @else
                                    @if(date("Y-m-d") == $data->daftar->jadwalujian->tanggal)
                                    <span class="badge badge-warning">Hari Ini</span>
                                    @elseif(date("Y-m-d") > $data->daftar->jadwalujian->tanggal)
                                    <span class="badge badge-important">Selesai</span>
                                    @else
                                    <b>{{ date('d-m-Y', strtotime($data->daftar->jadwalujian->tanggal)) }}</b>
                                    @endif  
                                    @endif         
                                </td>
                                <td>
                                    @if(empty($data->nilai_ujian))
                                    --
                                    @elseif($data->nilai_ujian == 'A')
                                    <span class="badge badge-info">A</span>
                                    @elseif($data->nilai_ujian == 'B+')
                                    <span class="badge badge-info">B+</span>
                                    @elseif($data->nilai_ujian == 'B')
                                    <span class="badge badge-info">B</span>
                                    @elseif($data->nilai_ujian == 'C+')
                                    <span class="badge badge-info">C+</span>
                                    @elseif($data->nilai_ujian == 'C')
                                    <span class="badge badge-info">C</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            @endif
                        </tbody>
                    </table>
                    @if(empty($daftarall->results))
                    <!-- Tidak Ada Data -->
                    @else
                    <div class="pagination pagination-centered">{{ $daftarall->links() }}</div>
                    @endif
                </div>  
            </div>
            <div class="span5 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i> Detail Proposal Dan Update Hasil</span>
                </div>
                <div class="widget-content form-container">
                    @if($datamahasiswa == 'null')
                    <div class="control-group">
                        <label class="control-label">--- No Detail ---</label>
                        <div class="controls"></div>
                    </div>
                    @else
                    @if($menu2 == 'Update Hasil Seminar Proposal')
                    {{ Form::open('admin/update/hasilsempro', 'PUT', array('class' => 'form-horizontal')) }}
                    @else
                    {{ Form::open('admin/update/hasilujian', 'PUT', array('class' => 'form-horizontal')) }}
                    @endif
                    {{ Form::token() }}
                    <input type="hidden" name="id" value="{{ $datamahasiswa->id }}">@if($menu2 == 'Update Hasil Ujian TA') <input type="hidden" name="iddaftar" value="{{ $datamahasiswa->daftar_id }}"> @endif
                    <div class="control-group">
                        <label class="control-label">NIM Mahasiswa</label>
                        <div class="controls">
                            <b>{{ $datamahasiswa->daftar->proposal->nim }}</b>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nama Mahasiswa</label>
                        <div class="controls">
                            <b>{{ $datamahasiswa->daftar->nama }}</b>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Judul Tugas Akhir</label>
                        <div class="controls">
                            {{ $datamahasiswa->daftar->judul }}
                        </div>
                    </div>
                    @if($menu2 == 'Update Hasil Ujian TA')
                    @else
                    <div class="control-group">
                        <label class="control-label">Hasil Seminar Proposal</label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="hasil" value="1" class="uniform">
                                Diterima
                            </label>
                            <label class="radio">
                                <input type="radio" name="hasil" value="2" class="uniform">
                                Direvisi
                            </label>
                            <label class="radio">
                                <input type="radio" name="hasil" value="3" class="uniform">
                                Ditolak
                            </label>
                        </div>
                    </div>
                    @endif
                    @if($menu2 == 'Update Hasil Ujian TA')
                    <div class="control-group">
                        <label class="control-label">Nilai Ujian TA</label>
                        <div class="controls" required>
                            <label class="radio">
                                <input type="radio" name="nilai" value="A" class="uniform">A
                            </label>
                            <label class="radio">
                                <input type="radio" name="nilai" value="B+" class="uniform">B+
                            </label>
                            <label class="radio">
                                <input type="radio" name="nilai" value="B" class="uniform">B
                            </label>
                            <label class="radio">
                                <input type="radio" name="nilai" value="C+" class="uniform">C+
                            </label>
                            <label class="radio">
                                <input type="radio" name="nilai" value="C" class="uniform">C
                            </label>
                            <label class="radio">
                                <input type="radio" name="nilai" value="D" class="uniform">D
                            </label>
                            <label class="radio">
                                <input type="radio" name="nilai" value="E" class="uniform">E
                            </label>
                        </div>
                    </div>
                    @endif
                    <div class="control-group">
                        <label class="control-label">Catatan</label>
                        <div class="controls">
                            <textarea name="catatan" class="span12" required></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    {{ Form::close() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
