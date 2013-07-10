<?php

class Jadwalsempro extends Eloquent {

    public static $table = 'jadwalsempros';
    public static $timestamps = true;

    public function daftar() {
        return $this->belongs_to('Daftar');
    }

}
