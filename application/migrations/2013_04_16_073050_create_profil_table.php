<?php

class Create_Profil_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('profils', function($table) {
                    $table->increments('id');
                    $table->string('user_id');
                    $table->string('alamat')->nullable();
                    $table->text('biografi')->nullable();
                    $table->string('notelp')->nullable();
                    $table->string('nohp')->nullable();
                    $table->string('foto')->nullable();
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('profils');
    }

}