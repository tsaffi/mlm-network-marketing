<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->nullable();;
            $table->string('phone')->nullable();;
            $table->string('referrer')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('sponsor_id')->nullable();
            $table->integer('direct_downlines')->default(0)->nullable();
            $table->integer('level')->default(0)->nullable();
            $table->integer('two')->default(0)->nullable();
            $table->integer('three')->default(0)->nullable();
            $table->integer('four')->default(0)->nullable();
            $table->integer('five')->default(0)->nullable();
            $table->integer('six')->default(0)->nullable();
            $table->string('password')->notNull();
            $table->string('avartar')->nullable();
            $table->string('role')->default('user')->nullable();
            $table->string('activated')->default('no')->nullable();
            $table->timestamp('activated_at')->nullable();;
            $table->unsignedBigInteger('activated_by')->nullable();;
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken()->nullable();;
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('code')->nullable();
            $table->timestamp('deleted')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
