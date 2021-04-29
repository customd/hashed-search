<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HashedSearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('hashed_searches', function (Blueprint $table) {
            $table->id();
            $table->string('hash');
            $table->string('hash_field');
            $table->unsignedBigInteger('hash_id');
            $table->string('hash_type');
            $table->index(['hash_id', 'hash_type','hash_field'], 'hash_id_field_type_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::drop('hashed_searches');
    }
}
