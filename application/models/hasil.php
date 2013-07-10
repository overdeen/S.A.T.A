<?php

class Hasil extends Eloquent {

    public static $table = 'hasils';
    public static $timestamps = true;

    public function daftar() {
        return $this->belongs_to('Daftar');
    }

    public function admin() {
        return $this->belongs_to('Admin');
    }

}
