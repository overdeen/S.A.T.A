<?php

class Mahasiswa_Controller extends User_Controller {

    private $id;

    public function __construct() {
        parent::__construct();
    }

    // ----- Fungsi Logout -----
    protected function get_logoutmahasiswa() {
        $this->setTitle("Login");
        parent::logoutAll();
        return Redirect::to_route('loginuser')->with('title', $this->title)->with('message', 'Anda Telah Berhasil Logout');
    }

    // ----- Tampilkan Halaman Dashboard Mahasiswa ----- //
    protected function get_dashboardmahasiswa($idinformasi = NULL) {
        if ($idinformasi == NULL) {
            if (Auth::guest() || Auth::user()->role != 3) {
                return Redirect::to_route('loginuser')->with('message', 'Anda Harus Login Terlebih Dahulu');
            } else {
                $informasi = $this->allInformasi();
                $this->setTitle("Mahasiswa Dashboard");
                $userall = User::with('mahasiswa')->where_role(3)->order_by('created_at', 'desc')->take(15)->get();
                // ----- Get Mahasiswa Data Sesuai ID ----- //
                $users = User::find(Auth::user()->id)->mahasiswa()->first();
                // ----- Get Profil Data Sesuai ID ----- //
                $profils = User::find(Auth::user()->id)->profil()->first();
                $counts = User::find(Auth::user()->id)->profil()->count();
                $proposal = Mahasiswa::find($users->id)->proposal()->first();
                if (empty($proposal)) {
                    $proposals = 'null';
                    $approvalcount = 'null';
                    $rekomendasi = 'null';
                    $hasils = 'null';
                    $jadwalsempro = 'null';
                    $jadwalsemhas = 'null';
                    $jadwalujian = 'null';
                } else {
                    $proposals = $proposal;
                    $approval = Proposal::find($proposal->id)->pembimbing()->sum('approval');
                    if (empty($approval) || $approval == 0) {
                        $approvalcount = 'null';
                    } else {
                        $approvalcount = $approval;
                    }
                    $daftars = Proposal::find($proposal->id)->daftar()->first();
                    if (empty($daftars)) {
                        $rekomendasi = 'null';
                        $jadwalsempro = 'null';
                        $jadwalsemhas = 'null';
                        $jadwalujian = 'null';
                        $hasils = 'null';
                    } else {
                        $jadwalsempro = Jadwalsempro::where_daftar_id($daftars->id)->order_by('tanggal', 'desc')->first();
                        $jadwalsemhas = Jadwalsemhas::where_daftar_id($daftars->id)->order_by('tanggal', 'desc')->first();
                        $jadwalujian = Jadwalujian::where_daftar_id($daftars->id)->order_by('tanggal', 'desc')->first();
                        $hasil = Daftar::find($daftars->id)->hasil()->first();
                        if (empty($hasil)) {
                            $hasils = 'null';
                        } else {
                            $hasils = $hasil;
                        }
                        $bimbingans = Daftar::find($daftars->id)->bimbingan()->get();
                        if (empty($bimbingans)) {
                            $rekomendasi = 'null';
                        } else {
                            $rekomendasi = Daftar::find($daftars->id)->bimbingan()->sum('rekomendasi');
                        }
                    }
                }
                $datas = array(
                    'title' => $this->title,
                    'user' => $users,
                    'profil' => $profils,
                    'count' => $counts,
                    'userall' => $userall,
                    'informasi' => $informasi,
                    'proposal' => $proposals,
                    'approvalcount' => $approvalcount,
                    'rekomendasi' => $rekomendasi,
                    'jadwalsempro' => $jadwalsempro,
                    'jadwalsemhas' => $jadwalsemhas,
                    'jadwalujian' => $jadwalujian,
                    'hasil' => $hasils,
                    'menu' => 'Dashboard',
                    'menu2' => 'Home Dashboard'
                );
            }
        } else {
            $informasi = $this->allInformasi();
            $this->setTitle("Mahasiswa Dashboard");
            $this->id = $idinformasi;
            $userall = User::with('mahasiswa')->where_role(3)->order_by('created_at', 'desc')->take(10)->get();
            // ----- Get Mahasiswa Data Sesuai ID ----- //
            $users = User::find(Auth::user()->id)->mahasiswa()->first();
            // ----- Get Profil Data Sesuai ID ----- //
            $profils = User::find(Auth::user()->id)->profil()->first();
            $counts = User::find(Auth::user()->id)->profil()->count();
            $detailinformasi = Informasi::find($this->id);
            $proposal = Mahasiswa::find($users->id)->proposal()->first();
            if (empty($proposal)) {
                $proposals = 'null';
                $approvalcount = 'null';
                $rekomendasi = 'null';
                $hasils = 'null';
                $jadwalsempro = 'null';
                $jadwalsemhas = 'null';
                $jadwalujian = 'null';
            } else {
                $proposals = $proposal;
                $approval = Proposal::find($proposal->id)->pembimbing()->sum('approval');
                if (empty($approval) || $approval == 0) {
                    $approvalcount = 'null';
                } else {
                    $approvalcount = $approval;
                }
                $daftars = Proposal::find($proposal->id)->daftar()->first();
                if (empty($daftars)) {
                    $rekomendasi = 'null';
                    $jadwalsempro = 'null';
                    $jadwalsemhas = 'null';
                    $jadwalujian = 'null';
                    $hasils = 'null';
                } else {
                    $jadwalsempro = Jadwalsempro::where_daftar_id($daftars->id)->order_by('tanggal', 'desc')->first();
                    $jadwalsemhas = Jadwalsemhas::where_daftar_id($daftars->id)->order_by('tanggal', 'desc')->first();
                    $jadwalujian = Jadwalujian::where_daftar_id($daftars->id)->order_by('tanggal', 'desc')->first();
                    $hasil = Daftar::find($daftars->id)->hasil()->first();
                    if (empty($hasil)) {
                        $hasils = 'null';
                    } else {
                        $hasils = $hasil;
                    }
                    $bimbingans = Daftar::find($daftars->id)->bimbingan()->get();
                    if (empty($bimbingans)) {
                        $rekomendasi = 'null';
                    } else {
                        $rekomendasi = Daftar::find($daftars->id)->bimbingan()->sum('rekomendasi');
                    }
                }
            }
            $datas = array(
                'title' => $this->title,
                'user' => $users,
                'profil' => $profils,
                'count' => $counts,
                'userall' => $userall,
                'informasi' => $informasi,
                'detailinformasi' => $detailinformasi,
                'proposal' => $proposals,
                'approvalcount' => $approvalcount,
                'rekomendasi' => $rekomendasi,
                'jadwalsempro' => $jadwalsempro,
                'jadwalsemhas' => $jadwalsemhas,
                'jadwalujian' => $jadwalujian,
                'hasil' => $hasils,
                'menu' => 'Dashboard',
                'menu2' => 'Home Dashboard'
            );
        }
        return View::make('mahasiswa.home', $datas);
    }

