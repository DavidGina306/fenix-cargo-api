<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFeeRuleIdToRelationPriceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relation_price_details', function (Blueprint $table) {
            $table->uuid('fee_rule_id')->nullable();
            $table->foreign('fee_rule_id')->references('id')->on('fee_rules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relation_price_details', function (Blueprint $table) {
            $table->dropColumn('fee_rule_id');
        });
    }
}
