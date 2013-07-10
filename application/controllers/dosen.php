<?php

class Dosen_Controller extends User_Controller {

    private $id;

    public function __construct() {
        parent::__construct();
    }

    // ----- Fungsi Logout -----
    protected function get_logoutdosen() {
        $this->setTitle("Login");
        parent::logoutAll();
        return Redirect::to_route('loginuser')->with('title', $this->title)->with('message', 'Anda Telah Berhasil Logout');
    }

    // ----- Tampilkan Halaman Dashboard Dosen ----- //
    protected function get_dashboarddosen($idinformasi = NULL) {
        $informasi = $this->allInformasi();
        if ($idinformasi == NULL) {
            if (Auth::guest() || Auth::user()->role != 2) {
                return Redirect::to_route('loginuser')->with('message', 'Anda Harus Login Terlebih Dahulu');
            } else {
                $this->setTitle("Dosen Dashboard");
                $finduser = User::find(Auth::user()->id)->dosen()->first();
                $profil = User::find(Auth::user()->id)->profil()->first();
                $dosen_pembimbing = Dosen::find($finduser->id)->pembimbing()->where_approval(0)->count();
                $mahasiswabimbingan = Bimbingan::where_dosen_id($finduser->id)->count();
                $bthrekomendasi = Bimbingan::where_dosen_id($finduser->id)->where_rekomendasi(0)->count();
                $jadwalpengujisempro = Jadwalpengujisempro::where_dosen_id($finduser->id)->order_by('tanggal', 'desc')->take(1)->get();
                $jadwalpengujisemhas = Jadwalpengujisemhas::where_dosen_id($finduser->id)->order_by('tanggal', 'desc')->take(1)->get();
                $jadwalpengujiujian = Jadwalpengujiujian::where_dosen_id($finduser->id)->order_by('tanggal', 'desc')->take(1)->get();
                $data = array(
                    'title' => $this->title,
                    'user' => $finduser,
                    'profil' => $profil,
                    'informasi' => $informasi,
                    'pembimbing' => $dosen_pembimbing,
                    'totalmhsbimbingan' => $mahasiswabimbingan,
                    'bthrekomendasi' => $bthrekomendasi,
                    'jadwalpsemproterdekat' => $jadwalpengujisempro,
                    'jadwalpsemhasterdekat' => $jadwalpengujisemhas,
                    'jadwalpujianterdekat' => $jadwalpengujiujian,
                    'menu' => 'Dashboard',
                    'menu2' => 'Home Dashboard'
                );
            }
        } else {
            $this->setTitle("Dosen Dashboard");
            $this->id = $idinformasi;
            $detailinformasi = Informasi::find($this->id);
            $finduser = User::find(Auth::user()->id)->dosen()->first();
            $profil = User::find(Auth::user()->id)->profil()->first();
            $dosen_pembimbing = Dosen::find($finduser->id)->pembimbing()->where_approval(0)->count();
            $mahasiswabimbingan = Bimbingan::where_dosen_id($finduser->id)->count();
            $bthrekomendasi = Bimbingan::where_dosen_id($finduser->id)->where_rekomendasi(0)->count();
            $jadwalpengujisempro = Jadwalpengujisempro::where_dosen_id($finduser->id)->order_by('tanggal', 'desc')->take(1)->get();
            $jadwalpengujisemhas = Jadwalpengujisemhas::where_dosen_id($finduser->id)->order_by('tanggal', 'desc')->take(1)->get();
            $jadwalpengujiujian = Jadwalpengujiujian::where_dosen_id($finduser->id)->order_by('tanggal', 'desc')->take(1)->get();
            $data = array(
                'title' => $this->title,
                'user' => $finduser,
                'profil' => $profil,
                'informasi' => $informasi,
                'detailinformasi' => $detailinformasi,
                'pembimbing' => $dosen_pembimbing,
                'totalmhsbimbingan' => $mahasiswabimbingan,
                'bthrekomendasi' => $bthrekomendasi,
                'jadwalpsemproterdekat' => $jadwalpengujisempro,
                'jadwalpsemhasterdekat' => $jadwalpengujisemhas,
                'jadwalpujianterdekat' => $jadwalpengujiujian,
                'menu' => 'Dashboard',
                'menu2' => 'Home Dashboard'
            );
        }
        return View::make('dosen.home', $data);
    }

    protected function get_downloadfileinformasi($file) {
        $this->id = Crypter::decrypt($file);
        return Response::download('public/uploads/berkas/informasi/' . $this->id);
    }