    protected function get_downloadfileinformasi($file) {
        $this->id = Crypter::decrypt($file);
        return Response::download('public/uploads/berkas/informasi/' . $this->id);
    }

    // ----- Tampilkan Halaman Profil Mahasiswa ----- //
    protected function get_detailprofil($idmahasiswa) {
        $this->setTitle("Profil Mahasiswa");
        $this->id = Crypter::decrypt($idmahasiswa);
        // ----- Get Mahasiswa Data Sesuai ID ----- //
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID ----- //
        $profils = User::find(Auth::user()->id)->profil()->first();
        $user_mahasiswa = User::find($this->id)->mahasiswa()->first();
        $mahasiswas = Mahasiswa::find($user_mahasiswa->id);
        $mahasiswaprofils = User::find($this->id)->profil()->first();
        $datas = array(
            'title' => $this->title,
            'user' => $users,
            'profil' => $profils,
            'mahasiswa' => $mahasiswas,
            'mahasiswaprofil' => $mahasiswaprofils,
            'menu' => 'Dashboard',
            'menu2' => 'Profil Mahasiswa'
        );
        return View::make('mahasiswa.spesifik.mahasiswa_detail', $datas);
    }

    // ----- Tampilkan Halaman TA Terdaftar ----- //
    protected function get_TAterdaftar() {
        $this->setTitle("Judul TA Terdaftar");
        // ----- Get Mahasiswa Data Sesuai ID ----- //
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID ----- //
        $profils = User::find(Auth::user()->id)->profil()->first();
        // ----- Get Proposal Data ----- //
        $proposals = Proposal::all();
        $datas = array(
            'title' => $this->title,
            'user' => $users,
            'profil' => $profils,
            'proposals' => $proposals,
            'menu' => 'Proposal',
            'menu2' => 'Judul Terdaftar'
        );
        return View::make('mahasiswa.judul_terdaftar', $datas);
    }

    // ----- Tampilkan Halaman Manage Proposal ----- //
    protected function get_addproposal() {
        $this->setTitle("Manage Proposal");
        // ----- Get Mahasiswa Data Sesuai ID ----- //
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID ----- //
        $profils = User::find(Auth::user()->id)->profil()->first();
        // ----- Get Proposal Data Sesuai ID ----- //
        $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
        $proposals = Mahasiswa::find($finds->id)->proposal()->first();
        $datas = array(
            'title' => $this->title,
            'user' => $users,
            'profil' => $profils,
            'proposal' => $proposals,
            'menu' => 'Proposal',
            'menu2' => 'Manage Proposal'
        );
        return View::make('mahasiswa.proposal', $datas);
    }

    // ----- Tambah Proposal -----
    protected function post_addproposal() {
        // ----- Get Input Data -----
        $rules = array(
            'dokumen' => 'mimes:doc,zip,docx,word'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->passes()) {
            $nims = Input::get('nim');
            $juduls = Str::title(Input::get('judul'));
            $deskripsis = Str::title(Input::get('deskripsi'));
            $tahuns = Input::get('tahun');
            $filenames = Auth::user()->username;
            $namadokumens = Auth::user()->username . '-proposal.' . File::extension(Input::file('dokumen.name'));
            // ----- Create Proposal -----
            $proposals = new Proposal;
            $proposals->nim = $nims;
            $proposals->judul = $juduls;
            $proposals->deskripsi = $deskripsis;
            $proposals->tahun = $tahuns;
            $proposals->dokumen = $namadokumens;
            // ----- Insert Proposal Data -> Proposal Table -----
            $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
            $finds->proposal()->insert($proposals);
            // ----- Upload File Dokumen -> Folder public/uploads/...
            Input::upload('dokumen', 'public/uploads/' . $filenames . '/proposal/', $namadokumens);
            return Redirect::back()->with('message', 'Proposal Judul Tugas Akhir Berhasil Ditambahkan');
        } else {
            return Redirect::back()->with_input()->with_errors($validation);
        }
    }

