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
            Halaman Detail Mahasiswa <span>Halaman Untuk Melihat Detail Profil Mahasiswa</span>
        </h1>
    </div>
    <div id="main-content">
        <div class="profile">
            <div class="clearfix">
                <div class="profile-head clearfix">
                    <div class="profile-info pull-left">
                        <h1 class="profile-username">{{ $mahasiswa->namadepan }} {{ $mahasiswa->namabelakang }} <a href="https://facebook.com/{{ $mahasiswaprofil->facebook }}" target="_blank"><i class="icon-facebook"></i></a> <a href="http://twitter.com/{{ $mahasiswaprofil->twitter }}" target="_blank"><i class="icon-twitter"></i></a></h1>
                    </div>
                </div>
                <div class="profile-sidebar">
                    <div class="thumbnail">
                        @if(empty($mahasiswaprofil->foto))
                        {{ HTML::image('sample/default.jpeg', 'Coba'); }}
                        @else
                        {{ HTML::image('uploads/'.$mahasiswa->user->username.'/'.$mahasiswaprofil->foto, 'Coba'); }}
                        @endif
                    </div>
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="active"><a href="#"><i class="icos-user"></i> {{ $mahasiswa->namadepan }} {{ $mahasiswa->namabelakang }}  Profil</a></li>
                    </ul>
                </div>
                <div class="profile-content">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <h4 class="sub"><span>BIOGRAFI</span></h4>
                            {{ $mahasiswaprofil->biografi }}
                            <h4 class="sub"><span>KONTAK</span></h4>
                            <address>
                                <abbr title="Alamat">ALAMAT :</abbr> <b>{{ $mahasiswaprofil->alamat }}</b><br><br/>
                                <abbr title="Nomor Telepon">NOMOR TELEPHONE :</abbr> <b>{{ $mahasiswaprofil->notelp }}</b><br>
                                <abbr title="Nomor Handphone">NOMOR HANDPHONE :</abbr> <b>{{ $mahasiswaprofil->nohp }}</b>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

@endsection
