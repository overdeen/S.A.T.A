<?php

class Create_Berkass_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('berkass', function($table) {
                    $table->increments('id');
                    $table->integer('admin_id');
                    $table->string('nama');
                    $table->string('kategori');
                    $table->string('file');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('berkass');
    }

}