    // ----- Tampilkan Halaman Approval ----- //
    protected function get_approval() {
        $this->setTitle("Approval Proposal");
        $finduser = User::find(Auth::user()->id)->dosen()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        $find_dosen_pembimbing_orderby = Dosen::find($finduser->id)->pembimbing()->order_by('created_at', 'asc')->paginate(10);
        $find_dosen_pembimbing_approval = Dosen::find($finduser->id)->pembimbing()->where('approval', '=', '0')->count();
        $find_dosen_pembimbing_read = Dosen::find($finduser->id)->pembimbing()->where('readeable', '=', '0')->count();
        $data = array(
            'title' => $this->title,
            'user' => $finduser,
            'profil' => $profil,
            'pembimbingsorderby' => $find_dosen_pembimbing_orderby,
            'menu' => 'Approval',
            'menu2' => 'Approval Proposal'
        );
        return View::make('dosen.approval', $data);
    }

    // ----- Tampilkan Halaman Detail Proposal ----- //
    protected function get_detailproposal($id_proposal, $id_dosen) {
        $this->setTitle("Detail Proposal");
        $finduser = User::find(Auth::user()->id)->dosen()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        $this->id = Crypter::decrypt($id_proposal);
        $get_pembimbing = Pembimbing::where_proposal_id_and_dosen_id($this->id, $id_dosen)->first();
        $check_readable = $get_pembimbing->readeable;
        $get_id = $get_pembimbing->id;
        if ($check_readable == 0) {
            Pembimbing::update($get_id, array(
                'readeable' => 1
            ));
        }
        // ----- Get Proposal Data -----
        $proposal_byid = Proposal::find($this->id);
        // ----- Get Data From Relation Table -----
        $proposal_mahasiswa_byid = Proposal::find($this->id)->mahasiswa()->first();
        $user_byid = User::find($proposal_mahasiswa_byid->user_id);
        $data = array(
            'title' => $this->title,
            'user' => $finduser,
            'profil' => $profil,
            'proposal' => $proposal_byid,
            'pembimbingid' => $get_id,
            'mahasiswausers' => $user_byid,
            'menu' => 'Approval',
            'menu2' => 'Detail Proposal'
        );
        return View::make('dosen.spesifik.approvalproposal_detail', $data);
    }

    // ----- Donwnload File -----
    protected function get_downloadproposal($nim, $dokumen_name) {
        // ----- Decrypt Process -----
        $folder_nim = Crypter::decrypt($nim);
        $this->id = $dokumen_name;
        // ----- Return Response Download -----
        return Response::download('public/uploads/' . $folder_nim . '/proposal/' . $this->id);
    }

