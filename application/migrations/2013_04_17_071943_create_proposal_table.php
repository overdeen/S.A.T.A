<?php

class Create_Proposal_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('proposals', function($table) {
                    $table->increments('id');
                    $table->string('mahasiswa_id');
                    $table->string('judul');
                    $table->text('deskripsi');
                    $table->string('tahun');
                    $table->string('dokumen');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('proposals');
    }

}