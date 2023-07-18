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
            $table->string('deadline_initial')->nullable();
            $table->string('deadline_final')->nullable();
            $table->string('destiny_country');
            $table->string('destiny_1')->nullable();
            $table->string('destiny_2');
            $table->string('origin_country');
            $table->string('origin_state');
            $table->string('origin_city');
            $table->enum('type', ['F', 'C', 'P'])->default('F')->comment('F:Fenix;C:compnay,P:Partner');
            $table->decimal('value')->nullable();
            $table->decimal('weight_initial')->nullable();
            $table->decimal('weight_final')->nullable();
            $table->boolean("local_type")->default(false);
            $table->enum('status', ['E', 'D'])->default('E')->comment('E:enable;D:disabled');
            $table->uuid('partner_id')->nullable();
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->uuid('fee_type_id')->nullable();
            $table->foreign('fee_type_id')->references('id')->on('fee_types');
            $table->uuid('fee_rule_id')->nullable();
            $table->foreign('fee_rule_id')->references('id')->on('fee_rules');
            $table->timestamps();
            $table->enum('deadline_type', ['H', 'D'])->default('D')->comment('H:Hour; D:Days');
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
