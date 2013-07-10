<?php

class Profil extends Eloquent {

    public static $table = 'profils';
    public static $timestamps = true;

    public function user() {
        return $this->belongs_to('User');
    }

}
