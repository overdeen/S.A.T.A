<?php

class Jadwalsemhas extends Eloquent {

    public static $table = 'jadwalsemhass';
    public static $timestamps = true;

    public function daftar() {
        return $this->belongs_to('Daftar');
    }

}
