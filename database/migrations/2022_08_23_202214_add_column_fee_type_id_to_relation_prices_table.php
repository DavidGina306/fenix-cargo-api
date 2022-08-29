<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFeeTypeIdToRelationPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relation_prices', function (Blueprint $table) {
            $table->uuid('fee_type_id');
            $table->foreign('fee_type_id')->references('id')->on('fee_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relation_prices', function (Blueprint $table) {
            $table->uuid('fee_type_id');
        });
    }
}
