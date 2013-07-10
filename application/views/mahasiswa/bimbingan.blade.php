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
            Halaman Bimbingan Tugas Akhir <span>Halaman Untuk Melihat Lembar Asistensi Bimbingan Tugas Akhir</span>
        </h1>
    </div>
    <div id="main-content">
        @if($daftar == 'belumtambahproposal')
        <div class="widget">
            <div class="widget-content form-container">
                <div class="control-group">
                    <span class="badge badge-warning">Peringatan !!</span>&nbsp;&nbsp; <b>Anda Diharuskan Menambahkan Proposal Judul Tugas Akhir Terlebih Dahulu. Silahkan Menambahkan Proposal Melalui Menu <a href="">Tambah Proposal</a></b>
                </div>
            </div>
        </div>
        @elseif($daftar == 'belumdaftar')
        <div class="widget">
            <div class="widget-content form-container">
                <div class="control-group">
                    <span class="badge badge-warning">Peringatan !!</span>&nbsp;&nbsp; <b>Anda Diharuskan Mendaftar Seminar Proposal Terlebih Dahulu. Silahkan Mendaftar Seminar Proposal Melalui Menu <a href="">Daftar Seminar Proposal</a></b>
                </div>
            </div>
        </div>
        @else
        <div class="widget">
            <div class="widget-content form-container">
                <div class="control-group">
                    <span class="badge badge-info">Pemberitahuan</span>&nbsp;&nbsp;&nbsp; <b>Halaman Ini Digunakan Untuk Melihat Bimbingan Dan Rekomendasi Dari Dosen Pembimbing</b>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Pembimbing 1 Dan Pembimbing 2 Berdasarkan Surat Keputusan Tugas Akhir</span>
                </div>
                <div class="widget-content goal">
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span6">
                                @if($pembimbing1 == 'null')
                                --
                                @elseif($pembimbing1->dosen_id == 0)
                                --
                                @else
                                <a href="{{ URL::to_route('dosenpembimbingview', Crypter::encrypt($pembimbing1->dosen->id)) }}" rel="tooltip" title="Lihat Profil" data-placement="left">{{ $pembimbing1->dosen->namadepan }} {{ $pembimbing1->dosen->namabelakang }}</a>
                                @endif
                                <small>Pembimbing 1</small>
                            </div>
                            <div class="info span6">
                                @if($pembimbing2 == 'null')
                                --
                                @elseif($pembimbing2->dosen_id == 0)
                                --
                                @else
                                <a href="{{ URL::to_route('dosenpembimbingview', Crypter::encrypt($pembimbing2->dosen->id)) }}" rel="tooltip" title="Lihat Profil" data-placement="left">{{ $pembimbing2->dosen->namadepan }} {{ $pembimbing2->dosen->namabelakang }}</a>
                                @endif
                                <small>Pembimbing 2</small>
                            </div>
                        </div>
                    </div>
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span4">
                                @if($srtkeputusan == 'null')
                                --
                                @else
                                {{ date('d-m-Y', strtotime($srtkeputusan->awaltanggal)) }}
                                @endif
                                <small>Awal Surat Keputusan TA</small>
                            </div>
                            <div class="info span4">
                                @if($srtkeputusan == 'null')
                                --
                                @else
                                {{ date('d-m-Y', strtotime($srtkeputusan->akhirtanggal)) }}
                                @endif
                                <small>Akhir Surat Keputusan TA</small>
                            </div>
                            <div class="info span4">
                                @if($sisawaktu == 'null')
                                --
                                @else
                                {{ $sisawaktu }} 
                                @endif
                                <small>Batas Surat Keputusan TA</small>
                            </div>
                        </div>
                    </div>
                    <div class="well goal-header">
                        <div class="row-fluid">
                            <div class="info span6">
                                @if($pembimbing1->rekomendasi == 0)
                                --
                                @else
                                Direkomendasikan
                                @endif
                                <small>Rekomendasi Semhas & Ujian Pembimbing 1</small>
                            </div>
                            <div class="info span6">
                                @if($pembimbing2->rekomendasi == 0)
                                --
                                @else
                                Direkomendasikan
                                @endif
                                <small>Rekomendasi Semhas & Ujian Pembimbing 2</small>
                            </div>
                        </div>
                    </div>
                    @if($jmlrekom == 2)
                    <center><a href="{{ URL::to_route('daftarsemhasujian') }}" class="btn btn-danger btn-large">Daftar Semhas & Ujian TA</a></center>
                    @else
                    @endif
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Asistensi Bimbingan TA -- Pembimbing 1</span>
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
                            @if($asspembimbing1 == 'null')
                            <tr>
                                <td>Belum Ada Catatan</td>
                                <td></td>
                            </tr>
                            @else
                            @foreach($asspembimbing1 as $data)
                            <tr>
                                <td><b>{{ date('d-m-Y', strtotime($data->created_at)) }}</b></td>
                                <td><span rel="popover" data-trigger="hover" title="Catatan Bimbingan" data-placement="top" data-content="{{ $data->catatan }}">{{ Str::words($data->catatan, 6) }}</span></td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div> 
            <div class="span6 widget">
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i>Asistensi Bimbingan TA -- Pembimbing 2</span>
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
                            @if($asspembimbing2 == 'null')
                            <tr>
                                <td>Belum Ada Catatan</td>
                                <td></td>
                            </tr>
                            @else
                            @foreach($asspembimbing2 as $data)
                            <tr>
                                <td><b>{{ date('d-m-Y', strtotime($data->created_at)) }}</b></td>
                                <td><span rel="popover" data-trigger="hover" title="Catatan Bimbingan" data-placement="top" data-content="{{ $data->catatan }}">{{ Str::words($data->catatan, 6) }}</span></td>
                            </tr>
                            @endforeach
                            @endif
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
