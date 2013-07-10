<?php

class Create_Dosens_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('dosens', function($table) {
                    $table->increments('id');
                    $table->string('user_id');
                    $table->string('namadepan');
                    $table->string('namabelakang');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('dosens');
    }

}