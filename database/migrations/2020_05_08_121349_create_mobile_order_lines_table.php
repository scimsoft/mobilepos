<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_order_lines', function (Blueprint $table) {
            $table->id();
            $table->uuid('mobile_order_id');
            $table->uuid('product_ID');
            $table->integer('line')->nullable();
            $table->integer('units')->default(1);
            $table->double('price');
            $table->boolean('printed')->default(false);
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
        Schema::dropIfExists('mobile_order_lines');
    }
}
