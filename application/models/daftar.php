<?php

class Daftar extends Eloquent {

    public static $table = 'daftars';
    public static $timestamps = true;

    public function proposal() {
        return $this->belongs_to('Proposal');
    }

    public function hasil() {
        return $this->has_one('Hasil');
    }

    public function jadwalsempro() {
        return $this->has_one('Jadwalsempro');
    }

    public function jadwalsemhas() {
        return $this->has_one('Jadwalsemhas');
    }

    public function jadwalujian() {
        return $this->has_one('Jadwalujian');
    }

    public function bimbingan() {
        return $this->has_many('Bimbingan');
    }
    
    public function suratkeputusan() {
        return $this->has_one('Suratkeputusan');
    }

}
