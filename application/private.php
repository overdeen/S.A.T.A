<?php

// ----- REGISTERING CONTROLLER ----- //
Route::controller(array('user', 'mahasiswa', 'dosen', 'admin', 'base'));

// ----- SEMUA USER ----- //
Route::get('/', function() {
            return Redirect::to_route('loginuser');
        });
Route::get('login', array('as' => 'loginuser', 'uses' => 'user@index'));
Route::post('login', array('before' => 'csrf', 'uses' => 'user@index'));
Route::get('registrasi', array('as' => 'registrasi', 'uses' => 'user@registrasi'));
Route::post('registrasi', array('before' => 'csrf', 'uses' => 'user@registrasi'));
// ----- User -> Profil Routing ----- //
Route::get('profil', array('as' => 'profil', 'uses' => 'user@profil'));
Route::put('profil/update', array('before' => 'csrf', 'uses' => 'user@profil'));
Route::put('profil/update/foto', array('before' => 'csrf', 'uses' => 'user@foto_profil'));
Route::put('profil/update/password', array('before' => 'csrf', 'uses' => 'user@password_profil'));
// ----- User -> Dosen -> Jadwal Bimbingan Routing -----
Route::put('profil/update/jadwalbimbingan', array('before' => 'csrf', 'uses' => 'user@jadwal_bimbingan'));
Route::post('lupa/password', array('before' => 'csrf', 'uses' => 'user@lupa_password'));
require 'postroute.php';
// ----- MAHASISWA ----- //
Route::get('mahasiswa', array('as' => 'mahasiswa', 'uses' => 'mahasiswa@dashboardmahasiswa'));
Route::get('mahasiswa/logout', array('as' => 'mahasiswalogout', 'uses' => 'mahasiswa@logoutmahasiswa'));
Route::group(array('before' => 'authmahasiswa'), function() {
            Route::get('informasi/view/(:num)/(:all)', array('as' => 'lihatinformasiTA', 'uses' => 'mahasiswa@dashboardmahasiswa'));
            Route::get('informasi/file/download/(:all)', array('as' => 'downloadfileinformasi', 'uses' => 'mahasiswa@downloadfileinformasi'));
            Route::get('detail/profil/(:all)', array('as' => 'detailprofilmahasiswa', 'uses' => 'mahasiswa@detailprofil'));
            // ----- Mahasiswa -> TA Terdaftar Routing ----- //
            Route::get('TAterdaftar', array('as' => 'TAterdaftar', 'uses' => 'mahasiswa@TAterdaftar'));
            // ----- Mahasiswa -> Proposal Routing ----- //
            Route::get('proposal', array('as' => 'proposalmahasiswa', 'uses' => 'mahasiswa@addproposal'));
            Route::post('proposal/add', array('before' => 'csrf', 'uses' => 'mahasiswa@addproposal'));
            Route::get('proposal/status/(:all)', array('as' => 'lihatstatus', 'uses' => 'mahasiswa@statusproposal'));
            Route::get('proposal/download/(:all)', array('as' => 'downloadproposal', 'uses' => 'mahasiswa@downloadproposal'));
            Route::put('proposal/update', array('before' => 'csrf', 'uses' => 'mahasiswa@updateproposal'));
            Route::get('proposal/delete/(:all)', array('as' => 'deleteproposal', 'uses' => 'mahasiswa@deleteproposal'));
            // ----- Mahasiswa -> Pembimbing Routing ----- //
            Route::get('pembimbing', array('as' => 'dosenpembimbing', 'uses' => 'mahasiswa@adddosen'));
            Route::post('pembimbing/add', array('before' => 'csrf', 'uses' => 'mahasiswa@adddosen'));
            Route::get('pembimbing/view/(:all)', array('as' => 'dosenpembimbingview', 'uses' => 'mahasiswa@detaildosen'));
            // ----- Mahasiswa -> Daftar Routing ----- //
            Route::get('daftar/sempro', array('as' => 'daftarsempro', 'uses' => 'mahasiswa@daftarsempro'));
            Route::post('daftar/sempro', array('before' => 'csrf', 'uses' => 'mahasiswa@daftarsempro'));
            Route::get('daftar/semhas_ujian', array('as' => 'daftarsemhasujian', 'uses' => 'mahasiswa@daftarsemhas_ujian'));
            Route::put('daftar/semhas_ujian', array('before' => 'csrf', 'uses' => 'mahasiswa@daftarsemhas_ujian'));
            Route::get('daftar/berkas/(:all)/(:all)', array('as' => 'downloadberkaspersyaratan', 'uses' => 'mahasiswa@downloadberkas'));
            // ----- Mahasiswa -> Bimbingan Routing ----- //  
            Route::get('bimbingan', array('as' => 'bimbingan', 'uses' => 'mahasiswa@bimbingan'));
            // ----- Mahasiswa -> Jadwal Routing ----- //
            Route::get('jadwal/sempro', array('as' => 'jadwalsempro', 'uses' => 'mahasiswa@jadwalsempro'));
            Route::get('jadwal/semhas', array('as' => 'jadwalsemhas', 'uses' => 'mahasiswa@jadwalsemhas'));
            Route::get('jadwal/ujian', array('as' => 'jadwalujian', 'uses' => 'mahasiswa@jadwalujian'));
            // ----- Mahasiswa -> Hasil Routing ----- //
            Route::get('hasil/sempro', array('as' => 'hasilsempro', 'uses' => 'mahasiswa@hasilsempro'));
            Route::get('hasil/ujian', array('as' => 'hasilujian', 'uses' => 'mahasiswa@hasilujian'));
            // ----- Mahasiswa -> Penngulangan Pengajuan Proposal Judul Routing ----- //
            Route::get('back/beginning/(:all)', array('as' => 'kembalikeawal', 'uses' => 'mahasiswa@beginning'));
        });


