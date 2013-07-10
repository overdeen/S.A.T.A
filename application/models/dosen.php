<?php

class Dosen extends Eloquent {

    public static $table = 'dosens';
    public static $timestamps = true;

    public function user() {
        return $this->belongs_to('User');
    }

    public function pembimbing() {
        return $this->has_many('Pembimbing');
    }

    public function jadwalpengujisempro() {
        return $this->has_many('Jadwalpengujisempro');
    }

    public function jadwalpengujisemhas() {
        return $this->has_many('Jadwalpengujisemhas');
    }

    public function jadwalpengujiujian() {
        return $this->has_many('Jadwalpengujiujian');
    }

    public function bimbingan() {
        return $this->has_many('Bimbingan');
    }

}