    // ----- Tampilkan Halaman Detail Status Proposal -----
    protected function get_statusproposal($key) {
        $this->setTitle("Status Dan Detail Proposal Judul TA");
        // ----- Get Mahasiswa Data Sesuai ID -----
        $user_mahasiswa_byid = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID -----
        $user_profil_byid = User::find(Auth::user()->id)->profil()->first();
        // ----- Decrypt Process -----
        $this->id = Crypter::decrypt($key);
        // ----- Get Proposal Data Sesuai ID -----
        $proposal_byid = Proposal::find($this->id);
        $proposal_mahasiswa_byid = Proposal::find($this->id)->mahasiswa()->first();
        $user_byid = User::find($proposal_mahasiswa_byid->user_id);
        $get_proposal_daftar = Proposal::find($this->id)->daftar()->first();
        $get_profil = Proposal::with('mahasiswa', 'mahasiswa.user', 'user.profil')->where_id($this->id)->first();
        $proposal_pembimbing_byid_approvalcount = Proposal::find($this->id)->pembimbing()->sum('approval');
        $proposal_pembimbing_byid_count = Proposal::find($this->id)->pembimbing()->count();
        if ($proposal_pembimbing_byid_count != 0) {
            $proposal_pembimbing_byid_first = Proposal::find($this->id)->pembimbing()->order_by('created_at', 'asc')->take(1)->get();
            $proposal_pembimbing_byid_second = Proposal::find($this->id)->pembimbing()->order_by('created_at', 'desc')->take(1)->get();
            foreach ($proposal_pembimbing_byid_first as $pembimbing_byid) {
                $namadepan = Pembimbing::find($pembimbing_byid->id)->dosen->namadepan;
                $namabelakang = Pembimbing::find($pembimbing_byid->id)->dosen->namabelakang;
                $fullname_first_dosen = $namadepan . ' ' . $namabelakang;
                $nip_dosen_first = Dosen::find(Pembimbing::find($pembimbing_byid->id)->dosen->id)->user->username;
                $catatan_dosen_first = Pembimbing::find($pembimbing_byid->id)->catatan;
                $proposal_approval_first = Pembimbing::find($pembimbing_byid->id)->approval;
            }
            foreach ($proposal_pembimbing_byid_second as $pembimbing_byid) {
                $namadepan = Pembimbing::find($pembimbing_byid->id)->dosen->namadepan;
                $namabelakang = pembimbing::find($pembimbing_byid->id)->dosen->namabelakang;
                $fullname_second_dosen = $namadepan . ' ' . $namabelakang;
                $nip_dosen_second = Dosen::find(pembimbing::find($pembimbing_byid->id)->dosen->id)->user->username;
                $catatan_dosen_second = pembimbing::find($pembimbing_byid->id)->catatan;
                $proposal_approval_second = pembimbing::find($pembimbing_byid->id)->approval;
            }
            $dosen_array = array(
                'fullnamedosen1' => $fullname_first_dosen,
                'fullnamedosen2' => $fullname_second_dosen,
                'nipdosen1' => $nip_dosen_first,
                'nipdosen2' => $nip_dosen_second,
                'catatandosen1' => $catatan_dosen_first,
                'catatandosen2' => $catatan_dosen_second,
                'approval1' => $proposal_approval_first,
                'approval2' => $proposal_approval_second
            );
            $datas = array(
                'title' => $this->title,
                'user' => $user_mahasiswa_byid,
                'profil' => $user_profil_byid,
                'proposal' => $proposal_byid,
                'mahasiswausers' => $user_byid,
                'datadaftar' => $get_proposal_daftar,
                'countpembimbingapp' => $proposal_pembimbing_byid_approvalcount,
                'countpembimbing' => $proposal_pembimbing_byid_count,
                'profiluser' => $get_profil,
                'menu' => 'Proposal',
                'menu2' => 'Detail',
                'dosenarray' => $dosen_array
            );
        } else {
            $datas = array(
                'title' => $this->title,
                'user' => $user_mahasiswa_byid,
                'profil' => $user_profil_byid,
                'proposal' => $proposal_byid,
                'mahasiswausers' => $user_byid,
                'datadaftar' => $get_proposal_daftar,
                'countpembimbingapp' => $proposal_pembimbing_byid_approvalcount,
                'countpembimbing' => $proposal_pembimbing_byid_count,
                'profiluser' => $get_profil,
                'menu' => 'Proposal',
                'menu2' => 'Detail'
            );
        }
        return View::make('mahasiswa.spesifik.status_detailproposal', $datas);
    }

    // ----- Donwnload File Proposal -----
    protected function get_downloadproposal($key) {
        // ----- Decrypt Process -----
        $this->id = Crypter::decrypt($key);
        // ----- Return Response Download -----
        return Response::download('public/uploads/' . Auth::user()->username . '/proposal/' . $this->id);
    }

    // ----- Update File Proposal -----
    protected function put_updateproposal() {
        $rules = array(
            'fileproposal' => 'mimes:doc,zip,docx,word'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->passes()) {
            // ----- Get Input Data -----
            $idproposal = Input::get('idproposal');
            $passuser = Input::get('password');
            $filenames = Auth::user()->username;
            $namadokumens = Auth::user()->username . '-proposal.' . File::extension(Input::file('fileproposal.name'));
            if (Hash::check($passuser, Auth::user()->password)) {
                $user = User::find(Auth::user()->id)->mahasiswa()->first();
                $proposal = Mahasiswa::find($user->id)->proposal()->first();
                $getnamafile = $proposal->dokumen;
                File::delete('public/uploads/' . $filenames . '/proposal/' . $getnamafile);
                Proposal::update($idproposal, array(
                    'dokumen' => $namadokumens
                ));
                Input::upload('fileproposal', 'public/uploads/' . $filenames . '/proposal/', $namadokumens);
                return Redirect::back()->with('message', 'File Proposal Judul Tugas Akhir Anda Berhasil Diupdate');
            } else {
                return Redirect::back()->with('message', 'Maaf Password yang Anda Masukkan Salah, Apakah Anda <a href="" data-target="#lupapassword" data-toggle="modal" rel="tooltip" data-placement="top" title="Tampilkan Form Lupa Password">Lupa Password</a> Anda ?');
            }
        } else {
            return Redirect::back()->with_input()->with_errors($validation);
        }
    }

