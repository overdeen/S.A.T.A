<?php

class Create_Jadwalpengujisemhass_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('jadwalpengujisemhass', function($table) {
                    $table->increments('id');
                    $table->integer('dosen_id');
                    $table->timestamp('waktu');
                    $table->string('ruang', 50);
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('jadwalpengujisemhass');
    }

}