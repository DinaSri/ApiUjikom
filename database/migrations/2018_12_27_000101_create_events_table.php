<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('desc');
            $table->string('penyelenggara');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('lokasi');
            $table->string('status');
            $table->string('image')->nullable();
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categoris')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('events');
    }
}
