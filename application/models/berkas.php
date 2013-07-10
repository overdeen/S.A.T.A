<?php

class Berkas extends Eloquent {

    public static $table = 'berkass';
    public static $timestamps = true;

    public function admin() {
        return $this->belongs_to('Admin');
    }

}
