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
            $table->uuid('id');
            //0 EN MARCHA --- 1 TERMINADO ----2 PAGADO ---3 PREPARADO --- 4 ENTREGADO --- 9 PAGAR A CAMAEREA
            $table->integer('status')->nullable();
            $table->uuid('customer_id')->nullable();
            $table->integer('table_number')->default(0);
            $table->string('comment')->nullable();
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
