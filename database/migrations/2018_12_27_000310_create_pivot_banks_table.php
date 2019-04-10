<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_banks', function (Blueprint $table) {
             $table->increments('id');
            $table->unsignedinteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('CASCADE')->onUpate('CASCADE');
            $table->unsignedinteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('CASCADE')->onUpate('CASCADE');
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
        Schema::dropIfExists('pivot_banks');
    }
}