    // ----- Delete Proposal -----
    protected function get_deleteproposal($key) {
        // ----- Decrypt Process -----
        $this->id = Crypter::decrypt($key);
        // ----- Hapus Proposal Sesuai ID -----
        $get_dataproposal = Proposal::find($this->id);
        $getnim = $get_dataproposal->nim;
        $getnamafile = $get_dataproposal->dokumen;
        File::delete('public/uploads/' . $getnim . '/proposal/' . $getnamafile);
        Proposal::find($this->id)->delete();
        return Redirect::back()->with('message', 'Proposal Judul Tugas Akhir Berhasil Dihapus, Silahkan Menambahkan Proposal Judul Tugas Akhir Kembali');
    }

    // ----- Tampilkan Halaman Dosen Pembimbing -----
    protected function get_adddosen() {
        $this->setTitle("Dosen Pembimbing");
        // ----- Get Mahasiswa Data Sesuai ID -----
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID -----
        $profils = User::find(Auth::user()->id)->profil()->first();
        // ----- Get Proposal Data Sesuai ID -----
        $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
        $proposals = Mahasiswa::find($finds->id)->proposal()->first();
        // ----- Get Dosen Data -----
        $dosens = Dosen::with('user', 'user.profil')->get();
        $datas = array(
            'title' => $this->title,
            'user' => $users,
            'profil' => $profils,
            'proposal' => $proposals,
            'dosens' => $dosens,
            'menu' => 'Proposal',
            'menu2' => 'Dosen Pembimbing'
        );
        return View::make('mahasiswa.pembimbing', $datas);
    }

    // ----- Tampilkan Halaman Detail Dosen Pembimbing -----
    protected function get_detaildosen($key) {
        $this->setTitle("Profil Dosen Pembimbing");
        // ----- Get Mahasiswa Data Sesuai ID -----
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID -----
        $profils = User::find(Auth::user()->id)->profil()->first();
        // ----- Get Proposal Data Sesuai ID -----
        $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
        $proposals = Mahasiswa::find($finds->id)->proposal()->first();
        // ----- Decrypt Process -----
        $this->id = Crypter::decrypt($key);
        $dosens = Dosen::find($this->id);
        // ----- Get Data From Relation Table -----
        $dosenuser = Dosen::find($this->id)->user()->first()->id;
        $dosenprofils = User::find($dosenuser)->profil()->first();
        if (!empty($proposals)) {
            // ----- Count Pengampu Data -----
            $pembimbingcount = Pembimbing::where_proposal_id($proposals->id)->count();
            $pembimbing_condition = Pembimbing::where_proposal_id_and_dosen_id($proposals->id, $this->id)->first();
            if (empty($pembimbing_condition)) {
                $pbb_terpilih = 0;
            } else {
                $pbb_terpilih = 1;
            }
        } else {
            $pbb_terpilih = 0;
            $pembimbingcount = 0;
        }
        $datas = array(
            'title' => $this->title,
            'user' => $users,
            'profil' => $profils,
            'proposal' => $proposals,
            'dosens' => $dosens,
            'dosenprofils' => $dosenprofils,
            'pembimbingcount' => $pembimbingcount,
            'pembimbingterpilih' => $pbb_terpilih,
            'menu' => 'Proposal',
            'menu2' => 'Dosen Pembimbing'
        );
        return View::make('mahasiswa.spesifik.detail_dosen', $datas);
    }

    // ----- Tambah Dosen Pembimbing -----
    protected function post_adddosen() {
        $idproposals = Input::get('idproposal');
        $iddosens = Input::get('iddosen');
        $finddosennamas = Dosen::find($iddosens);
        $dosennamas = $finddosennamas->namadepan . ' ' . $finddosennamas->namabelakang;
        $pembimbings = new Pembimbing;
        $pembimbings->dosen_id = $iddosens;
        $pembimbings->dosenname = $dosennamas;
        $pembimbings->approval = 0;
        Proposal::find($idproposals)->pembimbing()->insert($pembimbings);
        return Redirect::back()->with('message', 'Dosen Berhasil Ditambahkan Menjadi Dosen Pembimbing');
    }

    // ----- Tampilkan Halaman Daftar Sempro -----
    protected function get_daftarsempro() {
        $this->setTitle("Daftar Seminar Proposal");
        // ----- Get Mahasiswa Data Sesuai ID ----- //
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID ----- //
        $profils = User::find(Auth::user()->id)->profil()->first();
        // ----- Get Proposal Data Sesuai ID ----- //
        $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
        $proposals = Mahasiswa::find($finds->id)->proposal()->first();
        if (!empty($proposals)) {
            $proposal_pembimbing_byid_approvalcount = Proposal::find($proposals->id)->pembimbing()->sum('approval');
            $get_proposal_daftar = Proposal::find($proposals->id)->daftar()->first();
            $get_berkas_all = Berkas::where_kategori(1)->get();
            $datas = array(
                'title' => $this->title,
                'user' => $users,
                'profil' => $profils,
                'proposal' => $proposals,
                'countpembimbingapp' => $proposal_pembimbing_byid_approvalcount,
                'datadaftar' => $get_proposal_daftar,
                'berkasall' => $get_berkas_all,
                'menu' => 'Daftar',
                'menu2' => 'Daftar Seminar Proposal'
            );
        } else {
            $datas = array(
                'title' => $this->title,
                'user' => $users,
                'profil' => $profils,
                'proposal' => $proposals,
                'menu' => 'Daftar',
                'menu2' => 'Daftar Seminar Proposal'
            );
        }
        return View::make('mahasiswa.daftar_sempro', $datas);
    }

