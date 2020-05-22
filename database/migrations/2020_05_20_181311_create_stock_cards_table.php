<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('stuff_id');
            $table->foreign('stuff_id')->references('id')->on('stuffs');
            $table->date('stock_date');
            $table->double('cap_stock')->default(0);
            $table->double('stock_entry')->default(0);
            $table->double('stock_out')->default(0);
            $table->double('stock_back_in')->default(0);
            $table->double('stock_back_out')->default(0);
            $table->double('stock_adjustment')->default(0);
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
        Schema::dropIfExists('stock_cards');
    }
}
