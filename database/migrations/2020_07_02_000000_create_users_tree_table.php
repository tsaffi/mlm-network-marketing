<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_tree', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ancestor')->notNull();
            $table->unsignedBigInteger('descendant')->notNull();
            $table->integer('depth')->notNull(0);

            $table->foreign('ancestor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('descendant')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_tree');
    }
}
