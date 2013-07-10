@layout('layout.dashboard')

@section('style')
<?= HTML::style('mhsdosen/custom-plugins/contactlist/contactlist.css'); ?>
@endsection

@section('javascript')
<?= HTML::script('mhsdosen/custom-plugins/contactlist/contactlist.min.js'); ?>
<?= HTML::script('mhsdosen/assets/js/demo/contact.js'); ?>
@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">
            Halaman Dosen Pembimbing <span>Halaman Untuk Melihat Daftar Dari Dosen Pembimbing</span>
        </h1>
    </div>

    <div id="main-content">
        <div class="row-fluid">
            <div class="span12 widget">
                <div class="widget">
                    <div class="widget-content form-container">
                        <form class="form-horizontal">
                            <div class="control-group">
                                <ul>
                                    <li>Cari Dosen yang Ingin Ditambahkan Menjadi Dosen Pembimbing.</li>
                                    <li>Pilih Dosen Lalu Tambahkan Menjadi Dosen Pembimbing Proposal Anda. Anda Diwajibkan Memilih 2 Orang Dosen Pembimbing.</li>
                                    <li>Dosen Dapat Melakukan <b><i>Approval</i> / Tanda Persetujuan</b> Terhadap Proposal Anda.</li>
                                    <li>Setelah Mendapatkan 2 Buah <b>Tanda Persetujuan</b>, Anda Dapat Segera Mendaftar Seminar Proposal.</li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="widget-header">
                    <span class="title"><i class="icol-arrow-right"></i> Daftar Dosen Pembimbing</span>
                </div>
                <div class="widget-content no-padding">
                    <ul id="contacts">
                        @foreach ($dosens as $dosen)
                        <li>
                            <ul>
                                <li>    
                                    <a href="{{ URL::to_route('dosenpembimbingview', Crypter::encrypt($dosen->id)) }}">
                                        <span class="thumbnail">
                                            @if(empty($dosen->user->profil->foto))
                                            {{ HTML::image(URL::base().'/sample/default.jpeg', 'Default Pembimbing Image'); }}
                                            @else
                                            {{ HTML::image(URL::base().'/uploads/thumbnails/'.$dosen->user->profil->foto) }}
                                            @endif
                                        </span><span rel="tooltip" title="Lihat Profil Dosen" data-placement="right">{{ $dosen->namadepan }} {{ $dosen->namabelakang }}</span>
                                        <span style="font-size: 11px; display: block;" class="muted">Dosen Teknik Informatika</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
