<?php

class Create_Informasis_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('informasis', function($table) {
                    $table->increments('id');
                    $table->integer('admin_id');
                    $table->string('judul');
                    $table->string('isi');
                    $table->date('tanggal');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('informasis');
    }

}