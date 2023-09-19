<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('box_id')->nullable()->constrained('boxes')->restrictOnDelete();
            $table->longText('address_data')->nullable();
            $table->foreignId('main_category_id')->nullable()->constrained('main_categories')->restrictOnDelete();
            $table->enum('status',['ordered','shipped','delivered'])->default('ordered');
            $table->enum('payment_status',['paid','unpaid'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->double('price')->default(0);
            $table->double('shipping_cost')->default(0);
            $table->double('total')->default(0);
            $table->timestamp('delivered_at')->nullable();
            $table->tinyInteger('is_offer')->default(0);
            $table->enum('gift_type',['money','product'])->nullable();
            $table->double('gift_money')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
