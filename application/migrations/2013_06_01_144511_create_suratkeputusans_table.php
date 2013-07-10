<?php

class Create_Suratkeputusans_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('suratkeputusans', function($table) {
                    $table->increments('id');
                    $table->integer('daftar_id_id');
                    $table->timestamp('awaltanggal');
                    $table->timestamp('akhirtanggal');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('suratkeputusans');
    }

}