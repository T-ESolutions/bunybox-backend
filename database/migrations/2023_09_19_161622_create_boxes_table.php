<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('image')->nullable();
            $table->longText('desc_ar')->nullable();
            $table->longText('desc_en')->nullable();

            $table->double('price')->default(0);
            $table->double('min_price')->default(0);
            $table->double('max_price')->default(0);

            $table->foreignId('main_category_id')->nullable()->constrained('main_categories')->restrictOnDelete();
            //offers
            $table->tinyInteger('is_offer')->default(0);
            $table->timestamp('offer_end_time')->nullable();
            $table->double('offer_price')->default(0);

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
        Schema::dropIfExists('boxes');
    }
}
