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
            $table->unsignedBigInteger('role_id');
            $table->char('nip', 18)->unique();
            $table->string('name',60);
            $table->text('image');
            $table->string('password');
            $table->string('reset_password')->nullable();
            $table->string('latitude1', 15)->nullable();
            $table->string('longitude1', 15)->nullable();
            $table->string('latitude2', 15)->nullable();
            $table->string('longitude2', 15)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')->references('id')->on('user_role')
                ->onDelete('cascade')->onUpdate('cascade');
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
