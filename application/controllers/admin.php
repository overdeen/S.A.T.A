<?php

class Admin_Controller extends User_Controller {

    private $id;

    public function __construct() {
        parent::__construct();
    }

    // ----- Tampilkan Halaman Login Admin -----
    protected function get_loginadmin() {
        // ----- Jika Guest -----
        if (Auth::guest()) {
            $this->setTitle("Login Admin");
            return View::make('admin.login2')->with('title', $this->title);
        } else {
            // ----- Melakukan Check Role User -----
            if (Auth::user()->role == 0 && Auth::user()->adm == 1) {
                return Redirect::to_route('admin');
            } else {
                return Redirect::to_route('loginuser');
            }
        }
    }

    // ----- Melakukan Login -----
    protected function post_loginadmin() {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        // ----- Aturan Validasi -----
        $rules = array(
            'username' => 'required',
            'password' => 'required'
        );
        $validation = Validator::make(Input::all(), $rules);
        // ----- Melakukan Check Validasi -----
        if ($validation->passes()) {
            $user = array(
                'username' => $purifier->purify(Input::get('username')),
                'password' => $purifier->purify(Input::get('password')),
            );
            // ----- Melakukan Check Username, Password, dan Role -----
            try {
                if (Auth::attempt($user)) {
                    if (Auth::user()->role == 0 && Auth::user()->adm == 1) {
                        return Redirect::to_route('admin');
                    } elseif (Auth::user()->role == 2 && Auth::user()->adm == 0) {
                        Auth::logout();
                        return Redirect::to_route('loginuser')->with('message', 'Anda Bukan Seorang Admin. Loginlah Pada Form Ini');
                    } elseif (Auth::user()->role == 3) {
                        Auth::logout();
                        return Redirect::to_route('loginuser')->with('message', 'Anda Bukan Seorang Admin. Loginlah Pada Form Ini');
                    }
                } else {
                    return Redirect::back()->with('message', 'Username atau Password Anda Salah')->with_input();
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            return Redirect::back()->with_input()->with_errors($validation);
        }
    }

    // ----- Melakukan Logout -----
    protected function get_logoutadmin() {
        $this->setTitle("Login");
        parent::logoutAll();
        return Redirect::to_route('loginadmin')->with('title', $this->title)->with('message', 'Anda Telah Berhasil Logout');
    }

    // ----- Tampilkan Halaman Dashboard Admin -----
    protected function get_dashboardadmin() {
        if (Auth::guest() || Auth::user()->adm != 1) {
            return Redirect::to_route('loginadmin')->with('message', 'Anda Harus Login Terlebih Dahulu');
        } else {
            $this->setTitle("Admin Dashboard");
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $jml_mhs = User::where_role(3)->count();
            $jml_dsn = User::where_role(2)->count();
            $jml_hasil_sempro = Hasil::where_hasil_sempro(0)->count();
            $jml_hasil_ujian = Hasil::where_hasil_ujian(1)->count();
            $jml_jdw_sempro = Daftar::where_kategori_sempro_and_terjadwal_sempro(1, 0)->count();
            $jml_jdw_semhas = Daftar::where_kategori_semhas_and_terjadwal_semhas(1, 0)->count();
            $jml_jdw_ujian = Daftar::where_kategori_ujian_and_terjadwal_ujian(1, 0)->count();
            $datas = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'jml_mhs' => $jml_mhs,
                'jml_dsn' => $jml_dsn,
                'jml_hsl_sempro' => $jml_hasil_sempro,
                'jml_hsl_ujian' => $jml_hasil_ujian,
                'jml_jdw_sempro' => $jml_jdw_sempro,
                'jml_jdw_semhas' => $jml_jdw_semhas,
                'jml_jdw_ujian' => $jml_jdw_ujian,
                'menu' => 'Dashboard',
                'menu2' => 'Home Dashboard'
            );
            return View::make('admin.home', $datas);
        }
    }

    // ----- Tampilkan Halaman Manage User -----
    protected function get_viewuser() {
        $this->setTitle("Manage User");
        $finduser = User::find(Auth::user()->id)->admin()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        $get_users_all = User::with('mahasiswa', 'dosen', 'profil')->order_by('username', 'asc')->paginate(20);
        $datas = array(
            'title' => $this->title,
            'user' => $finduser,
            'profil' => $profil,
            'usersall' => $get_users_all,
            'menu' => 'User',
            'menu2' => 'Manage User'
        );
        return View::make('admin.user', $datas);
    }

    // ----- Menambahkan User Baru -----
    protected function post_adduser() {
        // ----- Dapatkan Inputan Data -----
        $username = Input::get('username');
        $pass = Input::get('password');
        $email = Str::lower(Input::get('email'));
        $role = Input::get('role');
        $cek_data_mahasiswa = Checkmhs::where_nim($username)->first();
        $cek_data_user = User::where_username($username)->first();
        // ----- Password Hashing -----
        $password = trim(Hash::make($pass));
        if ($role == 3) {
            if (empty($cek_data_mahasiswa)) {
                return Redirect::back()->with('message', 'Maaf Username / NIM Belum Terdaftar Pada Data Mahasiswa IT');
            } else {
                if (empty($cek_data_user)) {
                    // ----- Tambahkan User Baru -----
                    $user = new User;
                    $user->username = $username;
                    $user->password = $password;
                    $user->email = $email;
                    $user->role = $role;
                    $user->save();
                    // ----- Ambil Data User -----
                    $finduser = User::where_username($username)->first();
                    $mahasiswa = new Mahasiswa;
                    $mahasiswa->namadepan = $cek_data_mahasiswa->nmdepan;
                    $mahasiswa->namabelakang = $cek_data_mahasiswa->nmbelakang;
                    // ----- Masukkan Data User -> Mahasiswa ----- 
                    $finduser->mahasiswa()->insert($mahasiswa);
                    $profil = new Profil;
                    $profil->alamat = "";
                    // ----- Masukkan Data User -> Profil -----
                    $finduser->profil()->insert($profil);
                    return Redirect::back()->with('message', 'User Telah Berhasil Ditambahkan');
                } else {
                    return Redirect::back()->with('message', 'Maaf Username / NIM Telah Terdaftar');
                }
            }
        } elseif ($role == 2) {
            $namadepan = Input::get('namadepan');
            $namabelakang = Input::get('namabelakang');
            if (empty($cek_data_user)) {
                // ----
                $user = new User;
                $user->username = $username;
                $user->password = $password;
                $user->email = $email;
                $user->role = $role;
                $user->save();
                // -----
                $finduser = User::where_username($username)->first();
                // -----
                $dosen = new Dosen;
                $dosen->namadepan = $namadepan;
                $dosen->namabelakang = $namabelakang;
                // -----
                $finduser->dosen()->insert($dosen);
                // -----
                $profil = new Profil;
                $profil->alamat = "";
                // -----
                $finduser->profil()->insert($profil);
                return Redirect::back()->with('message', 'User Telah Berhasil Ditambahkan');
            } else {
                return Redirect::back()->with('message', 'Maaf Username Telah Terdaftar');
            }
        }
    }

    // ----- Hapus User -----
    protected function get_deleteuser($id_user) {
        // ----- Decrypt -----
        $this->id = Crypter::decrypt($id_user);
        // ----- Get Data User -----
        $finduser = User::find($this->id)->first();
        if ($finduser->role == 3) {
            User::find($this->id)->delete();
            Profil::where_user_id($this->id)->delete();
            Mahasiswa::where_user_id($this->id)->delete();
        } elseif ($finduser->role == 2) {
            User::find($this->id)->delete();
            Profil::where_user_id($this->id)->delete();
            Dosen::where_user_id($this->id)->delete();
        }
        return Redirect::back()->with('message', 'User Berhasil Dihapus');
    }

    // ----- Tampilkan Halaman Data Mahasiswa IT ----- 
    protected function get_viewdatamahasiswa() {
        $this->setTitle("Data Mahasiswa IT");
        $finduser = User::find(Auth::user()->id)->admin()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        $get_data_mahasiswa_it = Checkmhs::order_by('nim', 'asc')->paginate(15);
        $get_dosen_condition = User::where_role(3)->lists('username');
        $datas = array(
            'title' => $this->title,
            'user' => $finduser,
            'profil' => $profil,
            'usersall' => $get_data_mahasiswa_it,
            'menu' => 'User',
            'menu2' => 'Data Mahasiswa IT'
        );
        return View::make('admin.datamahasiswa', $datas);
    }

    // ----- Menambahkan Data Mahasiswa IT Baru -----
    protected function post_adddatamahasiswa() {
        // ----- Dapatkan Inputan Data -----
        $nim = Input::get('nim');
        $nmdepan = Input::get('namadepan');
        $nmbelakang = Input::get('namabelakang');
        $cek_data_mahasiswa = Checkmhs::where_nim($nim)->first();
        if (!empty($cek_data_mahasiswa)) {
            return Redirect::back()->with('message', 'Maaf NIM Mahasiswa Telah Terdaftar');
        } else {
            // ----- Tambahkan Mahasiswa IT Baru -----
            $checkmhs = new Checkmhs;
            $checkmhs->nim = $nim;
            $checkmhs->nmdepan = $nmdepan;
            $checkmhs->nmbelakang = $nmbelakang;
            $checkmhs->save();
            return Redirect::back()->with('message', 'Mahasiswa IT Telah Berhasil Ditambahkan');
        }
    }

    // ----- Mengimport Data Mahasiswa IT Dari File Excel -----
    protected function post_exportdatamahasiswa() {
        require path('app') . 'libraries/PHPExcel.php';
        require_once path('app') . 'libraries/PHPExcel/IOFactory.php';

        $name = Input::file('filedatamahasiswa.name');
        Input::upload('filedatamahasiswa', 'public/uploads/', $name);

        $path = 'public/uploads/' . $name;

        $objPHPExcel = PHPExcel_IOFactory::load($path);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // cth 10
        $highestColumn = $objWorksheet->getHighestColumn(); // cth 'F'

        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        try {
            for ($row = 2; $row <= $highestRow; ++$row) {
                $val = array();
                for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                    $val[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
                $checkmhs = new Checkmhs;
                $checkmhs->nim = $val[0];
                $checkmhs->nmdepan = $val[1];
                $checkmhs->nmbelakang = $val[2];
                $checkmhs->save();
            }
            File::delete('public/uploads/' . $name);
            return Redirect::back()->with('message', 'Data Mahasiswa IT Berhasil Di Import');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    // ----- Hapus Data Mahasiswa IT -----
    protected function get_deletedatamahasiswa($id_user) {
        // ----- Decrypt -----
        $this->id = Crypter::decrypt($id_user);
        Checkmhs::find($this->id)->delete();
        return Redirect::back()->with('message', 'Mahasiswa IT Berhasil Dihapus');
    }

    // ----- Tampilkan Halaman Update Hasil Sempro ----- 
    protected function get_update_hasilsempro($idhasil = NULL) {
        $this->setTitle("Update Hasil Seminar Proposal");
        if ($idhasil == NULL) {
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $get_daftar_sempro = Hasil::with('daftar', 'daftar.jadwalsempro', 'daftar.proposal')->where_hasil_sempro_or_hasil_sempro(0, 2)->order_by('ts_sempro', 'asc')->paginate(20);
            $data_mahasiswa = 'null';
        } else {
            $this->id = Crypter::decrypt($idhasil);
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $get_daftar_sempro = Hasil::with('daftar', 'daftar.jadwalsempro', 'daftar.proposal')->where_hasil_sempro_or_hasil_sempro(0, 2)->order_by('ts_sempro', 'asc')->paginate(20);
            $data_mahasiswa = Hasil::with('daftar', 'daftar.jadwalsempro', 'daftar.proposal')->where_id($this->id)->first();
        }
        $datas = array(
            'title' => $this->title,
            'user' => $finduser,
            'profil' => $profil,
            'daftarall' => $get_daftar_sempro,
            'datamahasiswa' => $data_mahasiswa,
            'menu' => 'Hasil',
            'menu2' => 'Update Hasil Seminar Proposal'
        );
        return View::make('admin.update_hasil', $datas);
    }

    // ----- Update Hasil Sempro ----- 
    protected function put_update_hasilsempro() {
        $admin_id = User::find(Auth::user()->id)->admin()->first();
        $this->id = Input::get('id');
        $hasil = Input::get('hasil');
        $ket_sempro = Input::get('catatan');
        Hasil::update($this->id, array(
            'admin_id' => $admin_id->id,
            'hasil_sempro' => $hasil,
            'ket_sempro' => $ket_sempro
        ));
        return Redirect::back()->with('message', 'Hasil Berhasil Diupdate');
    }

    // ----- Tampilkan Halaman Update Hasil Ujian ----- 
    protected function get_update_hasilujian($idhasil = NULL) {
        $this->setTitle("Update Hasil Ujian TA");
        if ($idhasil == NULL) {
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $get_daftar_ujian = Hasil::with('daftar', 'daftar.jadwalujian', 'daftar.proposal')->where_hasil_ujian_or_hasil_ujian(1, 2)->order_by('ts_ujian', 'asc')->paginate(20);
            $data_mahasiswa = 'null';
        } else {
            $this->id = Crypter::decrypt($idhasil);
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $get_daftar_ujian = Hasil::with('daftar', 'daftar.jadwalujian', 'daftar.proposal')->where_hasil_ujian_or_hasil_ujian(1, 2)->order_by('ts_ujian', 'asc')->paginate(20);
            $data_mahasiswa = Hasil::with('daftar', 'daftar.jadwalujian', 'daftar.proposal')->where_id($this->id)->first();
        }
        $datas = array(
            'title' => $this->title,
            'user' => $finduser,
            'profil' => $profil,
            'daftarall' => $get_daftar_ujian,
            'datamahasiswa' => $data_mahasiswa,
            'menu' => 'Hasil',
            'menu2' => 'Update Hasil Ujian TA'
        );
        return View::make('admin.update_hasil', $datas);
    }

    // ----- Update Hasil Ujian ----- 
    protected function put_update_hasilujian() {
        $admin_id = User::find(Auth::user()->id)->admin()->first();
        $this->id = Input::get('id');
        $daftar_id = Input::get('iddaftar');
        $nilai = Input::get('nilai');
        $ket = Input::get('catatan');
        if ($nilai == 'C' || $nilai == 'D' || $nilai == 'E') {
            try {
                Daftar::update($daftar_id, array('terjadwal_ujian' => 0));
                Jadwalujian::where_daftar_id($daftar_id)->delete();
                Hasil::update($this->id, array(
                    'admin_id' => $admin_id->id,
                    'ket_ujian' => $ket,
                    'hasil_ujian' => 2,
                    'nilai_ujian' => $nilai
                ));
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            try {
                Hasil::update($this->id, array(
                    'admin_id' => $admin_id->id,
                    'ket_ujian' => $ket,
                    'hasil_ujian' => 3,
                    'nilai_ujian' => $nilai
                ));
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
        return Redirect::back()->with('message', 'Hasil Berhasil Diupdate');
    }

    // ----- Tampilkan Halaman Jadwal Sempro -----
    protected function get_jadwal_sempro($tanggal = NULL, $jam = NULL, $ruang = NULL) {
        if ($tanggal == NULL && $jam == NULL && $ruang == NULL) {
            $this->setTitle("Penjadwalan Sempro");
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $get_terdaftar_sempro = Daftar::with('proposal')->where_kategori_sempro_and_terjadwal_sempro(1, 0)->order_by('created_at', 'asc')->get();
            $jadwalsempro_daftar = Jadwalsempro::with('daftar', 'daftar.proposal', 'daftar.hasil')->order_by('tanggal', 'desc')->order_by('ruang', 'asc')->get();
            $datas = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'terdaftarsempro' => $get_terdaftar_sempro,
                'datajadwalsempro' => $jadwalsempro_daftar,
                'menu' => 'Penjadwalan',
                'menu2' => 'Seminar Proposal'
            );
            return View::make('admin.jadwal', $datas);
        } else {
            $tanggal = $tanggal;
            $jam = $jam;
            $ruang = strtoupper($ruang);
            $unslug = ucwords(str_replace('-', ' ', $ruang));
            $strupper = strtoupper($unslug);
            $jadwalcond = Jadwalsempro::where_tanggal_and_jam_and_ruang($tanggal, $jam, $strupper)->get();
            foreach ($jadwalcond as $jadwal) {
                $this->id = $jadwal->daftar_id;
                Daftar::update($this->id, array(
                    'terjadwal_sempro' => 0
                ));
                Daftar::find($this->id)->hasil()->delete();
                Jadwalsempro::where_daftar_id($this->id)->delete();
            }
            return Redirect::to_route('penjadwalansempro')->with('message', 'Jadwal Dan Seluruh Mahasiswa Terkait Berhasil Dihapus');
        }
    }

    // ----- Tambah Jadwal Sempro -----
    protected function post_jadwal_sempro() {
        $tanggal = Input::get('tanggal');
        $jam = Input::get('jam');
        $ruang = Input::get('ruang');
        $iddaftar = Input::get('iddaftar');
        // Looping Tambah Data
        if (empty($iddaftar)) {
            return Redirect::back()->with('message', 'Proses Penjadwalan Gagal, Harus Ada Mahasiswa Yang Dijadwalkan');
        } else {
            for ($i = 0; $i < sizeof($iddaftar); $i++) {
                $id = $iddaftar[$i];
                $jadwalsempro = new Jadwalsempro;
                $jadwalsempro->tanggal = date("Y-m-d", strtotime($tanggal));
                $jadwalsempro->jam = $jam . ":00";
                $jadwalsempro->ruang = strtoupper($ruang);
                $jadwalsempro->waktu = date("Y-m-d", strtotime($tanggal)) . " " . $jam . ":00";
                $jadwalsempro->nourut = $i + 1;
                $daftar = Daftar::find($id);
                $daftar->jadwalsempro()->insert($jadwalsempro);
                $hasil = new Hasil;
                $hasil->ts_sempro = date("Y-m-d H:i:s");
                $daftar->hasil()->insert($hasil);
                Daftar::update($id, array(
                    'terjadwal_sempro' => 1
                ));
            }
            return Redirect::back()->with('message', 'Mahasiswa Berhasil Dijadwalkan');
        }
    }

    // ----- Tampilkan Halaman Manage Berkas -----
    protected function get_jadwal_semhas($tanggal = NULL, $jam = NULL, $ruang = NULL) {
        if ($tanggal == NULL && $jam == NULL && $ruang == NULL) {
            $this->setTitle("Penjadwalan Semhas");
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $get_terdaftar_semhas = Daftar::with('proposal')->where_kategori_semhas_and_terjadwal_semhas(1, 0)->get();
            $jadwalsemhas_daftar = Jadwalsemhas::with('daftar', 'daftar.proposal')->order_by('tanggal', 'asc')->get();
            $datas = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'terdaftarsemhas' => $get_terdaftar_semhas,
                'datajadwalsemhas' => $jadwalsemhas_daftar,
                'menu' => 'Penjadwalan',
                'menu2' => 'Seminar Hasil'
            );
            return View::make('admin.jadwal', $datas);
        } else {
            $tanggal = $tanggal;
            $jam = $jam;
            $ruang = $ruang;
            $unslug = ucwords(str_replace('-', ' ', $ruang));
            $strupper = strtoupper($unslug);
            $jadwalcond = Jadwalsemhas::where_tanggal_and_jam_and_ruang($tanggal, $jam, $strupper)->get();
            foreach ($jadwalcond as $jadwal) {
                $this->id = $jadwal->daftar_id;
                Daftar::update($this->id, array(
                    'terjadwal_semhas' => 0
                ));
                Jadwalsemhas::where_daftar_id($this->id)->delete();
            }
            return Redirect::to_route('penjadwalansemhas')->with('message', 'Jadwal Berhasil Dihapus');
        }
    }

    // ----- Tampilkan Halaman Manage Berkas -----
    protected function post_jadwal_semhas() {
        $tanggal = Input::get('tanggal');
        $jam = Input::get('jam');
        $ruang = Input::get('ruang');
        $iddaftar = Input::get('iddaftar');
        if (empty($iddaftar)) {
            return Redirect::back()->with('message', 'Proses Penjadwalan Gagal, Harus Ada Mahasiswa Yang Dijadwalkan');
        } else {
            // looping tambah data
            for ($i = 0; $i < sizeof($iddaftar); $i++) {
                $id = $iddaftar[$i];
                $jadwalsemhas = new Jadwalsemhas;
                $jadwalsemhas->tanggal = date("Y-m-d", strtotime($tanggal));
                $jadwalsemhas->jam = $jam . ":00";
                $jadwalsemhas->ruang = $ruang;
                $jadwalsemhas->waktu = date("Y-m-d", strtotime($tanggal)) . " " . $jam . ":00";
                $jadwalsemhas->nourut = $i + 1;
                $daftar = Daftar::find($id);
                $daftar->jadwalsemhas()->insert($jadwalsemhas);
                Daftar::update($id, array(
                    'terjadwal_semhas' => 1
                ));
            }
            return Redirect::back()->with('message', 'Mahasiswa Berhasil Dijadwalkan');
        }
    }

    // ----- Tampilkan Halaman Manage Berkas -----
    protected function get_jadwal_ujian($tanggal = NULL, $jam = NULL, $ruang = NULL) {
        if ($tanggal == NULL && $jam == NULL && $ruang == NULL) {
            $this->setTitle("Penjadwalan Ujian TA");
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $get_terdaftar_ujian = Daftar::with('proposal')->where_kategori_ujian_and_terjadwal_ujian(1, 0)->get();
            $jadwalujian_daftar = Jadwalujian::with('daftar', 'daftar.proposal')->order_by('tanggal', 'asc')->get();
            $datas = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'terdaftarujian' => $get_terdaftar_ujian,
                'datajadwalujian' => $jadwalujian_daftar,
                'menu' => 'Penjadwalan',
                'menu2' => 'Ujian TA'
            );
            return View::make('admin.jadwal', $datas);
        } else {
            $tanggal = $tanggal;
            $jam = $jam;
            $ruang = $ruang;
            $unslug = ucwords(str_replace('-', ' ', $ruang));
            $strupper = strtoupper($unslug);
            $jadwalcond = Jadwalujian::where_tanggal_and_jam_and_ruang($tanggal, $jam, $strupper)->get();
            foreach ($jadwalcond as $jadwal) {
                $this->id = $jadwal->daftar_id;
                Daftar::update($this->id, array(
                    'terjadwal_ujian' => 0
                ));
                Jadwalujian::where_daftar_id($this->id)->delete();
            }
            return Redirect::to_route('penjadwalanujian')->with('message', 'Jadwal Berhasil Dihapus');
        }
    }

    // ----- Tampilkan Halaman Manage Berkas -----
    protected function post_jadwal_ujian() {
        $tanggal = Input::get('tanggal');
        $jam = Input::get('jam');
        $ruang = Input::get('ruang');
        $iddaftar = Input::get('iddaftar');
        if (empty($iddaftar)) {
            return Redirect::back()->with('message', 'Proses Penjadwalan Gagal, Harus Ada Mahasiswa Yang Dijadwalkan');
        } else {
            // looping tambah data
            for ($i = 0; $i < sizeof($iddaftar); $i++) {
                $id = $iddaftar[$i];
                $jadwalujian = new Jadwalujian;
                $jadwalujian->tanggal = date("Y-m-d", strtotime($tanggal));
                $jadwalujian->jam = $jam . ":00";
                $jadwalujian->ruang = $ruang;
                $jadwalujian->waktu = date("Y-m-d", strtotime($tanggal)) . " " . $jam . ":00";
                $jadwalujian->nourut = $i + 1;
                $daftar = Daftar::find($id);
                $daftar->jadwalujian()->insert($jadwalujian);
                $idhasil = Hasil::where_daftar_id($id)->first()->id;
                $cek_hasilujian = Hasil::where_daftar_id($id)->first()->hasil_ujian;
                if ($cek_hasilujian != 2) {
                    Hasil::update($idhasil, array(
                        'hasil_ujian' => 1,
                        'ts_ujian' => date("Y-m-d H:i:s")
                    ));
                } else {
                    Hasil::update($idhasil, array(
                        'hasil_ujian' => 2,
                        'ts_ujian' => date("Y-m-d H:i:s")
                    ));
                }
                Daftar::update($id, array(
                    'terjadwal_ujian' => 1
                ));
            }
            return Redirect::back()->with('message', 'Mahasiswa Berhasil Dijadwalkan');
        }
    }

    // ----- Tampilkan Halaman Manage Berkas -----
    protected function get_jadwalpenguji_sempro($id = NULL) {
        if ($id == NULL) {
            $this->setTitle("Penjadwalan Penguji Sempro");
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $datas = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'menu' => 'Penjadwalan',
                'menu2' => 'Penguji Seminar Proposal'
            );
            return View::make('admin.jadwalpenguji', $datas);
        } else {
            $this->id = Crypter::decrypt($id);
            Jadwalpengujisempro::where_id($this->id)->delete();
            return Redirect::back()->with('message', 'Dosen Berhasil Dihapus Menjadi Dosen Penguji');
        }
    }

    // ----- Tampilkan Halaman Manage Berkas -----
    protected function post_jadwalpenguji_sempro() {
        $idpenguji = Input::get('idpenguji');
        $finduser = User::find(Auth::user()->id)->admin()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        $tanggal = date("Y-m-d", strtotime(Input::get('tanggal')));
        $jam = Input::get('jam');
        $ruang = strtoupper(Input::get('ruang'));
        // -----
        $jadwalsempro_daftar = Jadwalsempro::with('daftar', 'daftar.proposal')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $ruang)->get();
        $get_dosen = Jadwalpengujisempro::with('dosen', 'dosen.user')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $ruang)->get();
        // -----
        if (empty($get_dosen)) {
            $get_dosen_condition = Jadwalpengujisempro::where_tanggal_and_jam($tanggal, $jam)->lists('dosen_id');
            if (!empty($get_dosen_condition)) {
                $get_dosen_terjadwal = Dosen::with('user')->where_not_in('id', $get_dosen_condition)->get();
            } else {
                $get_dosen_terjadwal = Dosen::with('user')->get();
            }
        } elseif (!empty($get_dosen)) {
            $get_dosen_condition = Jadwalpengujisempro::where_tanggal_and_jam($tanggal, $jam)->lists('dosen_id');
            if (!empty($get_dosen_condition)) {
                $get_dosen_terjadwal = Dosen::with('user')->where_not_in('id', $get_dosen_condition)->get();
            }
        }
        if (empty($idpenguji)) {
            $datas = array(
                'title' => "Penjadwalan Penguji Sempro",
                'user' => $finduser,
                'profil' => $profil,
                'datajadwalsempro' => $jadwalsempro_daftar,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'ruang' => $ruang,
                'datadosen' => $get_dosen,
                'datadosenterjadwal' => $get_dosen_terjadwal,
                'menu' => 'Penjadwalan',
                'menu2' => 'Penguji Seminar Proposal'
            );
            return View::make('admin.jadwalpenguji', $datas);
        } elseif (!empty($idpenguji)) {
            for ($i = 0; $i < sizeof($idpenguji); $i++) {
                $id = $idpenguji[$i];
                $jpengujisempro = new Jadwalpengujisempro;
                $jpengujisempro->tanggal = $tanggal;
                $jpengujisempro->jam = $jam . ":00";
                $jpengujisempro->ruang = $ruang;
                $jpengujisempro->waktu = $tanggal . " " . $jam . ":00";
                $dosen = Dosen::find($id);
                $dosen->jadwalpengujisempro()->insert($jpengujisempro);
            }
            return Redirect::back()->with('message', 'Dosen Berhasil Ditambahkan Menjadi Dosen Penguji');
        }
    }

    // ----- Tampilkan Halaman Manage Berkas -----
    protected function get_jadwalpenguji_semhas($id = NULL) {
        if ($id == NULL) {
            $this->setTitle("Penjadwalan Penguji Semhas");
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $datas = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'menu' => 'Penjadwalan',
                'menu2' => 'Penguji Seminar Hasil'
            );
            return View::make('admin.jadwalpenguji', $datas);
        } else {
            $this->id = Crypter::decrypt($id);
            Jadwalpengujisemhas::where_id($this->id)->delete();
            return Redirect::back()->with('message', 'Dosen Berhasil Dihapus Menjadi Dosen Penguji');
        }
    }

