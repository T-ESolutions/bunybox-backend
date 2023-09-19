<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftMoneyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_money_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_id')->nullable()->constrained('gifts')->restrictOnDelete();
            $table->double('amount')->default(0);
            $table->tinyInteger('is_selected')->default(0);
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
        Schema::dropIfExists('gift_money_details');
    }
}
