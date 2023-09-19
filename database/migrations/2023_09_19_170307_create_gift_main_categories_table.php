<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftMainCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_main_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_id')->nullable()->constrained('gifts')->restrictOnDelete();
            $table->foreignId('main_category_id')->nullable()->constrained('main_categories')->restrictOnDelete();
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
        Schema::dropIfExists('gift_main_categories');
    }
}
