<?php

class Angkatan {

    public function nim($nim, $userid) {
        $findid = Profil::where_user_id($userid)->first();
        $id = $findid->id;
        $angkatan = substr($nim, 0, 2);
        if ($angkatan == '08') {
            Profil::update($id, array(
                'angkatan' => '2008'
            ));
        } else if ($angkatan == '09') {
            Profil::update($id, array(
                'angkatan' => '2009'
            ));
        } else if ($angkatan == '10') {
            Profil::update($id, array(
                'angkatan' => '2010'
            ));
        }
    }

}