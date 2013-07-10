@layout('layout.default')

@section('style')
<?= HTML::style('mhsdosen/assets/css/typica-login.css'); ?>
@endsection

@section('javascript')
<?= HTML::script('mhsdosen/bootstrap/js/bootstrap-ajax.js'); ?>
@endsection

@section('content')
<div class="row">
    <div class="span6">
        <div class="register-info-wraper">
            <div id="register-info">
                <h1>Ingin Lulus ? Anda Hanya Perlu 60 Detik Untuk Memulainya !</h1>
                <ul dir="rtl">
                    <li>Registrasi</li>
                    <li>Seminar Proposal</li>
                    <li>Seminar Hasil & Ujian Tugas Akhir</li>
                    <li>!!! LULUS</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="span6">
        <div id="register-wraper">
            <div id="register-form" class="form">
                <legend><span class="blue">REGISTRASI</span></legend>
                <div class="body">
                    @if(Session::has('message'))
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p id="message">{{ Session::get('message') }}</p>
                    </div>
                    @endif
                    @if($errors->has())
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        @foreach($errors->all() as $message)
                        <p id="message">{{ $message }}</p>
                        @endforeach
                    </div>
                    @endif
                    <div id="submit-status">
                        <form id="register-form" class="form ajax" action="ceknim" data-replace="#submit-status" method="post">
                            <label for="nim">Nomor Induk Mahasiswa</label>
                            <input name="nim" class="input-huge" type="text" value="<?= Input::old('nim'); ?>" required>
                            <div class="footer">
                                <button type="submit" class="btn btn-danger">CEK NIM</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><br/>
            <div class="info">Sudah Punya Akun Silahkan<a href="{{ URL::home() }}" class="btn btn-link">LOGIN</a></div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection