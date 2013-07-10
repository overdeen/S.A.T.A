<?php

class Admin extends Eloquent {

    public static $table = 'admins';
    public static $timestamps = true;

    public function user() {
        return $this->belongs_to('User');
    }

    public function hasil() {
        return $this->has_many('Hasil');
    }

    public function informasi() {
        return $this->has_many('Informasi');
    }

    public function berkas() {
        return $this->has_many('Berkas');
    }

}
