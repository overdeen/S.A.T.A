<?php

class User_Controller extends Base_Controller {

    public $title;

    public function __construct() {
        parent::__construct();
    }

    // ----- Fungsi Set Title -----
    public function setTitle($title) {
        $this->title = $title;
    }

    // ----- Fungsi Logout -----
    protected function logoutAll() {
        if (Auth::check()) {
            Auth::logout();
        }
    }

    // ----- Fungsi Menampilkan Semua Informasi -----
    public function allInformasi() {
        $informasi = Informasi::with('admin')->order_by('updated_at', 'desc')->paginate(10);
        return $informasi;
    }

    // ----- Tampilkan Halaman Login -----
    public function get_index() {
        // ----- Jika Guest -----
        if (Auth::guest()) {
            $this->setTitle("Login");
            return View::make('user.login')->with('title', $this->title);
        } else {
            // ----- Check Role -----
            if (Auth::user()->role == 3) {
                return Redirect::to_route('mahasiswa');
            } elseif (Auth::user()->role == 2) {
                return Redirect::to_route('dosen');
            } elseif (Auth::user()->role == 0) {
                return Redirect::to_route('admin');
            }
        }
    }

    // ----- Melakukan Login -----
    public function post_index() {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        // ----- Rules Validasi -----
        $rules = array(
            'username' => 'required',
            'password' => 'required'
        );
        $validation = Validator::make(Input::all(), $rules);
        // ----- Check Validasi -----
        if ($validation->passes()) {
            $user = array(
                'username' => $purifier->purify(Input::get('username')),
                'password' => $purifier->purify(Input::get('password')),
            );
            // ----- Check Role -----
            if (Auth::attempt($user)) {
                if (Auth::user()->role == 3) {
                    return Redirect::to_route('mahasiswa');
                } elseif (Auth::user()->role == 2) {
                    return Redirect::to_route('dosen');
                }
            } else {
                return Redirect::back()->with('message', 'Username atau Password Anda Salah')->with_input();
            }
        } else {
            return Redirect::back()->with_input()->with_errors($validation);
        }
    }

    // ----- Tampilkan Halaman Registrasi ------
    public function get_registrasi() {
        $this->setTitle("Registrasi");
        return View::make('user.registrasi')->with('title', $this->title);
    }

    // ----- Registrasi -----
    public function post_registrasi() {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        // ----- Rules Validasi -----
        $rules = array(
            'password' => 'required|min:5|max:255|confirmed',
            'password_confirmation' => 'required|min:5|max:255',
            'email' => 'required|email|unique:users'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->passes()) {
            // ----- Get Input Data -----
            $nim = $purifier->purify(Input::get('nim'));
            $namadepan = $purifier->purify(Input::get('namadepan'));
            $namabelakang = $purifier->purify(Input::get('namabelakang'));
            $pass = $purifier->purify(Input::get('password'));
            $email = $purifier->purify(Str::lower(Input::get('email')));
            // ----- Password Hashing -----
            $password = trim(Hash::make($pass));
            // ----- Create New User -----
            $user = new User;
            $user->username = $nim;
            $user->password = $password;
            $user->email = $email;
            $user->role = 3;
            $user->save();
            // ----- Get User Data -----
            $finduser = User::where_username($nim)->first();
            // ----- Create Mahasiswa -----
            $mahasiswa = new Mahasiswa;
            $mahasiswa->namadepan = $namadepan;
            $mahasiswa->namabelakang = $namabelakang;
            // ----- Insert New User -> Mahasiswa Table ----- 
            $finduser->mahasiswa()->insert($mahasiswa);
            // ----- Create Profil -----
            $profil = new Profil;
            $profil->alamat = "";
            // ----- Insert New User -> Profil Table -----
            $finduser->profil()->insert($profil);
            return Redirect::to_route('loginuser')->with('title', $this->title)->with('message', 'Anda Telah Berhasil Registrasi, Silahkan Login');
        } else {
            return Redirect::to_route('registrasi')->with_input()->with_errors($validation);
        }
    }