    // ----- Daftar Sempro -----
    protected function post_daftarsempro() {
        $idproposals = Input::get('idproposal');
        $nama = Input::get('nama');
        $judul = Input::get('judul');
        $kategori = Input::get('kategori');
        $cekdaftar = Input::get('cekdaftar');
        if (!empty($cekdaftar)) {
            $daftar = new Daftar;
            $daftar->nama = $nama;
            $daftar->judul = $judul;
            $daftar->kategori_sempro = $kategori;
            $findproposal = Proposal::find($idproposals);
            $findproposal->daftar()->insert($daftar);
            $finddaftar = Daftar::where_proposal_id($idproposals)->first();
            $bimbingan = new Bimbingan;
            $bimbingan->dosen_id = 0;
            $bimbingan->is_dosen = 1;
            $bimbingan->rekomendasi = 0;
            $finddaftar->bimbingan()->insert($bimbingan);
            $bimbingan = new Bimbingan;
            $bimbingan->dosen_id = 0;
            $bimbingan->is_dosen = 2;
            $bimbingan->rekomendasi = 0;
            $finddaftar->bimbingan()->insert($bimbingan);
            return Redirect::back()->with('message', 'Anda Telah Terdaftar Pada Seminar Proposal. Silahkan Anda Melihat Jadwal Seminar Proposal Pada Menu Jadwal Seminar Proposal');
        } else {
            return Redirect::back()->with('message', 'Maaf Pernyataan Belum Di Ceklist');
        }
    }

    // ----- Tampilkan Halaman Daftar Semhas Dan Ujian -----
    protected function get_daftarsemhas_ujian() {
        $this->setTitle("Daftar Seminar Hasil Dan Ujian");
        // ----- Get Mahasiswa Data Sesuai ID ----- //
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID ----- //
        $profils = User::find(Auth::user()->id)->profil()->first();
        // ----- Get Proposal Data Sesuai ID ----- //
        $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
        $proposals = Mahasiswa::find($finds->id)->proposal()->first();
        if (!empty($proposals)) {
            $cekdaftar = Proposal::find($proposals->id)->daftar()->first();
            if (!empty($cekdaftar)) {
                $get_proposal_daftar_sempro = Proposal::find($proposals->id)->daftar()->first();
                $get_proposal_daftar_semhas = Proposal::find($proposals->id)->daftar()->where_kategori_semhas_and_kategori_ujian(1, 1)->count();
                if (empty($get_proposal_daftar_sempro)) {
                    $datas = array(
                        'title' => $this->title,
                        'user' => $users,
                        'profil' => $profils,
                        'proposal' => $proposals,
                        'datadaftarsempro' => $get_proposal_daftar_sempro,
                        'datadaftarsemhasujian' => $get_proposal_daftar_semhas,
                        'menu' => 'Daftar',
                        'menu2' => 'Daftar Seminar Hasil & Ujian TA'
                    );
                } else {
                    $get_daftar_hasil = Daftar::find($get_proposal_daftar_sempro->id)->hasil()->first();
                    $get_berkas_all = Berkas::where_kategori(1)->get();
                    $jmlrekomendasi = Daftar::find($get_proposal_daftar_sempro->id)->bimbingan()->sum('rekomendasi');
                    $datas = array(
                        'title' => $this->title,
                        'user' => $users,
                        'profil' => $profils,
                        'proposal' => $proposals,
                        'datadaftarsempro' => $get_proposal_daftar_sempro,
                        'datadaftarsemhasujian' => $get_proposal_daftar_semhas,
                        'datahasil' => $get_daftar_hasil,
                        'berkasall' => $get_berkas_all,
                        'jmlrekom' => $jmlrekomendasi,
                        'menu' => 'Daftar',
                        'menu2' => 'Daftar Seminar Hasil & Ujian TA'
                    );
                }
            } else {
                $datas = array(
                    'title' => $this->title,
                    'user' => $users,
                    'profil' => $profils,
                    'proposal' => $proposals,
                    'menu' => 'Daftar',
                    'menu2' => 'Daftar Seminar Hasil & Ujian TA'
                );
            }
        } else {
            $datas = array(
                'title' => $this->title,
                'user' => $users,
                'profil' => $profils,
                'proposal' => $proposals,
                'menu' => 'Daftar',
                'menu2' => 'Daftar Seminar Hasil & Ujian TA'
            );
        }
        return View::make('mahasiswa.daftar_semhas_ujian', $datas);
    }

    // ----- Donwnload File Berkas Persyaratan -----
    protected function get_downloadberkas($id, $file) {
        // ----- Decrypt Process -----
        $this->id = Crypter::decrypt($id);
        $file = $file;
        // ----- Return Response Download -----
        if ($this->id == 1) {
            return Response::download('public/uploads/berkas/semhas&ujian/' . $file);
        }
    }

    // ----- Daftar Semhas Dan Ujian -----
    protected function put_daftarsemhas_ujian() {
        $iddaftar = Input::get('iddaftar');
        $kategori = Input::get('kategori');
        $cekdaftar = Input::get('cekdaftar');
        if (!empty($cekdaftar)) {
            $filesyarat = Input::get('filesyarat');
            if (!empty($filesyarat)) {
                $rules = array(
                    'filesyarat' => 'mimes:zip'
                );
                $validation = Validator::make(Input::all(), $rules);
                if ($validation->passes()) {
                    $filenames = Auth::user()->username;
                    // ----- Get Mahasiswa Data Sesuai ID -----
                    $users = User::find(Auth::user()->id)->mahasiswa()->first();
                    $namadokumens = $users->namadepan . '-' . $users->namabelakang . '-berkas-pendaftaran-semhas-ujian.' . File::extension(Input::file('filesyarat.name'));
                    Daftar::update($iddaftar, array(
                        'kategori_semhas' => $kategori,
                        'kategori_ujian' => $kategori,
                        'file_semhas_ujian' => $namadokumens
                    ));
                    // ----- Upload File Dokumen -> Folder public/uploads/...
                    Input::upload('filesyarat', 'public/uploads/' . $filenames . '/semhasujian/', $namadokumens);
                    return Redirect::back()->with('message', 'Anda Telah Terdaftar Pada Seminar Hasil Dan Ujian TA. Silahkan Melihat Jadwal Pada Sub Menu Jadwal Seminar Hasil Dan Jadwal Ujian TA');
                } else {
                    return Redirect::back()->with_input()->with_errors($validation);
                }
            } else {
                Daftar::update($iddaftar, array(
                    'kategori_semhas' => $kategori,
                    'kategori_ujian' => $kategori,
                ));
                return Redirect::back()->with('message', 'Anda Telah Terdaftar Pada Seminar Hasil Dan Ujian TA. Silahkan Melihat Jadwal Pada Sub Menu Jadwal Seminar Hasil Dan Jadwal Ujian TA');
            }
        } else {
            return Redirect::back()->with('message', 'Maaf Pernyataan Belum Di Ceklist');
        }
    }

