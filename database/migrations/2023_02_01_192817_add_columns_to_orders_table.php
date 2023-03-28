<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('number');
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->uuid('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->longText('notes');
            $table->date('open_date');
            $table->decimal('total_weight');
            $table->decimal('value');
            $table->decimal('quantity');
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
            $table->dropColumn('number');
            $table->dropColumn('customer_id');
            $table->dropColumn('address_id');
            $table->dropColumn('status');
            $table->dropColumn('notes');
            $table->dropColumn('open_date');
            $table->dropColumn('value');
            $table->dropColumn('total_weight');
            $table->dropColumn('quantity');
        });
    }
}
