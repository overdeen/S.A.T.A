<?php

class User extends Eloquent {

    public static $table = 'users';
    public static $timestamps = true;

    public function mahasiswa() {
        return $this->has_one('Mahasiswa');
    }

    public function dosen() {
        return $this->has_one('Dosen');
    }

    public function admin() {
        return $this->has_one('Admin');
    }

    public function profil() {
        return $this->has_one('Profil');
    }

}
