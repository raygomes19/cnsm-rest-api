<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVarietiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('varieties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('quality_id');
            $table->unsignedBigInteger('location_id');
            $table->integer('stock')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('quality_id')->references('id')->on('qualities');
            $table->unique(['brand_id', 'quality_id', 'location_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('varieties');
    }
}
