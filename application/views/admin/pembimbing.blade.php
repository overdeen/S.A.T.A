@layout('layout.admin.dashboard')

@section('style')

@endsection

@section('javascript')
<?= HTML::script('mhsdosen/assets/js/demo/ui_comps.js'); ?>
@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">
            Halaman Manage Pembimbing <span>Halaman Untuk Melakukan Pengaturan Pembimbing</span>
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
            <div class="widget-content form-container">
                <div class="control-group">
                    <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Menambahkan Pembimbing Mahasiswa Sesuai Dengan Surat Keputusan Tugas Akhir</b>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i> Daftar Mahasiswa Dengan Hasil Seminar Proposal == DITERIMA</span>
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>SK Berakhir</th>
                                <th>Pembimbing 1</th>
                                <th>Pembimbing 2</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($daftarsempro->results))
                            <tr>
                                <td>Belum Ada Yang Terjadwal</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @else
                            @foreach($daftarsempro->results as $data)
                            <tr>
                                <td><a href="{{ URL::to_route('tambahpembimbingmahasiswa', Crypter::encrypt($data->daftar->id)) }}" rel="tooltip" title="Pengaturan Dosen Pembimbing TA" data-placement="top"><b>{{ $data->daftar->proposal->nim }}</b></a></td>
                                <td>{{ $data->daftar->nama }}</td>
                                <td>{{ Str::words($data->daftar->judul, 5) }}</td>
                                <td>
                                    @if(empty($data->daftar->suratkeputusan->akhirtanggal))
                                    --
                                    @else
                                    {{ date('d-m-Y', strtotime($data->daftar->suratkeputusan->akhirtanggal)) }}
                                    @endif
                                </td>
                                @foreach($data->daftar->bimbingan as $data)
                                <td>
                                    @if($data->dosen_id == 0)
                                    --
                                    @else
                                    {{ $data->dosen->namadepan }} {{ $data->dosen->namabelakang }}
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    @if(empty($daftarsempro->results))
                    <!-- Tidak Ada Data -->
                    @else
                    <div class="pagination pagination-centered">{{ $daftarsempro->links() }}</div>
                    @endif
                </div>  
            </div>
        </div>
        @if($detailmahasiswa == 'null')
        @else
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Pengaturan Pembimbing Tugas Akhir</span>
                </div>
                <div class="widget-content form-container">
                    {{ Form::open('admin/pembimbing/add', 'PUT', array('class' => 'form-horizontal')) }}{{ Form::token() }}
                    <input type="hidden" name="idbimbingan1" value="{{ $pembimbing1->id }}"><input type="hidden" name="idbimbingan2" value="{{ $pembimbing2->id }}"><input type="hidden" name="iddaftar" value="{{ $pembimbing1->daftar_id }}">
                    <fieldset>
                        <legend>Info Proposal Mahasiswa</legend>
                        <input type="hidden" name="idproposal"/>
                        <div class="control-group">
                            <label class="control-label">Nama Mahasiswa</label>
                            <div class="controls">
                                <input type="text" name="nama" class="span4" value="{{ $getalldata['nama'] }}" readonly="readonly"/> &nbsp;<input type="text" class="span2" value="{{ $getalldata['nim'] }}" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Judul Proposal</label>
                            <div class="controls">
                                <textarea id="pass2" name="judul" class="span12" readonly="readonly">{{ $getalldata['judul'] }}</textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Pembimbing 1</label>
                            <div class="controls">
                                @if($pembimbing1->dosen_id == 0)
                                <select name="dosenpembimbing1">
                                    <option value="0">Belum Ada Pembimbing 1</option>
                                    @foreach($listdosen as $data)
                                    <option value="{{ $data->id }}" >{{ $data->namadepan }} {{ $data->namabelakang }}</option>
                                    @endforeach
                                </select>
                                @else
                                <input type="text" name="dokumen" class="span4" value="{{ $pembimbing1->dosen->namadepan }} {{ $pembimbing1->dosen->namabelakang }}" readonly="readonly"/>
                                <select class="span4" name="dosenpembimbing1">
                                    <option value="{{ $pembimbing1->dosen_id }}">- Ganti Dosen Pembimbing 1 -</option>
                                    <option value="{{ $pembimbing1->dosen_id }}">( Tetap ) {{ $pembimbing1->dosen->namadepan }} {{ $pembimbing1->dosen->namabelakang }}</option>
                                    @foreach($listdosen as $data)
                                    <option value="{{ $data->id }}" >{{ $data->namadepan }} {{ $data->namabelakang }}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Pembimbing 2</label>
                            <div class="controls">
                                @if($pembimbing2->dosen_id == 0)
                                <select name="dosenpembimbing2">
                                    <option value="0">Belum Ada Pembimbing 2</option>
                                    @foreach($listdosen as $data)
                                    <option value="{{ $data->id }}" >{{ $data->namadepan }} {{ $data->namabelakang }}</option>
                                    @endforeach
                                </select>
                                @else
                                <input type="text" name="dokumen" class="span4" value="{{ $pembimbing2->dosen->namadepan }} {{ $pembimbing2->dosen->namabelakang }}" readonly="readonly"/>
                                <select class="span4" name="dosenpembimbing2">
                                    <option value="{{ $pembimbing2->dosen_id }}">- Ganti Dosen Pembimbing 2 -</option>
                                    <option value="{{ $pembimbing2->dosen_id }}">( Tetap ) {{ $pembimbing2->dosen->namadepan }} {{ $pembimbing2->dosen->namabelakang }}</option>
                                    @foreach($listdosen as $data)
                                    <option value="{{ $data->id }}" >{{ $data->namadepan }} {{ $data->namabelakang }}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Tanggal SK</label>
                            <div class="controls">
                                @if(empty($srtkeputusan))
                                ( Tanggal Awal ) - <input type="text" name="skmulai" id="demo-datepicker-01" class="span2 datepicker-basic" required>
                                @else
                                ( Tanggal Awal ) - <input type="text" class="span2" value="{{ date('m/d/Y', strtotime($srtkeputusan->awaltanggal)) }}" readonly='readonly'> - 
                                ( Tanggal Akhir ) - <input type="text" class="span2" value="{{ date('m/d/Y', strtotime($srtkeputusan->akhirtanggal)) }}" readonly='readonly'>
                                @endif
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions">
                        @if($pembimbing1->dosen_id == 0 || $pembimbing2->dosen_id == 0)
                        <input type="submit" value="Tambah Pembimbing" class="btn btn-primary pull-right" onclick="return confirm('Anda Yakin Akan Menambahkan Dosen Yang Bersangkutan Menjadi Dosen Pembimbing ?');"/>
                        @else
                        <input type="submit" value="Update Pembimbing" class="btn btn-primary pull-right" onclick="return confirm('Anda Yakin Akan Mengubah Dosen Pembimbing Mahasiswa Yang Bersangkutan ?');"/>
                        @endif
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@section('script')

@endsection

