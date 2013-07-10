<?php

class Create_Pembimbings_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('pembimbings', function($table) {
                    $table->increments('id');
                    $table->integer('proposal_id');
                    $table->integer('dosen_id');
                    $table->string('dosenname');
                    $table->boolean('approval');
                    $table->text('catatan');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('pembimbings');
    }

}