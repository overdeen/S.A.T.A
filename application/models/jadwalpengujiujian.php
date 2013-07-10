<?php

class Jadwalpengujiujian extends Eloquent {

    public static $table = 'jadwalpengujiujians';
    public static $timestamps = true;

    public function dosen() {
        return $this->belongs_to('Dosen');
    }

}
