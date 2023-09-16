<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_num');
            $table->bigInteger('empty_weight');
            $table->bigInteger('full_weight')->nullable();
            $table->bigInteger('net_weight')->nullable();
            $table->enum('payment_type', ['cash', 'online'])->default('cash');
            $table->string('car_num');
            $table->string('driver_name');
            $table->string('transporter_name');
            $table->string('client_name');
            $table->string('customer_tax');
            $table->string('item');
            $table->enum('unit', ['kg', 'ton'])->default('ton');
            $table->bigInteger('crusher_num');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled']);
            $table->bigInteger('temperature');
            $table->softDeletes();
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
        Schema::dropIfExists('operations');
    }
}