    protected function get_bimbingan() {
        $this->setTitle("Bimbingan Tugas Akhir");
        // ----- Get Mahasiswa Data Sesuai ID ----- //
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID ----- //
        $profils = User::find(Auth::user()->id)->profil()->first();
        // ----- Get Proposal Data Sesuai ID ----- //
        $proposal = Mahasiswa::find($users->id)->proposal()->first();
        if (!empty($proposal)) {
            $daftar = Proposal::find($proposal->id)->daftar()->first();
            if (!empty($daftar)) {
                $bimbingan = Daftar::find($daftar->id)->bimbingan()->get();
                if (empty($bimbingan)) {
                    $pembimbing1 = 'null';
                    $pembimbing2 = 'null';
                    $asistensipembimbing1 = 'null';
                    $asistensipembimbing2 = 'null';
                } else {
                    $pembimbing1 = Bimbingan::with('daftar', 'dosen')->where_daftar_id_and_is_dosen($daftar->id, 1)->first();
                    $asistensipembimbing1 = Bimbingan::find($pembimbing1->id)->asistensi()->get();
                    if (empty($asistensipembimbing1)) {
                        $asistensipembimbing1 = 'null';
                    } else {
                        $asistensipembimbing1 = Bimbingan::find($pembimbing1->id)->asistensi()->get();
                    }
                    $pembimbing2 = Bimbingan::with('daftar', 'dosen')->where_daftar_id_and_is_dosen($daftar->id, 2)->first();
                    $asistensipembimbing2 = Bimbingan::find($pembimbing2->id)->asistensi()->get();
                    if (empty($asistensipembimbing2)) {
                        $asistensipembimbing2 = 'null';
                    } else {
                        $asistensipembimbing2 = Bimbingan::find($pembimbing2->id)->asistensi()->get();
                    }
                    $jmlrekomendasi = Daftar::find($daftar->id)->bimbingan()->sum('rekomendasi');
                    $suratkeputusan = Daftar::find($daftar->id)->suratkeputusan()->first();
                    if (empty($suratkeputusan)) {
                        $suratkeputusan = 'null';
                        $sisawaktu = 'null';
                    } else {
                        $suratkeputusan = Daftar::find($daftar->id)->suratkeputusan()->first();
                        $datea = strtotime(date("Y-m-d", strtotime($suratkeputusan->akhirtanggal)));
                        $remaining = $datea - time();
                        $days_remaining = floor($remaining / 86400) + 1;
                        if ($days_remaining < 0) {
                            $sisawaktu = "Selesai";
                        } else {
                            if ($days_remaining == 0) {
                                $sisawaktu = "Hari Ini";
                            } else {
                                $sisawaktu = "$days_remaining Hari Lagi";
                            }
                        }
                    }
                }
            } else {
                $daftar = 'belumdaftar';
                $pembimbing1 = 'null';
                $pembimbing2 = 'null';
                $jmlrekomendasi = 'null';
                $suratkeputusan = 'null';
                $sisawaktu = 'null';
                $asistensipembimbing1 = 'null';
                $asistensipembimbing2 = 'null';
            }
        } else {
            $daftar = 'belumtambahproposal';
            $pembimbing1 = 'null';
            $pembimbing2 = 'null';
            $jmlrekomendasi = 'null';
            $suratkeputusan = 'null';
            $sisawaktu = 'null';
            $asistensipembimbing1 = 'null';
            $asistensipembimbing2 = 'null';
        }
        $datas = array(
            'title' => $this->title,
            'user' => $users,
            'profil' => $profils,
            'daftar' => $daftar,
            'pembimbing1' => $pembimbing1,
            'pembimbing2' => $pembimbing2,
            'jmlrekom' => $jmlrekomendasi,
            'srtkeputusan' => $suratkeputusan,
            'sisawaktu' => $sisawaktu,
            'asspembimbing1' => $asistensipembimbing1,
            'asspembimbing2' => $asistensipembimbing2,
            'menu' => 'Bimbingan',
            'menu2' => 'Asistensi Bimbingan'
        );
        return View::make('mahasiswa.bimbingan', $datas);
    }

