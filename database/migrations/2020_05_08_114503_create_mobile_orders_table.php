<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_orders', function (Blueprint $table) {
            $table->id();
            //0 EN MARCHA --- 1 TERMINADO ----2 PAGADO ---3 ENTREGADO
            $table->integer('status')->nullable();
            $table->uuid('customer_id')->nullable();
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
        Schema::dropIfExists('mobile_orders');
    }
}
