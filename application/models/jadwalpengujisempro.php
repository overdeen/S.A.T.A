<?php

class Jadwalpengujisempro extends Eloquent {

    public static $table = 'jadwalpengujisempros';
    public static $timestamps = true;

    public function dosen() {
        return $this->belongs_to('Dosen');
    }

}
