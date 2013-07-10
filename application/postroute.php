<?php

Route::post('ceknim', function() {
            $nim = e(Input::get('nim'));
            $cek1 = Checkmhs::where_nim($nim)->first();
            $cek2 = User::where_username($nim)->first();
            if (empty($cek1)) {
                $data = array(
                    "html" => '
                        <div class="control-group error">
                            <label class="control-label"><p class="text-error">Anda Tidak Terdaftar Sebagai Mahasiswa Jurusan Teknik Informatika UMM Malang</p></label>
                        </div>
                        <div class="footer">
                            <a href="" class="btn btn-danger">CEK NIM BARU</a>
                        </div>');
                return Response::json($data);
            } else {
                if (empty($cek2)) {
                    $data = array(
                        "html" => '
                        <form id="register-form" action="registrasi" method="post">' . Form::token() . '
                            <label for="nim">Nomor Induk Mahasiswa</label>
                            <input name="nim" class="input-huge" type="text" readonly="true" value="' . $nim . '">
                            <div class="control-group control-inline">
                                <label for="namadepan">Nama Depan</label>
                                <input name="namadepan" class="input-medium" readonly="true" type="text" value="' . $cek1->nmdepan . '">
                            </div>
                            <div class="control-group control-inline">
                                <label for="namabelakang">Nama Belakang</label>
                                <input name="namabelakang" class="input-medium" readonly="true" type="text" value="' . $cek1->nmbelakang . '">
                            </div>
                            <div class="control-group control-inline">
                                <label for="password">Password</label>
                                <input name="password" class="input-medium" type="password" required>
                            </div>
                            <div class="control-group control-inline">
                                <label for="password_confirmation">Password Conf</label>
                                <input name="password_confirmation" class="input-medium" type="password" required>
                            </div>
                            <label for="email">Email</label>
                            <input name="email" type="email" class="input-huge" required/>  
                            <div class="footer">
                                <button type="submit" class="btn btn-danger">REGISTRASI</button>
                                <a href="" class="btn btn-danger">CEK NIM BARU</a>
                            </div>
                        </form>');
                    return Response::json($data);
                } else {
                    $data = array(
                        "html" => '
                        <div class="control-group error">
                            <label class="control-label"><p class="text-error">NIM Anda (' . $nim . ') Telah Terdaftar</p></label>
                        </div>
                        <div class="footer">
                            <h5>Lupa Password Anda ?</h5>
                            <form id="register-form" action="lupa/password" method="post">' . Form::token() . '
                                <input value="' . $nim . '" name="nim" class="input-huge" type="hidden">
                                <div class="control-group control-inline">
                                    <label for="email">Email Terdaftar</label>
                                    <input name="email" class="input-huge" type="email">
                                </div>
                                <div class="footer">
                                    <button type="submit" class="btn btn-danger">KIRIM PASSWORD</button>
                                    <a href="" class="btn btn-danger">NIM BARU</a>
                                </div>
                            </form>
                        </div>');
                    return Response::json($data);
                }
            }
        });