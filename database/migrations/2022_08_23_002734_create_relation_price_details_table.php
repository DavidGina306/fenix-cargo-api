<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationPriceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_price_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('value')->nullable();
            $table->decimal('weight_initial')->nullable();
            $table->decimal('weight_final')->nullable();
            $table->uuid('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->uuid('relation_price_id');
            $table->foreign('relation_price_id')->references('id')->on('relation_prices')->nullable();
            $table->enum('status', ['E', 'D'])->default('E')->comment('E:enable;D:disabled');
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
        Schema::dropIfExists('relation_price_details');
    }
}
