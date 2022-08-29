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
            $table->enum('deadline_type', ['H', 'D'])->default('D')->comment('H:Hour; D:Days');
            $table->string('deadline_initial')->nullable();
            $table->string('deadline_final')->nullable();
            $table->enum('destiny_type', ['P', 'T'])->default('T')->comment('T:town;P:postcode');
            $table->string('destiny_initial');
            $table->string('destiny_final')->nullable();
            $table->string('destiny_state');
            $table->enum('origin_type', ['P', 'T'])->default('T')->comment('T:town;P:postcode');
            $table->string('origin_initial');
            $table->string('origin_state');
            $table->enum('status', ['E', 'D'])->default('E')->comment('E:enable;D:disabled');
            $table->uuid('partner_id')->nullable();
            $table->foreign('partner_id')->references('id')->on('partners');
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