    // ----- Tampilkan Halaman Jadwal Sempro -----
    protected function get_jadwalsempro() {
        $this->setTitle("Jadwal Seminar Proposal");
        // ----- Get Mahasiswa Data Sesuai ID ----- //
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID ----- //
        $profils = User::find(Auth::user()->id)->profil()->first();
        $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
        $proposals = Mahasiswa::find($finds->id)->proposal()->first();
        if (!empty($proposals)) {
            $daftars = Proposal::find($proposals->id)->daftar()->first();
            if (!empty($daftars)) {
                $jadwals = Daftar::find($daftars->id)->jadwalsempro()->first();
                if (!empty($jadwals)) {
                    $tanggal = $jadwals->tanggal;
                    $waktu = $jadwals->waktu;
                    $ruang = $jadwals->ruang;
                    $jadwal_allrelation = Jadwalsempro::with('daftar', 'daftar.proposal')->where_tanggal_and_waktu_and_ruang($tanggal, $waktu, $ruang)->get();
                    // ----- Sisa Waktu -----
                    $date = date("Y-m-d");
                    $datea = strtotime(date("Y-m-d", strtotime($jadwals->waktu)));
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
                    $datas = array(
                        'title' => $this->title,
                        'user' => $users,
                        'profil' => $profils,
                        'proposal' => $proposals,
                        'daftar' => $daftars,
                        'jadwal' => $jadwals,
                        'sisawaktu' => $lefttime,
                        'waktu' => $days_remaining,
                        'allsaturuang' => $jadwal_allrelation,
                        'menu' => 'Jadwal',
                        'menu2' => 'Jadwal Seminar Proposal'
                    );
                } else {
                    $datas = array(
                        'title' => $this->title,
                        'user' => $users,
                        'profil' => $profils,
                        'proposal' => $proposals,
                        'daftar' => $daftars,
                        'jadwal' => $jadwals,
                        'menu' => 'Jadwal',
                        'menu2' => 'Jadwal Seminar Proposal'
                    );
                }
            } else {
                $datas = array(
                    'title' => $this->title,
                    'user' => $users,
                    'profil' => $profils,
                    'proposal' => $proposals,
                    'daftar' => $daftars,
                    'menu' => 'Jadwal',
                    'menu2' => 'Jadwal Seminar Proposal'
                );
            }
        } else {
            $datas = array(
                'title' => $this->title,
                'user' => $users,
                'profil' => $profils,
                'proposal' => $proposals,
                'menu' => 'Jadwal',
                'menu2' => 'Jadwal Seminar Proposal'
            );
        }
        return View::make('mahasiswa.jadwal', $datas);
    }

    // ----- Tampilkan Halaman Jadwal Semhas -----
    protected function get_jadwalsemhas() {
        $this->setTitle("Jadwal Seminar Hasil");
        // ----- Get Mahasiswa Data Sesuai ID ----- //
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID ----- //
        $profils = User::find(Auth::user()->id)->profil()->first();
        $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
        $proposals = Mahasiswa::find($finds->id)->proposal()->first();
        if (!empty($proposals)) {
            $daftars = Proposal::find($proposals->id)->daftar()->first();
            if (!empty($daftars)) {
                $jadwals = Daftar::find($daftars->id)->jadwalsemhas()->first();
                if (!empty($jadwals)) {
                    $tanggal = $jadwals->tanggal;
                    $waktu = $jadwals->waktu;
                    $ruang = $jadwals->ruang;
                    $jadwal_allrelation = Jadwalsemhas::with('daftar', 'daftar.proposal')->where_tanggal_and_waktu_and_ruang($tanggal, $waktu, $ruang)->get();
                    // ----- Sisa Waktu -----
                    $date = date("Y-m-d");
                    $datea = strtotime(date("Y-m-d", strtotime($jadwals->waktu)));
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
                    $datas = array(
                        'title' => $this->title,
                        'user' => $users,
                        'profil' => $profils,
                        'proposal' => $proposals,
                        'daftar' => $daftars,
                        'jadwal' => $jadwals,
                        'sisawaktu' => $lefttime,
                        'lefttime' => $days_remaining,
                        'allsaturuang' => $jadwal_allrelation,
                        'menu' => 'Jadwal',
                        'menu2' => 'Jadwal Seminar Hasil'
                    );
                } else {
                    $datas = array(
                        'title' => $this->title,
                        'user' => $users,
                        'profil' => $profils,
                        'proposal' => $proposals,
                        'daftar' => $daftars,
                        'jadwal' => $jadwals,
                        'menu' => 'Jadwal',
                        'menu2' => 'Jadwal Seminar Hasil'
                    );
                }
            } else {
                $datas = array(
                    'title' => $this->title,
                    'user' => $users,
                    'profil' => $profils,
                    'proposal' => $proposals,
                    'menu' => 'Jadwal',
                    'menu2' => 'Jadwal Seminar Hasil'
                );
            }
        } else {
            $datas = array(
                'title' => $this->title,
                'user' => $users,
                'profil' => $profils,
                'proposal' => $proposals,
                'menu' => 'Jadwal',
                'menu2' => 'Jadwal Seminar Hasil'
            );
        }
        return View::make('mahasiswa.jadwal', $datas);
    }

    // ----- Tampilkan Halaman Jadwal Ujian -----
    protected function get_jadwalujian() {
        $this->setTitle("Jadwal Ujian TA");
        // ----- Get Mahasiswa Data Sesuai ID ----- //
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID ----- //
        $profils = User::find(Auth::user()->id)->profil()->first();
        $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
        $proposals = Mahasiswa::find($finds->id)->proposal()->first();
        if (!empty($proposals)) {
            $daftars = Proposal::find($proposals->id)->daftar()->first();
            if (!empty($daftars)) {
                $jadwals = Daftar::find($daftars->id)->jadwalujian()->first();
                if (!empty($jadwals)) {
                    $tanggal = $jadwals->tanggal;
                    $waktu = $jadwals->waktu;
                    $ruang = $jadwals->ruang;
                    $jadwal_allrelation = Jadwalujian::with('daftar', 'daftar.proposal')->where_tanggal_and_waktu_and_ruang($tanggal, $waktu, $ruang)->get();
                    // ----- Sisa Waktu -----
                    $date = date("Y-m-d");
                    $datea = strtotime(date("Y-m-d", strtotime($jadwals->waktu)));
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
                    $datas = array(
                        'title' => $this->title,
                        'user' => $users,
                        'profil' => $profils,
                        'proposal' => $proposals,
                        'daftar' => $daftars,
                        'jadwal' => $jadwals,
                        'sisawaktu' => $lefttime,
                        'lefttime' => $days_remaining,
                        'allsaturuang' => $jadwal_allrelation,
                        'menu' => 'Jadwal',
                        'menu2' => 'Jadwal Ujian TA'
                    );
                } else {
                    $datas = array(
                        'title' => $this->title,
                        'user' => $users,
                        'profil' => $profils,
                        'proposal' => $proposals,
                        'daftar' => $daftars,
                        'jadwal' => $jadwals,
                        'menu' => 'Jadwal',
                        'menu2' => 'Jadwal Ujian TA'
                    );
                }
            } else {
                $datas = array(
                    'title' => $this->title,
                    'user' => $users,
                    'profil' => $profils,
                    'proposal' => $proposals,
                    'menu' => 'Jadwal',
                    'menu2' => 'Jadwal Ujian TA'
                );
            }
        } else {
            $datas = array(
                'title' => $this->title,
                'user' => $users,
                'profil' => $profils,
                'proposal' => $proposals,
                'menu' => 'Jadwal',
                'menu2' => 'Jadwal Ujian TA'
            );
        }
        return View::make('mahasiswa.jadwal', $datas);
    }

