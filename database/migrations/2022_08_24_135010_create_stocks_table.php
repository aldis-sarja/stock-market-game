<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('company_name');
            $table->decimal('current_price', 20,  8);
            $table->decimal('change', 20,  8);
            $table->decimal('percent_change', 20, 8);
            $table->decimal('high_price', 20, 8);
            $table->decimal('low_price', 20, 8);
            $table->decimal('open_price', 20, 8);
            $table->decimal('previous_close_price', 20, 8);
            $table->integer('last_change_time');
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
        Schema::dropIfExists('stocks');
    }
}
