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
            Halaman Asistensi Bimbingan Tugas Akhir <span>Halaman Untuk Melakukan Asistensi Bimbingan Mahasiswa</span>
        </h1>
    </div>
    <div id="main-content">
        @if(Session::has('message'))
        <div class="row-fluid">
            <div class="widget">
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p id="message">{{ Session::get('message') }}</p>
                </div>
            </div>
        </div>
        @endif  
        <div class="widget">
            <div class="widget-content form-container">
                <div class="control-group">
                    <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Melakukan Bimbingan Mahasiswa Dan Memberikan Rekomendasi Semhas & Ujian TA</b>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title">
                        <i class="icol-arrow-right"></i>Daftar Mahasiswa Bimbingan Tugas Akhir
                    </span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Tahun</th>
                                <th>Status Semhas & Ujian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($mhsbimbingan->results))
                            <tr>
                                <td>Tidak Ada Mahasiswa Bimbingan</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @else
                            @foreach($mhsbimbingan->results as $data)
                            <tr>
                                <td><b><a href="{{ URL::to_route('detailasistensibimbingan', Crypter::encrypt($data->id)) }}" rel="tooltip" title="Lihat Detail" data-placement="top">{{ $data->daftar->proposal->nim }}</a></b></td>
                                <td>{{ $data->daftar->nama }}</td>
                                <td>{{ Str::words($data->daftar->judul, 10) }}</td>
                                <td>{{ $data->daftar->proposal->tahun }}</td>
                                <td>
                                    @if($data->rekomendasi == 0)
                                    --
                                    @else
                                    <span class="badge badge-info">Direkomendasikan</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <center>{{ $mhsbimbingan->links() }}</center> 
                </div>
            </div>
        </div>
        @if($detailasistensi == 'null')
        @else
        <div class="row-fluid">
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Asistensi Pembimbing {{ $detailasistensi->is_dosen }} -- {{ $detailasistensi->dosen->namadepan }} {{ $detailasistensi->dosen->namabelakang }}</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Catatan Bimbingan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($catatanasistensi))
                            <tr>
                                <td>Belum Ada Catatan</td>
                                <td></td>
                            </tr>
                            @else
                            @foreach($catatanasistensi as $data)
                            <tr>
                                <td><b>{{ date('d-m-Y', strtotime($data->created_at)) }}</b></td>
                                <td><span rel="popover" data-trigger="hover" title="Catatan Bimbingan" data-placement="top" data-content="{{ $data->catatan }}">{{ Str::words($data->catatan, 9) }}</span></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div> 
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Asistensi Pembimbing {{ $datadosen->is_dosen }} -- {{ $datadosen->dosen->namadepan }} {{ $datadosen->dosen->namabelakang }}</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Catatan Bimbingan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($catatanlain))
                            <tr>
                                <td>Belum Ada Catatan</td>
                                <td></td>
                            </tr>
                            @else
                            @foreach($catatanlain as $data)
                            <tr>
                                <td><b>{{ date('d-m-Y', strtotime($data->created_at)) }}</b></td>
                                <td><span rel="popover" data-trigger="hover" title="Catatan Bimbingan" data-placement="top" data-content="{{ $data->catatan }}">{{ Str::words($data->catatan, 9) }}</span></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span8 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Asistensi Bimbingan Tugas Akhir</span>
                </div>
                <div class="widget-content form-container">
                    {{ Form::open('dosen/bimbingan/catatan', 'POST', array('class' => 'form-horizontal')) }}{{ Form::token() }}
                    <fieldset>
                        <input type="hidden" name="bimbinganid" value="{{ $idbimbingan }}"/>
                        <div class="control-group">
                            <label class="control-label">NIM</label>
                            <div class="controls">
                                <input type="text" class="span12" value="{{ $detailasistensi->daftar->proposal->nim }}" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nama</label>
                            <div class="controls">
                                <input type="text" class="span12" value="{{ $detailasistensi->daftar->nama }}" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Judul</label>
                            <div class="controls">
                                <textarea class="span12" readonly="readonly">{{ $detailasistensi->daftar->judul }}</textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tanggal</label>
                            <div class="controls">
                                <input type="text" class="span12" value="{{ date('d-m-Y') }}" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Catatan</label>
                            <div class="controls">
                                <textarea type="text" name="catatan" class="span12" required/></textarea>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions">
                        <input type="submit" value="Asistensi Bimbingan" class="btn btn-primary pull-right"/>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="span4 widget">
                <div class="widget-header">
                    <span class="title">Rekomendasi Semhas & Ujian TA</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                {{ Form::open('dosen/bimbingan/rekomendasi', 'PUT', array('class' => 'form-horizontal')) }}{{ Form::token() }}
                        <input type="hidden" name="bimbinganid" value="{{ $idbimbingan }}">
                        <td>
                            @if($detailasistensi->rekomendasi == 0)
                        <center><button class="btn btn-danger btn-large" onclick="return confirm('Apakah Anda Yakin Akan Merekomendasikan Untuk Seminar Hasil Dan Ujian Tugas Akhir ?');">REKOMENDASIKAN</button></center>
                        @else
                        <center><button class="btn btn-danger btn-large" disabled>TELAH DIREKOMENDASIKAN</button></center>
                        @endif    
                        </td>
                        {{ Form::close() }}
                        </tr>
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