    protected function get_printjadwal($kategori, $id) {

        return View::make('print_jadwal', $datas);
    }

    // ----- Tampilkan Halaman Hasil Sempro -----
    protected function get_hasilsempro() {
        $this->setTitle("Hasil Seminar Proposal");
        // ----- Get Mahasiswa Data Sesuai ID -----
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID -----
        $profils = User::find(Auth::user()->id)->profil()->first();
        $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
        $proposals = Mahasiswa::find($finds->id)->proposal()->first();
        if (!empty($proposals)) {
            $get_proposal_daftar_count = Proposal::find($proposals->id)->daftar()->where_kategori_sempro(1)->count();
            $get_proposal_daftar = Proposal::find($proposals->id)->daftar()->first();
            if (empty($get_proposal_daftar)) {
                $datas = array(
                    'title' => $this->title,
                    'user' => $users,
                    'profil' => $profils,
                    'proposal' => $proposals,
                    'daftar_count' => $get_proposal_daftar_count,
                    'datadaftar' => $get_proposal_daftar,
                    'menu' => 'Hasil',
                    'menu2' => 'Hasil Seminar Proposal'
                );
            } else {
                $get_daftar_hasil = Daftar::find($get_proposal_daftar->id)->hasil()->first();
                $datas = array(
                    'title' => $this->title,
                    'user' => $users,
                    'profil' => $profils,
                    'proposal' => $proposals,
                    'daftar_count' => $get_proposal_daftar_count,
                    'datadaftar' => $get_proposal_daftar,
                    'datahasil' => $get_daftar_hasil,
                    'menu' => 'Hasil',
                    'menu2' => 'Hasil Seminar Proposal'
                );
            }
        } else {
            $datas = array(
                'title' => $this->title,
                'user' => $users,
                'profil' => $profils,
                'proposal' => $proposals,
                'menu' => 'Hasil',
                'menu2' => 'Hasil Seminar Proposal'
            );
        }
        return View::make('mahasiswa.hasil', $datas);
    }

    // ----- Tampilkan Halaman Hasil Ujian -----
    protected function get_hasilujian() {
        $this->setTitle("Hasil Ujian TA");
        // ----- Get Mahasiswa Data Sesuai ID -----
        $users = User::find(Auth::user()->id)->mahasiswa()->first();
        // ----- Get Profil Data Sesuai ID -----
        $profils = User::find(Auth::user()->id)->profil()->first();
        $finds = Mahasiswa::where_user_id(Auth::user()->id)->first();
        $proposals = Mahasiswa::find($finds->id)->proposal()->first();
        if (!empty($proposals)) {
            $get_proposal_daftar_count = Proposal::find($proposals->id)->daftar()->where_kategori_ujian(1)->count();
            $get_proposal_daftar = Proposal::find($proposals->id)->daftar()->first();
            if (empty($get_proposal_daftar)) {
                $datas = array(
                    'title' => $this->title,
                    'user' => $users,
                    'profil' => $profils,
                    'proposal' => $proposals,
                    'daftar_count' => $get_proposal_daftar_count,
                    'datadaftar' => $get_proposal_daftar,
                    'menu' => 'Hasil',
                    'menu2' => 'Hasil Ujian TA'
                );
            } else {
                $get_daftar_hasil = Daftar::find($get_proposal_daftar->id)->hasil()->first();
                $datas = array(
                    'title' => $this->title,
                    'user' => $users,
                    'profil' => $profils,
                    'proposal' => $proposals,
                    'daftar_count' => $get_proposal_daftar_count,
                    'datadaftar' => $get_proposal_daftar,
                    'datahasil' => $get_daftar_hasil,
                    'menu' => 'Hasil',
                    'menu2' => 'Hasil Ujian TA'
                );
            }
        } else {
            $datas = array(
                'title' => $this->title,
                'user' => $users,
                'profil' => $profils,
                'proposal' => $proposals,
                'menu' => 'Hasil',
                'menu2' => 'Hasil Ujian TA'
            );
        }
        return View::make('mahasiswa.hasil', $datas);
    }

    protected function get_beginning($id) {
        $this->id = $id; //daftar_id
        try {
            $get_datadaftar = Daftar::find($this->id)->first();
            $proposal_id = $get_datadaftar->proposal_id;
            $get_dataproposal = Proposal::find($proposal_id)->first();
            $getnim = $get_dataproposal->nim;
            $getnamafile = $get_dataproposal->dokumen;
            File::delete('public/uploads/' . $getnim . '/proposal/' . $getnamafile);
            Proposal::find($proposal_id)->delete();
            Pembimbing::where_proposal_id($proposal_id)->delete();
            Jadwalsempro::where_daftar_id($this->id)->delete();
            Hasil::where_daftar_id($this->id)->delete();
            Daftar::find($this->id)->delete();
            return Redirect::to_route('mahasiswa')->with('message', 'Proposal Berhasil Dihapus Dan Anda Dapat Mengajukan Proposal Judul Baru. Tetap Semangat !!');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}