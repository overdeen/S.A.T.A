<?php

class Create_Bimbingans_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('bimbingans', function($table) {
                    $table->increments('id');
                    $table->integer('proposal_id');
                    $table->integer('dosen_id');
                    $table->integer('is_dosen');
                    $table->boolean('rekomendasi');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('bimbingans');
    }

}