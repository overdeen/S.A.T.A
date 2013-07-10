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
            @if($menu2 == 'Hasil Seminar Proposal')
            Halaman Hasil Seminar Proposal <span>Halaman Untuk Melihat Hasil Seminar Proposal</span>
            @elseif($menu2 == 'Hasil Ujian TA')
            Halaman Hasil Seminar Ujian TA <span>Halaman Untuk Melihat Hasil Ujian TA</span>
            @endif
        </h1>
    </div>

    <div id="main-content">
        <div class="row-fluid">
            @if(empty($proposal))
            <div class="widget">
                <div class="widget-content form-container">
                    <div class="control-group">
                        <span class="badge badge-warning">Peringatan !!</span>&nbsp;&nbsp; <b>Anda Diharuskan Menambahkan Proposal Judul Tugas Akhir Terlebih Dahulu. Silahkan Menambahkan Proposal Melalui Menu <a href="">Tambah Proposal</a></b>
                    </div>
                </div>
            </div>
            @elseif($daftar_count != 1)
            @if($menu2 == 'Hasil Seminar Proposal')
            <div class="widget">
                <div class="widget-content form-container">
                    <div class="control-group">
                        <span class="badge badge-warning">Peringatan !!</span>&nbsp;&nbsp; <b>Anda Diharuskan Mendaftar Seminar Proposal Terlebih Dahulu. Silahkan Mendaftar Seminar Proposal Melalui Menu <a href="">Daftar Seminar Proposal</a></b>
                    </div>
                </div>
            </div>
            @elseif($menu2 == 'Hasil Ujian TA')
            <div class="widget">
                <div class="widget-content form-container">
                    <div class="control-group">
                        <span class="badge badge-warning">Peringatan !!</span>&nbsp;&nbsp; <b>Anda Diharuskan Mendaftar Seminar Hasil & Ujian TA Terlebih Dahulu. Silahkan Mendaftar Ujian TA Melalui Menu <a href="">Daftar Semhas & Ujian TA</a></b>
                    </div>
                </div>
            </div>
            @endif
            @else
            <div class="span12 widget">
                @if(Session::has('message'))
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p id="message">{{ Session::get('message') }}</p>
                </div>
                @endif
                <div class="widget-header">
                    @if($menu2 == 'Hasil Seminar Proposal')
                    <span class="title"><i class="icol-arrow-right"></i>Hasil Seminar Proposal Judul Tugas Akhir</span>
                    @elseif($menu2 == 'Hasil Ujian TA')
                    <span class="title"><i class="icol-arrow-right"></i>Hasil Ujian Tugas Akhir</span>
                    @endif
                </div>
                <div class="widget-content table-container">
                    <table class="table table-striped table-detail-view">
                        <thead>
                            <tr><th colspan="2"><i class="icol-doc-text-image"></i> Detail Informasi Judul Tugas Akhir</th></tr>
                        </thead>
                        <tbody>
                            <tr><th>Judul Tugas Akhir</th><td>{{ $proposal->judul }}</td></tr>
                            <tr><th>Deskripsi</th><td>{{ $proposal->deskripsi }}</td></tr>
                            <tr><th>Tahun</th><td>{{ $proposal->tahun }}</td></tr>
                        </tbody>
                        <thead>
                            <tr>
                                <th colspan="2"><i class="icol-doc-text-image"></i> Detail Informasi Hasil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($menu2 == 'Hasil Seminar Proposal')
                            <tr><th>Hasil Seminar Proposal</th>
                                <td>
                                    @if(empty($datahasil->hasil_sempro) || $datahasil->hasil_sempro == 0)
                                    <i>--- Belum Ada Hasil ---</i>
                                    @elseif($datahasil->hasil_sempro == 1)
                                    <span class="badge badge-info" style="font-size: 15px; padding: 3px 4px 3px 4px;">DITERIMA</span>
                                    @elseif($datahasil->hasil_sempro == 2)
                                    <span class="badge badge-warning" style="font-size: 16px; padding: 5px 5px 5px 5px;">DIREVISI</span>
                                    @else
                                    <span class="badge badge-important" style="font-size: 16px; padding: 5px 5px 5px 5px;">DITOLAK</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><th>Catatan</th>
                                <td>
                                    @if(empty($datahasil->ket_sempro))
                                    <i>--- Tidak Ada Catatan ---</i>
                                    @else
                                    {{ $datahasil->ket_sempro }}
                                    @endif
                                </td>
                            </tr>
                            <tr><th>Langkah Selanjutnya</th>
                                <td>
                                    @if(empty($datahasil->hasil_sempro))
                                    <i>--- Belum Ada Langkah Selanjutnya ---</i>
                                    @elseif($datahasil->hasil_sempro == 1)
                                    <b>Silahkan Menunggu Surat Keputusan Tugas Akhir Keluar Dan Anda Dapat Segera Melakukan Bimbingan Tugas Akhir, Terima Kasih.</b>
                                    @elseif($datahasil->hasil_sempro == 2)
                                    <b>Silahkan Anda Melakukan Apa Yang Diperintahkan Catatan, Setelah Revisi Selesai Anda Dapat Berbicara Kepada Petugas Pengurus Seminar Proposal, Terima Kasih.</b>
                                    @else
                                    <b>Mohon Maaf, Proposal Anda Ditolak Dan Anda Harus Membuat Proposal Judul Baru Untuk Diajukan Kembali &nbsp&nbsp&nbsp<a href="{{ URL::to_route('kembalikeawal', $datahasil->daftar_id) }}" class="btn btn-danger" onclick="return confirm('Maaf Anda Harus Mengajukan Proposal Judul Lagi, Tetap Semangat !!');">Hapus Proposal</a></b>
                                    @endif        
                                </td>
                            </tr>
                            @elseif($menu2 == 'Hasil Ujian TA')
                            <tr><th>Hasil Ujian Tugas Akhir</th>
                                <td>
                                    <i>--- Hasil Ujian Tugas Akhir Akan Berupa Nilai ---</i>
                                </td>
                            </tr>
                            <tr><th>Nilai Ujian Tugas Akhir</th>
                                <td>
                                    @if(empty($datahasil->nilai_ujian))
                                    <i>--- Nilai Belum Keluar ---</i>
                                    @else
                                    <span class="badge badge-info" style="font-size: 18px; padding: 3px 4px 3px 4px;">{{ $datahasil->nilai_ujian }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><th>Catatan</th>
                                <td>
                                    @if(empty($datahasil->ket_ujian))
                                    <i>--- Tidak Ada Catatan ---</i>
                                    @else
                                    {{ $datahasil->ket_ujian }}
                                    @endif
                                </td>
                            </tr>
                            <tr><th>Langkah Selanjutnya</th>
                                <td>
                                    @if(empty($datahasil->nilai_ujian))
                                    <i>--- Nilai Belum Keluar ---</i>
                                    @else
                                    @if($datahasil->nilai_ujian == 'C' || $datahasil->nilai_ujian == 'D' || $datahasil->nilai_ujian == 'E')
                                    <b>Mohon Maaf, Anda Belum Memenuhi Nilai Persyaratan Untuk Dinyatakan Lulus Sehingga Anda Diharuskan Ujian TA Ulang. Silahkan Menunggu Jadwal Ujian TA Ulang. Terima Kasih. Silahkan Anda Melihat Jadwal Ujian TA Pada Menu <a href="{{ URL::to_route('jadwalujian') }}">Jadwal Ujian TA</a></b> 
                                    @else
                                    <b>Selamat, Anda Telah Dinyatakan Lulus Dalam Ujian Tugas Akhir, Silahkan Menghubungi Pihak Jurusan Untuk Mendapatkan Informasi Selanjutnya. Terima Kasih. </b>
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