    // ----- Approve Proposal ----- //
    protected function put_approvalproposal() {
        $proposal_pembimbing_id = Input::get('idpembimbing');
        $proposal_pembimbing_statusapproval = Input::get('approval');
        $proposal_pembimbing_catatan = Input::get('catatan');
        if (empty($proposal_pembimbing_statusapproval)) {
            return Redirect::back()->with('message', 'Anda Harus Memilih Salah Status Untuk Proposal Judul Ini');
        } else {
            try {
                Pembimbing::update($proposal_pembimbing_id, array(
                    'approval' => $proposal_pembimbing_statusapproval,
                    'catatan' => $proposal_pembimbing_catatan,
                ));
                return Redirect::back()->with('message', 'Status Proposal Berhasil Diupdate');
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

    // ----- Tampilkan Halaman Penguji Sempro ----- //
    protected function get_jadwalpengujisempro($tanggal = NULL, $jam = NULL, $ruang = NULL) {
        $user = User::find(Auth::user()->id)->dosen()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        if ($tanggal == NULL && $jam == NULL && $ruang == NULL) {
            $this->setTitle("Jadwal Penguji Seminar Proposal");
            $jadwalpengujisempro = Jadwalpengujisempro::with('dosen', 'dosen.user')->where_dosen_id($user->id)->paginate(10);
            $data = array(
                'title' => $this->title,
                'user' => $user,
                'profil' => $profil,
                'jadwalpengujis' => $jadwalpengujisempro,
                'menu' => 'Jadwal Penguji',
                'menu2' => 'Jadwal Penguji Seminar Proposal'
            );
            return View::make('dosen.jadwalpenguji', $data);
        } else {
            $this->setTitle("Detail Jadwal Penguji Seminar Proposal");
            $tanggal = date('Y-m-d', strtotime($tanggal));
            $jam = $jam . ':00';
            $ruang = $ruang;
            $unslug = ucwords(str_replace('-', ' ', $ruang));
            $strupper = strtoupper($unslug);
            $jadwalpengujisemproall = Jadwalpengujisempro::with('dosen', 'dosen.user')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $strupper)->get();
            $jadwalsempro = Jadwalsempro::with('daftar', 'daftar.proposal')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $strupper)->get();
            // ----- Sisa Waktu -----
            $datea = strtotime($tanggal);
            $remaining = $datea - time();
            $days_remaining = floor($remaining / 86400) + 1;
            if ($days_remaining < 0) {
                $lefttime = "Selesai";
            } else {
                if ($days_remaining == 0) {
                    $lefttime = "Hari Ini";
                } else {
                    $lefttime = "$days_remaining Hari";
                }
            }
            $data = array(
                'title' => $this->title,
                'user' => $user,
                'profil' => $profil,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'ruang' => $strupper,
                'sisawaktu' => $lefttime,
                'jadwalpengujisall' => $jadwalpengujisemproall,
                'jadwalsempros' => $jadwalsempro,
                'menu' => 'Jadwal Penguji',
                'menu2' => 'Jadwal Penguji Seminar Proposal'
            );
            return View::make('dosen.spesifik.jadwalpenguji_detail', $data);
        }
    }

    // ----- Tampilkan Halaman Penguji Semhas ----- //
    protected function get_jadwalpengujisemhas($tanggal = NULL, $jam = NULL, $ruang = NULL) {
        $user = User::find(Auth::user()->id)->dosen()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        if ($tanggal == NULL && $jam == NULL && $ruang == NULL) {
            $this->setTitle("Jadwal Penguji Seminar Hasil");
            $jadwalpengujisemhas = Jadwalpengujisemhas::with('dosen', 'dosen.user')->where_dosen_id($user->id)->paginate(10);
            $data = array(
                'title' => $this->title,
                'user' => $user,
                'profil' => $profil,
                'jadwalpengujis' => $jadwalpengujisemhas,
                'menu' => 'Jadwal Penguji',
                'menu2' => 'Jadwal Penguji Seminar Hasil'
            );
            return View::make('dosen.jadwalpenguji', $data);
        } else {
            $this->setTitle("Detail Jadwal Penguji Seminar Proposal");
            $tanggal = date('Y-m-d', strtotime($tanggal));
            $jam = $jam . ':00';
            $ruang = $ruang;
            $unslug = ucwords(str_replace('-', ' ', $ruang)); // Hello World
            $strupper = strtoupper($unslug);
            $jadwalpengujisemhasall = Jadwalpengujisemhas::with('dosen', 'dosen.user')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $strupper)->get();
            $jadwalsemhas = Jadwalsemhas::with('daftar', 'daftar.proposal')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $strupper)->get();
            // ----- Sisa Waktu -----
            $datea = strtotime($tanggal);
            $remaining = $datea - time();
            $days_remaining = floor($remaining / 86400) + 1;
            if ($days_remaining < 0) {
                $lefttime = "Selesai";
            } else {
                if ($days_remaining == 0) {
                    $lefttime = "Hari Ini";
                } else {
                    $lefttime = "$days_remaining Hari";
                }
            }
            $data = array(
                'title' => $this->title,
                'user' => $user,
                'profil' => $profil,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'ruang' => $strupper,
                'sisawaktu' => $lefttime,
                'jadwalpengujisall' => $jadwalpengujisemhasall,
                'jadwalsemhass' => $jadwalsemhas,
                'menu' => 'Jadwal Penguji',
                'menu2' => 'Jadwal Penguji Seminar Hasil'
            );
            return View::make('dosen.spesifik.jadwalpenguji_detail', $data);
        }
    }

    // ----- Tampilkan Halaman Penguji Ujian ----- //
    protected function get_jadwalpengujiujian($tanggal = NULL, $jam = NULL, $ruang = NULL) {
        $user = User::find(Auth::user()->id)->dosen()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        if ($tanggal == NULL && $jam == NULL && $ruang == NULL) {
            $this->setTitle("Jadwal Penguji Ujian TA");
            $jadwalpengujiujian = Jadwalpengujiujian::with('dosen', 'dosen.user')->where_dosen_id($user->id)->paginate(10);
            $data = array(
                'title' => $this->title,
                'user' => $user,
                'profil' => $profil,
                'jadwalpengujis' => $jadwalpengujiujian,
                'menu' => 'Jadwal Penguji',
                'menu2' => 'Jadwal Penguji Ujian TA'
            );
            return View::make('dosen.jadwalpenguji', $data);
        } else {
            $this->setTitle("Detail Jadwal Penguji Ujian TA");
            $tanggal = date('Y-m-d', strtotime($tanggal));
            $jam = $jam . ':00';
            $ruang = $ruang;
            $unslug = ucwords(str_replace('-', ' ', $ruang)); // Hello World
            $strupper = strtoupper($unslug);
            $jadwalpengujiujianall = Jadwalpengujiujian::with('dosen', 'dosen.user')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $strupper)->get();
            $jadwalujian = Jadwalujian::with('daftar', 'daftar.proposal')->where_tanggal_and_jam_and_ruang($tanggal, $jam, $strupper)->get();
            // ----- Sisa Waktu -----
            $datea = strtotime($tanggal);
            $remaining = $datea - time();
            $days_remaining = floor($remaining / 86400) + 1;
            if ($days_remaining < 0) {
                $lefttime = "Selesai";
            } else {
                if ($days_remaining == 0) {
                    $lefttime = "Hari Ini";
                } else {
                    $lefttime = "$days_remaining Hari";
                }
            }
            $data = array(
                'title' => $this->title,
                'user' => $user,
                'profil' => $profil,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'ruang' => $strupper,
                'sisawaktu' => $lefttime,
                'jadwalpengujisall' => $jadwalpengujiujianall,
                'jadwalujians' => $jadwalujian,
                'menu' => 'Jadwal Penguji',
                'menu2' => 'Jadwal Penguji Ujian TA'
            );
            return View::make('dosen.spesifik.jadwalpenguji_detail', $data);
        }
    }

    protected function get_bimbingan($id = NULL) {
        $this->setTitle("Asistensi Bimbingan");
        $user = User::find(Auth::user()->id)->dosen()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        if (is_null($id)) {
            $mahasiswabimbingan = Bimbingan::with('daftar', 'daftar.proposal')->where_dosen_id($user->id)->paginate(15);
            $detailasistensi = 'null';
            $data = array(
                'title' => $this->title,
                'user' => $user,
                'profil' => $profil,
                'mhsbimbingan' => $mahasiswabimbingan,
                'detailasistensi' => $detailasistensi,
                'menu' => 'Bimbingan',
                'menu2' => 'Asistensi Bimbingan'
            );
            return View::make('dosen.bimbingan', $data);
        } else {
            $this->id = Crypter::decrypt($id);
            $mahasiswabimbingan = Bimbingan::with('daftar', 'daftar.proposal')->where_dosen_id($user->id)->paginate(15);
            $detailasistensi = Bimbingan::with('daftar', 'daftar.proposal', 'dosen')->where_id($this->id)->first();
            $catatanasistensi = Bimbingan::find($this->id)->asistensi()->get();
            $getdata = Bimbingan::find($this->id);
            $iddaftar = $getdata->daftar_id;
            $datadosen = Bimbingan::with('dosen')->where_daftar_id($iddaftar)->where('dosen_id', '!=', $user->id)->first();
            $catatanasistensidosenlain = Bimbingan::find($datadosen->id)->asistensi()->get();
            $data = array(
                'title' => $this->title,
                'user' => $user,
                'profil' => $profil,
                'idbimbingan' => $this->id,
                'mhsbimbingan' => $mahasiswabimbingan,
                'detailasistensi' => $detailasistensi,
                'catatanasistensi' => $catatanasistensi,
                'datadosen' => $datadosen,
                'catatanlain' => $catatanasistensidosenlain,
                'menu' => 'Bimbingan',
                'menu2' => 'Asistensi Bimbingan'
            );
            return View::make('dosen.bimbingan', $data);
        }
    }

    protected function post_asistensi() {
        $idbimbingan = Input::get('bimbinganid');
        $catatan = Input::get('catatan');
        try {
            $asistensi = new Asistensi;
            $asistensi->catatan = $catatan;
            $asistensibimbingan = Bimbingan::find($idbimbingan);
            $asistensibimbingan->asistensi()->insert($asistensi);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return Redirect::to_route('asistensibimbingan')->with('message', 'Catatan Bimbingan Telah Diberikan Kepada Mahasiswa yang Bersangkutan');
    }

    protected function put_rekomendasi() {
        $idbimbingan = Input::get('bimbinganid');
        try {
            Bimbingan::update($idbimbingan, array(
                'rekomendasi' => 1
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return Redirect::to_route('asistensibimbingan')->with('message', 'Mahasiswa yang Bersangkutan Telah Direkomendasikan Semhas & Ujian TA');
    }

    protected function get_detailproposalmahasiswa($id) {
        $this->setTitle("Detail Proposal Mahasiswa");
        $finduser = User::find(Auth::user()->id)->dosen()->first();
        $profil = User::find(Auth::user()->id)->profil()->first();
        $this->id = Crypter::decrypt($id);
        $dataproposal = Proposal::with('mahasiswa', 'mahasiswa.user', 'user.profil')->where_mahasiswa_id($this->id)->first();
        $data = array(
            'title' => $this->title,
            'user' => $finduser,
            'profil' => $profil,
            'dataproposal' => $dataproposal,
            'menu' => 'Jadwal Penguji',
            'menu2' => 'Detail Proposal Mahasiswa'
        );
        return View::make('dosen.spesifik.mahasiswaproposal_detail', $data);
    }

    protected function get_proposaldetail_download($nim, $file) {
        // ----- Decrypt Process -----
        $nim = Crypter::decrypt($nim);
        $this->id = $file;
        // ----- Return Response Download -----
        return Response::download('public/uploads/' . $nim . '/proposal/' . $this->id);
    }

}