<?php

class Informasi extends Eloquent {

    public static $table = 'informasis';
    public static $timestamps = true;

    public function admin() {
        return $this->belongs_to('Admin');
    }

}