    // ----- Tampilkan Halaman Profil -----
    protected function get_profil() {
        $this->setTitle("Profil");
        if (Auth::user()->role == 3) {
            // ----- Get Mahasiswa Data -----
            $user = User::find(Auth::user()->id)->mahasiswa()->first();
            // ----- Get Profil Data -----
            $profil = User::find(Auth::user()->id)->profil()->first();
            if (empty($profil->angkatan)) {
                // ----- Instance Class Angkatan Dari Folder Libraries & Panggil Method nim() -----
                $angk = new Angkatan();
                $angk->nim(Auth::user()->username, Auth::user()->id);
            }
            $data = array(
                'title' => $this->title,
                'user' => $user,
                'profil' => $profil,
                'menu' => 'Profil',
                'menu2' => 'Manage Profil'
            );
            return View::make('user.profil', $data);
        } elseif (Auth::user()->role == 2) {
            // ----- Get Dosen Data -----
            $user = User::find(Auth::user()->id)->dosen()->first();
            // ----- Get Profil Data -----
            $profil = User::find(Auth::user()->id)->profil()->first();
            $data = array(
                'title' => $this->title,
                'user' => $user,
                'profil' => $profil,
                'menu' => 'Profil',
                'menu2' => 'Manage Profil'
            );
            return View::make('user.profil', $data);
        }
    }

    // ----- Update Profil -----
    protected function put_profil() {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        // Get User ID -----
        $findid = Profil::where_user_id(Auth::user()->id)->first();
        $id = $findid->id;
        // ----- Get Input Data -----
        $pass = $purifier->purify(Input::get('password'));
        $bio = $purifier->purify(Input::get('biografi'));
        $alamat = $purifier->purify(Input::get('alamat'));
        $telp = $purifier->purify(Input::get('notelp'));
        $hape = $purifier->purify(Input::get('nohape'));
        $facebook = $purifier->purify(Input::get('facebook'));
        $twitter = $purifier->purify(Input::get('twitter'));
        // ----- Check Password -----
        if (Hash::check($pass, Auth::user()->password)) {
            // ----- Update Profil Data -----
            Profil::update($id, array(
                'alamat' => $alamat,
                'biografi' => $bio,
                'notelp' => $telp,
                'nohp' => $hape,
                'facebook' => $facebook,
                'twitter' => $twitter
            ));
            return Redirect::back()->with('message', 'Profil Anda Berhasil Diubah');
        } else {
            return Redirect::back()->with('message', 'Maaf Password yang Anda Masukkan Salah');
        }
    }

    // ----- Update Foto Profil -----
    protected function put_foto_profil() {
        require path('app') . 'libraries/simpleimage.php';
        $rules = array(
            'foto' => 'image|mimes:jpg|max:1000'
        );
        $validation = Validator::make(Input::all(), $rules);
        // Checking Validasi
        if ($validation->passes()) {
            // ----- Get Input Data -----
            $foto = $_FILES['foto']['tmp_name'];
            $pass = Input::get('password');
            // ----- Get User ID -----
            $findid = Profil::where_user_id(Auth::user()->id)->first();
            $id = $findid->id;
            $filename = Auth::user()->username;
            $image = Str::random(45) . '.' . File::extension(Input::file('foto.name'));
            // ----- Check Password -----
            if (Hash::check($pass, Auth::user()->password)) {
                // ----- Delete Data Lama -----
                File::delete('public/uploads/' . $filename . '/' . $findid->foto);
                File::delete('public/uploads/thumbnails/' . $findid->foto);
                // ---- Update Profil Data -----
                Profil::update($id, array(
                    'foto' => $image
                ));
                $odest = 'public/uploads/thumbnails/' . $image;
                // ----- Crop Image -----
                $imagecrop = new SimpleImage();
                $imagecrop->load($foto);
                $imagecrop->resize(100, 100);
                $imagecrop->save($odest);
                // ----- Upload Image Ke Folder -----
                Input::upload('foto', 'public/uploads/' . $filename, $image);
                return Redirect::back()->with('message', 'Foto Profil Anda Berhasil Diubah');
            } else {
                return Redirect::back()->with('message', 'Maaf Password yang Anda Masukkan Salah');
            }
        } else {
            return Redirect::back()->with_input()->with_errors($validation);
        }
    }