// ----- DOSEN ----- //
Route::get('dosen', array('as' => 'dosen', 'uses' => 'dosen@dashboarddosen'));
Route::get('dosen/logout', array('as' => 'dosenlogout', 'uses' => 'dosen@logoutdosen'));
Route::group(array('before' => 'authdosen'), function() {
            Route::get('informasi/(:num)/view/(:all)', array('as' => 'lihatinfodosen', 'uses' => 'dosen@dashboarddosen'));
            Route::get('informasi/download/file/(:all)', array('as' => 'downloadfileinformasidosen', 'uses' => 'dosen@downloadfileinformasi'));
            // ----- Dosen -> Detail Proposal Mahasiswa Routing ----- //
            Route::get('dosen/sempro/proposal/detail/(:all)', array('as' => 'lihatsemprodetailproposal', 'uses' => 'dosen@detailproposalmahasiswa'));
            Route::get('dosen/proposal/(:all)/download/(:all)', array('as' => 'proposaldetaildownload', 'uses' => 'dosen@proposaldetail_download'));
            // ----- Dosen -> Approval Routing ----- //
            Route::get('dosen/approval', array('as' => 'approval', 'uses' => 'dosen@approval'));
            Route::get('dosen/approval/proposal/view/(:all)/(:all)', array('as' => 'proposalview', 'uses' => 'dosen@detailproposal'));
            Route::get('dosen/approval/proposal/download/(:all)/(:all)', array('as' => 'downloadapprovalproposal', 'uses' => 'dosen@downloadproposal'));
            Route::put('dosen/approval/proposal/update', array('before' => 'csrf', 'uses' => 'dosen@approvalproposal'));
            // ----- Dosen -> Jadwal Penguji Routing ----- //
            Route::get('dosen/jadwalpenguji/sempro', array('as' => 'jadwalpengujisempro', 'uses' => 'dosen@jadwalpengujisempro'));
            Route::get('dosen/jadwalpenguji/sempro/(:all)/(:all)/(:all)', array('as' => 'jadwalpengujisemprodetail', 'uses' => 'dosen@jadwalpengujisempro'));
            Route::get('dosen/jadwalpenguji/semhas', array('as' => 'jadwalpengujisemhas', 'uses' => 'dosen@jadwalpengujisemhas'));
            Route::get('dosen/jadwalpenguji/semhas/(:all)/(:all)/(:all)', array('as' => 'jadwalpengujisemhasdetail', 'uses' => 'dosen@jadwalpengujisemhas'));
            Route::get('dosen/jadwalpenguji/ujian', array('as' => 'jadwalpengujiujian', 'uses' => 'dosen@jadwalpengujiujian'));
            Route::get('dosen/jadwalpenguji/ujian/(:all)/(:all)/(:all)', array('as' => 'jadwalpengujiujiandetail', 'uses' => 'dosen@jadwalpengujiujian'));
            // ----- Dosen -> Bimbingan Routing ----- //  
            Route::get('dosen/bimbingan', array('as' => 'asistensibimbingan', 'uses' => 'dosen@bimbingan'));
            Route::get('dosen/bimbingan/(:all)', array('as' => 'detailasistensibimbingan', 'uses' => 'dosen@bimbingan'));
            Route::post('dosen/bimbingan/catatan', array('before' => 'csrf', 'uses' => 'dosen@asistensi'));
            Route::put('dosen/bimbingan/rekomendasi', array('before' => 'csrf', 'uses' => 'dosen@rekomendasi'));
        });


