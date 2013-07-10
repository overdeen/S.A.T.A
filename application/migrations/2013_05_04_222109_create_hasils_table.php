<?php

class Create_Hasils_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up() {
        Schema::create('hasils', function($table) {
                    $table->increments('id');
                    $table->integer('daftar_id');
                    $table->integer('admin_id');
                    $table->integer('kategori');
                    $table->integer('hasil');
                    $table->string('keterangan');
                    $table->timestamps();
                });
    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down() {
        Schema::drop('hasils');
    }

}