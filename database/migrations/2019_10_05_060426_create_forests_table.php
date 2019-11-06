<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forests', function (Blueprint $table) {
            $table->increments('id');
            $table->char('nik', 16);
            $table->string('name', 60);
            $table->string('owner_address')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude', 15)->nullable();
            $table->string('longitude', 15)->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->string('nik_file')->nullable();
            $table->string('photo_file')->nullable();
            $table->tinyInteger('verify')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forests');
    }
}
