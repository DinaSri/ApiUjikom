<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
           $table->increments('id');
            $table->integer('nominal');
            $table->string('desc');
            $table->string('status');
            $table->unsignedinteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedinteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('CASCADE')->onUpdate('CASCADE');    
            $table->integer('jumlah_tiket');

            $table->unsignedinteger('tiket_id');
            $table->foreign('tiket_id')->references('id')->on('tikets')->onDelete('CASCADE')->onUpdate('CASCADE');



            $table->unsignedinteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('CASCADE')->onUpdate('CASCADE');
          
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
        Schema::dropIfExists('transfers');
    }
}
