<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('quote_id')->nullable();
            $table->foreign('quote_id')->references('id')->on('quotes');
            $table->decimal('freight_value')->nullable();
            $table->string('barcode')->nullable();
            $table->string('obs')->nullable();
            $table->decimal('insurance_percentage')->nullable();
            $table->decimal('insurance_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('dispatcher_order_id');
        });
    }
}
