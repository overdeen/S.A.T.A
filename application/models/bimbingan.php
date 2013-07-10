<?php

class Bimbingan extends Eloquent {

    public static $table = 'bimbingans';
    public static $timestamps = true;

    public function daftar() {
        return $this->belongs_to('Daftar');
    }

    public function dosen() {
        return $this->belongs_to('Dosen');
    }
    
    public function asistensi() {
        return $this->has_many('Asistensi');
    }

}