    // ----- Tampilkan Halaman Manage Berkas -----
    protected function post_jadwalpenguji_semhas() {
        $idpenguji = Input::get('idpenguji');
        $finduser = User::find(Auth::user()->id)->admin()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        $tanggal = date("Y-m-d", strtotime(Input::get('tanggal')));
        $jam = Input::get('jam');
        $ruang = Input::get('ruang');
        // -----
        $jadwalsemhas_daftar = Jadwalsemhas::with('daftar', 'daftar.proposal')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $ruang)->get();
        $get_dosen = Jadwalpengujisemhas::with('dosen', 'dosen.user')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $ruang)->get();
        // -----
        if (empty($get_dosen)) {
            $get_dosen_condition = Jadwalpengujisemhas::where_tanggal_and_jam($tanggal, $jam)->lists('dosen_id');
            if (!empty($get_dosen_condition)) {
                $get_dosen_terjadwal = Dosen::with('user')->where_not_in('id', $get_dosen_condition)->get();
            } else {
                $get_dosen_terjadwal = Dosen::with('user')->get();
            }
        } elseif (!empty($get_dosen)) {
            $get_dosen_condition = Jadwalpengujisemhas::where_tanggal_and_jam($tanggal, $jam)->lists('dosen_id');
            if (!empty($get_dosen_condition)) {
                $get_dosen_terjadwal = Dosen::with('user')->where_not_in('id', $get_dosen_condition)->get();
            }
        }
        if (empty($idpenguji)) {
            $datas = array(
                'title' => "Penjadwalan Penguji Semhas",
                'user' => $finduser,
                'profil' => $profil,
                'datajadwalsemhas' => $jadwalsemhas_daftar,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'ruang' => $ruang,
                'datadosen' => $get_dosen,
                'datadosenterjadwal' => $get_dosen_terjadwal,
                'menu' => 'Penjadwalan',
                'menu2' => 'Penguji Seminar Hasil'
            );
            return View::make('admin.jadwalpenguji', $datas);
        } elseif (!empty($idpenguji)) {
            for ($i = 0; $i < sizeof($idpenguji); $i++) {
                $id = $idpenguji[$i];
                $jpengujisemhas = new Jadwalpengujisemhas;
                $jpengujisemhas->tanggal = $tanggal;
                $jpengujisemhas->jam = $jam . ":00";
                $jpengujisemhas->ruang = $ruang;
                $jpengujisemhas->waktu = $tanggal . " " . $jam . ":00";
                $dosen = Dosen::find($id);
                $dosen->jadwalpengujisemhas()->insert($jpengujisemhas);
            }
            return Redirect::back()->with('message', 'Dosen Berhasil Ditambahkan Menjadi Dosen Penguji');
        }
    }

    // ----- Tampilkan Halaman Manage Berkas -----
    protected function get_jadwalpenguji_ujian($id = NULL) {
        if ($id == NULL) {
            $this->setTitle("Penjadwalan Penguji Ujian TA");
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $datas = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'menu' => 'Penjadwalan',
                'menu2' => 'Penguji Ujian TA'
            );
            return View::make('admin.jadwalpenguji', $datas);
        } else {
            $this->id = Crypter::decrypt($id);
            Jadwalpengujiujian::where_id($this->id)->delete();
            return Redirect::back()->with('message', 'Dosen Berhasil Dihapus Menjadi Dosen Penguji');
        }
    }

    // ----- Tampilkan Halaman Manage Berkas -----
    protected function post_jadwalpenguji_ujian() {
        $idpenguji = Input::get('idpenguji');
        $finduser = User::find(Auth::user()->id)->admin()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        $tanggal = date("Y-m-d", strtotime(Input::get('tanggal')));
        $jam = Input::get('jam');
        $ruang = Input::get('ruang');
        // -----
        $jadwalujian_daftar = Jadwalujian::with('daftar', 'daftar.proposal')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $ruang)->get();
        $get_dosen = Jadwalpengujiujian::with('dosen', 'dosen.user')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $ruang)->get();
        // -----
        if (empty($get_dosen)) {
            $get_dosen_condition = Jadwalpengujiujian::where_tanggal_and_jam($tanggal, $jam)->lists('dosen_id');
            if (!empty($get_dosen_condition)) {
                $get_dosen_terjadwal = Dosen::with('user')->where_not_in('id', $get_dosen_condition)->get();
            } else {
                $get_dosen_terjadwal = Dosen::with('user')->get();
            }
        } elseif (!empty($get_dosen)) {
            $get_dosen_condition = Jadwalpengujiujian::where_tanggal_and_jam($tanggal, $jam)->lists('dosen_id');
            if (!empty($get_dosen_condition)) {
                $get_dosen_terjadwal = Dosen::with('user')->where_not_in('id', $get_dosen_condition)->get();
            }
        }
        if (empty($idpenguji)) {
            $datas = array(
                'title' => "Penjadwalan Penguji Ujian TA",
                'user' => $finduser,
                'profil' => $profil,
                'datajadwalujian' => $jadwalujian_daftar,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'ruang' => $ruang,
                'datadosen' => $get_dosen,
                'datadosenterjadwal' => $get_dosen_terjadwal,
                'menu' => 'Penjadwalan',
                'menu2' => 'Penguji Seminar Ujian TA'
            );
            return View::make('admin.jadwalpenguji', $datas);
        } elseif (!empty($idpenguji)) {
            for ($i = 0; $i < sizeof($idpenguji); $i++) {
                $id = $idpenguji[$i];
                $jpengujiujian = new Jadwalpengujiujian;
                $jpengujiujian->tanggal = $tanggal;
                $jpengujiujian->jam = $jam . ":00";
                $jpengujiujian->ruang = $ruang;
                $jpengujiujian->waktu = $tanggal . " " . $jam . ":00";
                $dosen = Dosen::find($id);
                $dosen->jadwalpengujiujian()->insert($jpengujiujian);
            }
            return Redirect::back()->with('message', 'Dosen Berhasil Ditambahkan Menjadi Dosen Penguji');
        }
    }

    // ----- Tampilkan Halaman Manage Pembimbing ----- 
    protected function get_pembimbing($id = NULL) {
        $this->setTitle("Manage Pembimbing Tugas Akhir");
        $finduser = User::find(Auth::user()->id)->admin()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        $get_daftar_sempro = Hasil::with('daftar', 'daftar.jadwalsempro', 'daftar.proposal', 'daftar.suratkeputusan', 'daftar.bimbingan', 'bimbingan.dosen')->where_hasil_sempro(1)->order_by('ts_sempro', 'desc')->paginate(10);
        if (is_null($id)) {
            $detailmahasiswa = 'null';
            $datas = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'daftarsempro' => $get_daftar_sempro,
                'detailmahasiswa' => $detailmahasiswa,
                'menu' => 'Pembimbing',
                'menu2' => 'Manage Pembimbing'
            );
            return View::make('admin.pembimbing', $datas);
        } else {
            $this->id = Crypter::decrypt($id);
            $detailmahasiswa = Bimbingan::with('daftar', 'daftar.proposal', 'dosen')->where_daftar_id($this->id)->get();
            $pembimbing1 = Bimbingan::with('dosen')->where_daftar_id_and_is_dosen($this->id, 1)->first();
            $pembimbing2 = Bimbingan::with('dosen')->where_daftar_id_and_is_dosen($this->id, 2)->first();
            $pembimbingterpilih = Bimbingan::where_daftar_id($this->id)->lists('dosen_id');
            $pembimbingsum = Bimbingan::where_daftar_id($this->id)->sum('rekomendasi');
            $listdosen = Dosen::with('user')->where_not_in('id', $pembimbingterpilih)->get();
            $srtkeputusan = Daftar::find($this->id)->suratkeputusan()->first();
            foreach ($detailmahasiswa as $data) {
                $nama = $data->daftar->nama;
                $nim = $data->daftar->proposal->nim;
                $judul = $data->daftar->judul;
                $getalldata = array(
                    'nama' => $nama,
                    'nim' => $nim,
                    'judul' => $judul,
                );
            }
            $datas = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'daftarsempro' => $get_daftar_sempro,
                'detailmahasiswa' => $detailmahasiswa,
                'getalldata' => $getalldata,
                'pembimbing1' => $pembimbing1,
                'pembimbing2' => $pembimbing2,
                'listdosen' => $listdosen,
                'jumlahpem' => $pembimbingsum,
                'srtkeputusan' => $srtkeputusan,
                'menu' => 'Pembimbing',
                'menu2' => 'Manage Pembimbing'
            );
            return View::make('admin.pembimbing', $datas);
        }
    }

    protected function put_tambahpembimbing() {
        $daftarid = Input::get('iddaftar');
        $bimbinganid1 = Input::get('idbimbingan1');
        $bimbinganid2 = Input::get('idbimbingan2');
        $pembimbing1 = Input::get('dosenpembimbing1');
        $pembimbing2 = Input::get('dosenpembimbing2');
        $tanggalawal = Input::get('tanggalawal') . ' 00:00:00';
        $tanggalakhir = strtotime(date("Y-m-d H:i:s", strtotime($tanggalawal)) . " +1 years");
        $ceksuratkeputusan = Daftar::find($daftarid)->suratkeputusan()->first();
        if (empty($ceksuratkeputusan)) {
            try {
                $srtkeputusan = new Suratkeputusan;
                $srtkeputusan->awaltanggal = date('Y-m-d H:i:s', strtotime($tanggalawal));
                $srtkeputusan->akhirtanggal = date('Y-m-d H:i:s', $tanggalakhir);
                $daftar = Daftar::find($daftarid);
                $daftar->suratkeputusan()->insert($srtkeputusan);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
        try {
            Bimbingan::update($bimbinganid1, array(
                'dosen_id' => $pembimbing1
            ));
            Bimbingan::update($bimbinganid2, array(
                'dosen_id' => $pembimbing2
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return Redirect::to_route('managepembimbing')->with('message', 'Dosen Telah Berhasil Ditambahkan Menjadi Dosen Pembimbing Tugas Akhir Mahasiswa');
    }

    // ----- Tampilkan Halaman Manage Informasi ----- 
    protected function get_informasi($idinformasi = NULL) {
        if ($idinformasi == NULL) {
            $this->setTitle("Informasi");
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $informasi = Informasi::with('admin')->order_by('updated_at', 'desc')->paginate(9);
            $detailinfo = 'not detail';
        } else {
            $this->id = $idinformasi;
            $detailinfo = Informasi::find($this->id);
            $this->setTitle($detailinfo->judul);
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $informasi = Informasi::with('admin')->order_by('updated_at', 'desc')->paginate(9);
        }
        $datas = array(
            'title' => $this->title,
            'user' => $finduser,
            'profil' => $profil,
            'informasi' => $informasi,
            'detailinfo' => $detailinfo,
            'menu' => 'Informasi',
            'menu2' => 'Manage Informasi'
        );
        return View::make('admin.informasi', $datas);
    }

    // ----- Tambah Informasi Baru----- 
    protected function post_informasi() {

        $rules = array(
            'fileinformasi' => 'mimes:doc,zip,xls,ppt'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->passes()) {
            $this->id = Input::get('id');
            $judul = Input::get('judul');
            $isi = Input::get('isi');
            $tanggal = date("Y-m-d");
            $cekfileinformasi = Input::file('fileinformasi.name');
            $findadmin = Admin::find($this->id);
            if (empty($cekfileinformasi)) {
                try {
                    // ----- Tambahkan Informasi Baru -----
                    $informasi = new Informasi;
                    $informasi->judul = $judul;
                    $informasi->isi = $isi;
                    $informasi->tanggal = $tanggal;
                    // ----- Masukkan Admin Ke Informasi ----- 
                    $findadmin->informasi()->insert($informasi);
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            } else {
                $fileinformasiname = Str::random(15) . '.' . File::extension(Input::file('fileinformasi.name'));
                try {
                    // ----- Tambahkan Informasi Baru -----
                    $informasi = new Informasi;
                    $informasi->judul = $judul;
                    $informasi->isi = $isi;
                    $informasi->tanggal = $tanggal;
                    $informasi->file = $fileinformasiname;
                    // ----- Masukkan Admin Ke Informasi ----- 
                    $findadmin->informasi()->insert($informasi);
                    Input::upload('fileinformasi', 'public/uploads/berkas/informasi', $fileinformasiname);
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
            return Redirect::back()->with('message', 'Informasi Berhasil Ditambahkan');
        } else {
            return Redirect::back()->with_input()->with_errors($validation);
        }
    }

    // ----- Update Informasi ----- 
    protected function put_informasi() {
        $this->id = Input::get('id');
        $judul = Input::get('judul');
        $isi = Input::get('isi');
        $tanggal = date("Y-m-d");
        $cekfileinformasi = Input::file('fileinformasi.name');
        if (empty($cekfileinformasi)) {
            try {
                Informasi::update($this->id, array(
                    'judul' => $judul,
                    'isi' => $isi,
                    'tanggal' => $tanggal,
                ));
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        } else {
            $fileinformasiname = Str::random(15) . '.' . File::extension(Input::file('fileinformasi.name'));
            $fileinformasi = Informasi::find($this->id);
            File::delete('public/uploads/berkas/informasi/' . $fileinformasi->file);
            try {
                Informasi::update($this->id, array(
                    'judul' => $judul,
                    'isi' => $isi,
                    'tanggal' => $tanggal,
                    'file' => $fileinformasiname
                ));
                Input::upload('fileinformasi', 'public/uploads/berkas/informasi', $fileinformasiname);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
        return Redirect::back()->with('message', 'Informasi Berhasil Diupdate');
    }

    // ----- Tampilkan Halaman Manage Berkas ----- 
    protected function get_berkas($id = NULL, $file = NULL) {
        if (is_null($id) && is_null($file)) {
            $this->setTitle("Berkas Persyaratan");
            $finduser = User::find(Auth::user()->id)->admin()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $berkas = Berkas::all();
            $datas = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'berkass' => $berkas,
                'menu' => 'Berkas Persyaratan',
                'menu2' => 'Manage Berkas Persyaratan'
            );
            return View::make('admin.berkas', $datas);
        } else {
            // ----- Decrypt Process -----
            $this->id = Crypter::decrypt($id);
            $file = $file;
            // ----- Return Response Download -----
            if ($this->id == 1) {
                return Response::download('public/uploads/berkas/semhas&ujian/' . $file);
            }
        }
    }

    // ----- Tambah Data Berkas Persyaratan ----- 
    protected function post_addberkas() {
        // ----- Get Input Data -----
        $idadmin = Input::get('idadmin');
        $namaberkas = Input::get('namaberkas');
        $kategori = Input::get('kategori');
        $fileberkasname = Str::random(15) . '.' . File::extension(Input::file('fileberkas.name'));
        // ----- Tambah Berkas Baru -----
        $berkas = new Berkas;
        $berkas->nama = $namaberkas;
        $berkas->kategori = $kategori;
        $berkas->file = $fileberkasname;
        $finds = Admin::find($idadmin);
        $finds->berkas()->insert($berkas);
        // ----- Upload File -----
        if ($kategori == 1) {
            Input::upload('fileberkas', 'public/uploads/berkas/semhas&ujian', $fileberkasname);
        }
        return Redirect::back()->with('message', 'File Berkas Persyaratan Berhasil Ditambahkan');
    }

    // ----- Delete Proposal -----
    protected function get_deletefile($id) {
        // ----- Decrypt Process -----
        $this->id = Crypter::decrypt($id);
        // ----- Proses Hapus Berkas Sesuai ID -----
        $file = Berkas::find($this->id)->first();
        Berkas::find($this->id)->delete();
        if ($file->kategori == 1) {
            File::delete('public/uploads/berkas/semhas&ujian/' . $file->file);
        }
        return Redirect::back()->with('message', 'File Berkas Persyaratan Berhasil Dihapus');
    }

    // ----- Tampilkan Halaman File Manager ----- 
    protected function get_filemanager() {
        $this->setTitle("File Manager");
        $finduser = User::find(Auth::user()->id)->admin()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        $datas = array(
            'title' => $this->title,
            'user' => $finduser,
            'profil' => $profil,
            'menu' => 'Manager',
            'menu2' => 'File Manager'
        );
        return View::make('admin.filemanager', $datas);
    }

}