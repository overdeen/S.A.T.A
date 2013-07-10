<?php

class Jadwalpengujisemhas extends Eloquent {

    public static $table = 'jadwalpengujisemhass';
    public static $timestamps = true;

    public function dosen() {
        return $this->belongs_to('Dosen');
    }

}
