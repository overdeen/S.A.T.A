<?php

class Pembimbing extends Eloquent {

    public static $table = 'pembimbings';
    public static $timestamps = true;

    public function dosen() {
        return $this->belongs_to('Dosen');
    }

    public function proposal() {
        return $this->belongs_to('Proposal');
    }

}
