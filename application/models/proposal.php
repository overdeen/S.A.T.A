<?php

class Proposal extends Eloquent {

    public static $table = 'proposals';
    public static $timestamps = true;

    public function mahasiswa() {
        return $this->belongs_to('Mahasiswa');
    }

    public function pembimbing() {
        return $this->has_many('Pembimbing');
    }

    public function daftar() {
        return $this->has_one('Daftar');
    }

}
