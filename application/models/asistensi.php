<?php

class Asistensi extends Eloquent {

    public static $table = 'asistensis';
    public static $timestamps = true;

    public function bimbingan() {
        return $this->belongs_to('Bimbingan');
    }

}
