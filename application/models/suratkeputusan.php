<?php

class Suratkeputusan extends Eloquent {

    public static $table = 'suratkeputusans';
    public static $timestamps = true;

    public function daftar() {
        return $this->belongs_to('Daftar');
    }

}
