<?php

class Mahasiswa extends Eloquent {

    public static $table = 'mahasiswas';
    public static $timestamps = true;

    public function user() {
        return $this->belongs_to('User');
    }

    public function proposal() {
        return $this->has_one('Proposal');
    }

}