    // ----- Update Password -----
    protected function put_password_profil() {
        // ----- Get Input Data -----
        $passlama = trim(Input::get('passwordlama'));
        $passbaru = trim(Input::get('passwordbaru'));
        // ----- Check Password -----
        if (Hash::check($passlama, Auth::user()->password)) {
            // ----- Update User Data -----
            User::update(Auth::user()->id, array(
                'password' => Hash::make($passbaru)
            ));
            return Redirect::back()->with('message', 'Password Anda Berhasil Diubah');
        } else {
            return Redirect::back()->with('message', 'Maaf Password yang Anda Masukkan Salah');
        }
    }

    // ----- Update Password -----
    protected function put_jadwal_bimbingan() {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        // ----- Get Input Data -----
        $senin = $purifier->purify(Input::get('senin'));
        $selasa = $purifier->purify(Input::get('selasa'));
        $rabu = $purifier->purify(Input::get('rabu'));
        $kamis = $purifier->purify(Input::get('kamis'));
        $jumat = $purifier->purify(Input::get('jumat'));
        $sabtu = $purifier->purify(Input::get('sabtu'));
        $findid = User::find(Auth::user()->id)->dosen()->first();
        $id = $findid->id;
        // ----- Update Jadwal Bimbingan -----
        try {
            Dosen::update($id, array(
                'senin' => $senin,
                'selasa' => $selasa,
                'rabu' => $rabu,
                'kamis' => $kamis,
                'jumat' => $jumat,
                'sabtu' => $sabtu
            ));
            return Redirect::back()->with('message', 'Jadwal Bimbingan Berhasil Diubah');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function post_lupa_password() {
        $nim = Input::get('nim');
        $email = Input::get('email');
        $cekuser = User::where_username($nim)->first();
        if (!is_null($cekuser)) {
            $getemail = $cekuser->email;
            if ($email == $getemail) {
                $newPassword = Str::random(7);
                $newPasswordHash = Hash::make($newPassword);
                User::update($cekuser->id, array(
                    'password' => $newPasswordHash
                ));
                require path('app') . 'libraries/PHPMailer/class.phpmailer.php';
                $mail = new PHPMailer();
//$mail->IsSMTP(); // telling the class to use SMTP
//$mail->Host = "localhost"; // SMTP server
//IsSMTP(); // send via SMTP
                $mail->Host = "ssl://smtp.gmail.com"; // SMTP server Gmail
                $mail->Mailer = "smtp";
                $mail->SMTPAuth = true; // turn on SMTP authentication
                $mail->Username = "dannu.febri.dienda@gmail.com"; // 
                $mail->Password = "dannufebr1d1enda"; // SMTP password
                $webmaster_email = "dannu.febri.dienda@gmail.com"; //Reply to this email ID
                $email = $getemail; // Recipients email ID
                $name = "namapenerima"; // Recipient's name
                $mail->From = $webmaster_email;
                $mail->FromName = "UMM Admin";
                $mail->AddAddress($email, $name);
                $mail->AddReplyTo($webmaster_email, "namawebmaster");
                $mail->WordWrap = 50; // set word wrap
                $mail->IsHTML(true); // send as HTML
                $mail->Subject = "Password Baru | Teknik Informatika | UMM";
                $mail->Body = '<div style="font-size: 24px;"><i>'.$newPassword.'<i></div>'; //HTML Body
                $mail->AltBody = "This is the body when user views in plain text format"; //Text Body 
                if (!$mail->Send()) {
                    return Redirect::back()->with('message', 'Pengiriman Password Gagal : ' . $mail->ErrorInfo);
                } else {
                    return Redirect::back()->with('message', 'Password Baru Telah Dikirim, Silahkan Cek Email Anda');
                }
            } else {
                return Redirect::back()->with('message', 'Maaf Email Yang Anda Masukkan Tidak Sesuai');
            }
        } else {
            return Redirect::back()->with('message', 'Maaf Nomor Induk Mahasiswa Anda Tidak Terdaftar');
        }
    }

}