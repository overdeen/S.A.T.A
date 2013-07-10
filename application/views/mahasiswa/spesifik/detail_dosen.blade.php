@layout('layout.dashboard')

@section('style')

@endsection

@section('javascript')
<?= HTML::script('mhsdosen/plugins/validate/jquery.validate.min.js'); ?>
<?= HTML::script('mhsdosen/custom-plugins/bootstrap-inputmask.min.js'); ?>
<?= HTML::script('mhsdosen/custom-plugins/bootstrap-fileinput.min.js'); ?>
<?= HTML::script('mhsdosen/assets/js/demo/form_validation.js'); ?>
@endsection

@section('content')
<section id="main" class="clearfix">
    <div id="main-header" class="page-header">
        @include('layout.breadcrumb')
        <h1 id="main-heading">
            Halaman Detail Dosen Pembimbing <span>Halaman Untuk Melihat Detail Profil Dosen Pembimbing Dan Untuk Menambahkan Sebagai Dosen Pembimbing</span>
        </h1>
    </div>
    <div id="main-content">
        @if(Session::has('message'))
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <p id="message">{{ Session::get('message') }}</p>
        </div>
        @endif
        <div class="profile">
            <div class="clearfix">
                <div class="profile-head clearfix">
                    <div class="profile-info pull-left">
                        <h1 class="profile-username">{{ $dosens->namadepan }} {{ $dosens->namabelakang }} <a href="https://facebook.com/{{ $dosenprofils->facebook }}" target="_blank" rel="tooltip" title="{{ $dosens->namadepan }} Facebook" data-placement="top"><i class="icon-facebook"></i></a> <a href="http://twitter.com/{{ $dosenprofils->twitter }}" target="_blank" rel="tooltip" title="{{ $dosens->namadepan }} Twitter" data-placement="top"><i class="icon-twitter"></i></a></h1>
                        <ul class="profile-attributes">
                            <li><i class="icos-male-contour"></i> <b>Dosen Teknik Informatika</b> --- NIP / NIDN : <b style="font-size: 14px;">{{ $dosens->user->username }}</b></li>
                        </ul>
                    </div>
                    <div class="btn-toolbar pull-right">
                        @if(!empty($proposal))
                        @if($pembimbingterpilih == 1)
                        <button class="btn btn-small btn-primary" disabled>Dosen Telah Dipilih Menjadi Dosen Pembimbing</button>
                        @elseif($pembimbingcount == 2)
                        <button class="btn btn-small btn-primary" disabled>Anda Sudah Memilih 2 Orang Dosen</button>
                        @else
                        {{ Form::open('pembimbing/add', 'POST') }}
                        {{ Form::token() }}
                        <input name="idproposal" type="hidden" value="{{ $proposal->id }}">
                        <input name="iddosen" type="hidden" value="{{ $dosens->id }}">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda Yakin Akan Menjadikan Sebagai Dosen Pembimbing ? Sekali Pilih Tidak Akan Bisa Dihapus Kembali');"><i class="icos-admin-user-2 icos-white"></i> Jadikan Dosen Pembimbing</button>
                        {{ Form::close() }}
                        @endif
                        @endif
                    </div>
                </div>
                <div class="profile-sidebar">
                    <div class="thumbnail">
                        @if(empty($dosenprofils->foto))
                        {{ HTML::image(URL::base().'/sample/default.jpeg', 'Default Dosen Image'); }}
                        @else
                        {{ HTML::image(URL::base().'/uploads/'.$dosens->user->username.'/'.$dosenprofils->foto, 'Dosen Image'); }}
                        @endif
                    </div>
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="active"><a href="#"><i class="icos-user"></i> {{ $dosens->namadepan }} {{ $dosens->namabelakang }}  Profil</a></li>
                    </ul>
                </div>
                <div class="profile-content">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <h4 class="sub"><span>BIOGRAFI</span></h4>
                            {{ $dosenprofils->biografi }}
                            <h4 class="sub"><span>KONTAK</span></h4>
                            <address>
                                <abbr title="Alamat">ALAMAT :</abbr> <b>{{ $dosenprofils->alamat }}</b><br><br/>
                                <abbr title="Nomor Telepon">NO. TELEPHONE :</abbr> <b>{{ $dosenprofils->notelp }}</b><br>
                                <abbr title="Nomor Handphone">NO. HANDPHONE :</abbr> <b>{{ $dosenprofils->nohp }}</b>
                            </address>
                            <h4 class="sub"><span>JADWAL BIMBINGAN</span></h4>
                            <div>
                                <ul>
                                    <li><b>SENIN :</b> {{ $dosens->senin }}</li>
                                    <li><b>SELASA :</b> {{ $dosens->selasa }}</li>
                                    <li><b>RABU :</b> {{ $dosens->rabu }}</li>
                                    <li><b>KAMIS :</b> {{ $dosens->kamis }}</li>
                                    <li><b>JUMAT :</b> {{ $dosens->jumat }}</li>
                                    <li><b>SABTU :</b> {{ $dosens->sabtu }}</li>
                                </ul>
                            </div>
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
