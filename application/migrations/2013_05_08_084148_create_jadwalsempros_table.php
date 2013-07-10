<?php

class Create_Jadwalsempros_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('jadwalsempros', function($table) {
                    $table->increments('id');
                    $table->integer('daftar_id');
                    $table->date('tanggal');
                    $table->string('ruang');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('jadwalsempros');
    }

}