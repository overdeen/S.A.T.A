<?php

class Create_Asistensis_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('asistensis', function($table) {
                    $table->increments('id');
                    $table->integer('bimbingan_id');
                    $table->string('catatan');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('asistensis');
    }

}