// ----- ADMIN ----- //
Route::get('login/admin', array('as' => 'loginadmin', 'uses' => 'admin@loginadmin'));
Route::post('login/admin', array('before' => 'csrf', 'uses' => 'admin@loginadmin'));
Route::get('admin', array('as' => 'admin', 'uses' => 'admin@dashboardadmin'));
Route::get('admin/logout', array('as' => 'adminlogout', 'uses' => 'admin@logoutadmin'));
Route::group(array('before' => 'authadmin'), function() {
            // ----- Admin -> User Routing ----- //        
            Route::get('admin/user', array('as' => 'viewuser', 'uses' => 'admin@viewuser'));
            Route::post('admin/user/add', array('before' => 'csrf', 'uses' => 'admin@adduser'));
            Route::get('admin/user/delete/(:all)', array('as' => 'deleteuser', 'uses' => 'admin@deleteuser'));
            // ----- Admin -> Data Mahasiswa Routing ----- //
            Route::get('admin/user/datamahasiswa', array('as' => 'viewdatamahasiswa', 'uses' => 'admin@viewdatamahasiswa'));
            Route::post('admin/user/datamahasiswa/add', array('before' => 'csrf', 'uses' => 'admin@adddatamahasiswa'));
            Route::post('admin/user/datamahasiswa/export', array('before' => 'csrf', 'uses' => 'admin@exportdatamahasiswa'));
            Route::get('admin/user/datamahasiswa/delete/(:all)', array('as' => 'deletedatamahasiswa', 'uses' => 'admin@deletedatamahasiswa'));
            // ----- Admin -> Update Hasil Routing ----- //
            Route::get('admin/update/hasilsempro', array('as' => 'updatehasilsempro', 'uses' => 'admin@update_hasilsempro'));
            Route::get('admin/update/hasilsempro/(:all)', array('as' => 'editupdatehasilsempro', 'uses' => 'admin@update_hasilsempro'));
            Route::put('admin/update/hasilsempro', array('before' => 'csrf', 'uses' => 'admin@update_hasilsempro'));
            Route::get('admin/update/hasilujian', array('as' => 'updatehasilujian', 'uses' => 'admin@update_hasilujian'));
            Route::get('admin/update/hasilujian/(:all)', array('as' => 'editupdatehasilujian', 'uses' => 'admin@update_hasilujian'));
            Route::put('admin/update/hasilujian', array('uses' => 'admin@update_hasilujian'));
            // ----- Admin -> Jadwal Routing ----- //
            Route::get('admin/jadwal/sempro', array('as' => 'penjadwalansempro', 'uses' => 'admin@jadwal_sempro'));
            Route::get('admin/jadwal/sempro/(:all)/(:all)/(:all)', array('as' => 'deletepenjadwalansempro', 'uses' => 'admin@jadwal_sempro'));
            Route::post('admin/jadwal/sempro', array('before' => 'csrf', 'uses' => 'admin@jadwal_sempro'));
            Route::get('admin/jadwal/semhas', array('as' => 'penjadwalansemhas', 'uses' => 'admin@jadwal_semhas'));
            Route::get('admin/jadwal/semhas/(:all)/(:all)/(:all)', array('as' => 'deletepenjadwalansemhas', 'uses' => 'admin@jadwal_semhas'));
            Route::post('admin/jadwal/semhas', array('before' => 'csrf', 'uses' => 'admin@jadwal_semhas'));
            Route::get('admin/jadwal/ujian', array('as' => 'penjadwalanujian', 'uses' => 'admin@jadwal_ujian'));
            Route::get('admin/jadwal/ujian/(:all)/(:all)/(:all)', array('as' => 'deletepenjadwalanujian', 'uses' => 'admin@jadwal_ujian'));
            Route::post('admin/jadwal/ujian', array('before' => 'csrf', 'uses' => 'admin@jadwal_ujian'));
            // ----- Admin -> Jadwal Penguji Routing ----- //
            Route::get('admin/jadwalpenguji/sempro', array('as' => 'penjadwalanpengujisempro', 'uses' => 'admin@jadwalpenguji_sempro'));
            Route::get('admin/jadwalpenguji/sempro/(:all)', array('as' => 'deletepenjadwalanpengujisempro', 'uses' => 'admin@jadwalpenguji_sempro'));
            Route::post('admin/jadwalpenguji/sempro', array('before' => 'csrf', 'uses' => 'admin@jadwalpenguji_sempro'));
            Route::get('admin/jadwalpenguji/semhas', array('as' => 'penjadwalanpengujisemhas', 'uses' => 'admin@jadwalpenguji_semhas'));
            Route::get('admin/jadwalpenguji/semhas/(:all)', array('as' => 'deletepenjadwalanpengujisemhas', 'uses' => 'admin@jadwalpenguji_semhas'));
            Route::post('admin/jadwalpenguji/semhas', array('before' => 'csrf', 'uses' => 'admin@jadwalpenguji_semhas'));
            Route::get('admin/jadwalpenguji/ujian', array('as' => 'penjadwalanpengujiujian', 'uses' => 'admin@jadwalpenguji_ujian'));
            Route::get('admin/jadwalpenguji/ujian/(:all)', array('as' => 'deletepenjadwalanpengujiujian', 'uses' => 'admin@jadwalpenguji_ujian'));
            Route::post('admin/jadwalpenguji/ujian', array('before' => 'csrf', 'uses' => 'admin@jadwalpenguji_ujian'));
            // ----- Admin -> Pembimbing Routing ----- //            
            Route::get('admin/pembimbing', array('as' => 'managepembimbing', 'uses' => 'admin@pembimbing'));
            Route::get('admin/pembimbing/(:all)', array('as' => 'tambahpembimbingmahasiswa', 'uses' => 'admin@pembimbing'));
            Route::put('admin/pembimbing/add', array('before' => 'csrf', 'uses' => 'admin@tambahpembimbing'));
            // ----- Admin -> Informasi Routing ----- //
            Route::get('admin/informasi', array('as' => 'informasi', 'uses' => 'admin@informasi'));
            Route::get('admin/informasi/(:num)/(:all)', array('as' => 'editinformasi', 'uses' => 'admin@informasi'));
            Route::post('admin/informasi', array('before' => 'csrf', 'uses' => 'admin@informasi'));
            Route::put('admin/informasi', array('before' => 'csrf', 'uses' => 'admin@informasi'));
            // ----- Admin -> Berkas Routing ----- //
            Route::get('admin/berkas', array('as' => 'berkas', 'uses' => 'admin@berkas'));
            Route::get('admin/berkas/(:all)/(:all)', array('as' => 'downloadberkas', 'uses' => 'admin@berkas'));
            Route::post('admin/berkas/add', array('before' => 'csrf', 'uses' => 'admin@addberkas'));
            Route::get('admin/berkas/delete/(:all)', array('as' => 'hapusberkas', 'uses' => 'admin@deletefile'));
            // ----- Admin -> File Manager Routing ----- //
            Route::get('admin/filemanager', array('as' => 'filemanager', 'uses' => 'admin@filemanager'));
        });

