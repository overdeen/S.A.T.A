<?php

class Create_Daftars_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('daftars', function($table) {
                    $table->increments('id');
                    $table->integer('proposal_id');
                    $table->string('nama');
                    $table->string('judul');
                    $table->integer('kategori');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('daftars');
    }

}