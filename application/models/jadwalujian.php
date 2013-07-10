<?php

class Jadwalujian extends Eloquent {

    public static $table = 'jadwalujians';
    public static $timestamps = true;

    public function daftar() {
        return $this->belongs_to('Daftar');
    }

}