// Testing
Route::get('testing', function() {
//            $awal = microtime(true);
//            $akhir = microtime(true);
//            $lama = $akhir - $awal;
//            echo $lama;
//            $hc_location = Input::get('hc_location');
//            $hc_location2 = Input::get('test');
//            echo $hc_location.' '.$hc_location2;
//            $date = date("Y-m-d H:i:s"); // current date
//            $datea = strtotime(date("Y-m-d H:i:s", strtotime($date)) . " +1 years");
//            $remaining = $datea - time();
//            $days_remaining = floor($remaining / 86400);
//            $hours_remaining = floor(($remaining % 86400) / 3600);
//            if ($date == $datea) {
//                $a = "waktu habis";
//            } else {
//                $a = "There are $days_remaining days and $hours_remaining hours left";
//            }
//             echo date('d-m-Y', $datea);
//            $mydate = new DateTime();
//            $dateme = $mydate->format('l d F Y H:i:s');
//            return $dateme;
//            return View::make('testing');
//            $arr1 = array(1, 3, 5);
//            $arr2 = array(1, 2, 3, 4, 5);
//            $missing = array_diff($arr2, $arr1);
//            foreach ($missing as $key) {
//                echo "$key, ";
//            }
//            $coo = 4;
//            $coba = Daftar::find($coo)->proposal()->first()->nim;
//            echo $coba;
//            $purifier = IoC::resolve('HTMLPurifier');
//            $getter = $purifier->purify(Input::get('coba'));
//            if (empty($getter)) {
//                echo 'halo';
//            } else {
//                echo $getter;
//            }
//      $out = User::find(18);
//      return Response::eloquent($out); // Return a JSON
//    echo $domain = Request::server('HTTP_HOST');
    return View::make('testing');
        });
Route::post('testing', function() {
//            require path('app') . 'libraries/PHPExcel.php';
//            require_once path('app') . 'libraries/PHPExcel/IOFactory.php';
//
//            $name = Input::file('fileberkas.name');
//            Input::upload('fileberkas', 'public/uploads/', $name);
//
//            $path = 'public/uploads/' . $name;
//            $objPHPExcel = PHPExcel_IOFactory::load($path);
//
//            $objWorksheet = $objPHPExcel->getActiveSheet();
//            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
//            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
//
//            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
//            try {
//                for ($row = 2; $row <= $highestRow; ++$row) {
//                    $val = array();
//
//                    for ($col = 0; $col <= $highestColumnIndex; ++$col) {
//                        $val[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
//                    }
//                    $checkmhs = new Checkmhs;
//                    $checkmhs->nim = $val[0];
//                    $checkmhs->nmdepan = $val[1];
//                    $checkmhs->nmbelakang = $val[2];
//                    $checkmhs->save();
//                }
//                File::delete('public/uploads/' . $name);
//                return Redirect::back();
//            } catch (Exception $exc) {
//                echo $exc->getTraceAsString();
//            }
        });

