<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_prices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number')->unique();
            $table->enum('status', ['E', 'D'])->default('E')->comment('E:enable;D:disabled');
            $table->enum('deadline_type', ['H', 'D'])->default('D')->comment('H:Hour; D:Days');
            $table->string('initial_deadline');
            $table->string('final_deadline')->nullable();
            $table->decimal('value')->nullable();
            $table->decimal('initial_price');
            $table->decimal('excess_weight')->nullable();
            $table->uuid('price_type_id');
            $table->foreign('price_type_id')->references('id')->on('price_types');
            $table->uuid('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->uuid('origin_address_id');
            $table->foreign('origin_address_id')->references('id')->on('addresses');
            $table->uuid('destination_address_id');
            $table->foreign('destination_address_id')->references('id')->on('addresses');
            $table->uuid('fee_type_id');
            $table->foreign('fee_type_id')->references('id')->on('fee_types');
            $table->uuid('partner_id');
            $table->foreign('partner_id')->references('id')->on('partners')->nullable();
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
        Schema::dropIfExists('relation_prices');
    }
}
