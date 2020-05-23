<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('entry_header_id');
            $table->unsignedBigInteger('stuff_id');
            $table->foreign('entry_header_id')->references('id')->on('entry_headers');
            $table->foreign('stuff_id')->references('id')->on('stuffs');
            $table->double('stock_in');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('entry_details');
    }
}
