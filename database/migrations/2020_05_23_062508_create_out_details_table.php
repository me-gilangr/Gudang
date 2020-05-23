<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('out_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('out_header_id');
            $table->unsignedBigInteger('stuff_id');
            $table->foreign('out_header_id')->references('id')->on('out_headers');
            $table->foreign('stuff_id')->references('id')->on('stuffs');
            $table->double('stock_out');
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
        Schema::dropIfExists('out_details');
    }
}
