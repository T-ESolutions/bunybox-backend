<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_boxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_id')->nullable()->constrained('gifts')->restrictOnDelete();
            $table->foreignId('box_id')->nullable()->constrained('boxes')->restrictOnDelete();
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
        Schema::dropIfExists('gift_boxes');
    }
}
