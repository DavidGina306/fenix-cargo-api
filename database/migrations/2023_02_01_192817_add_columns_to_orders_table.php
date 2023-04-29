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
            $table->string('delivery_type')->nullable();
            $table->string('material')->nullable();

            //payer
            $table->uuid('payer_id')->nullable();
            $table->foreign('payer_id')->references('id')->on('customers');

            $table->uuid('doc_type_id')->nullable();
            $table->foreign('doc_type_id')->references('id')->on('doc_types');

            $table->uuid('packing_type_id')->nullable();
            $table->foreign('packing_type_id')->references('id')->on('packing_types');

            $table->string('sender_name');
            $table->string('sender_search_for')->nullable();
            $table->string('phone_sender_search_for')->nullable();
            $table->uuid('sender_id')->nullable();
            $table->foreign('sender_id')->references('id')->on('customers');
            $table->uuid('sender_address_id');
            $table->foreign('sender_address_id')->references('id')->on('addresses');

            $table->string('recipient_name')->nullable();
            $table->string('recipient_search_for')->nullable();
            $table->string('phone_recipient_search_for')->nullable();
            $table->uuid('recipient_id')->nullable();
            $table->foreign('recipient_id')->references('id')->on('customers');
            $table->uuid('recipient_address_id')->nullable();
            $table->foreign('recipient_address_id')->references('id')->on('addresses');
            $table->string('barcode')->nullable();
            $table->longText('notes');
            $table->date('open_date');
            $table->decimal('total_weight');
            $table->decimal('value');
            $table->decimal('quantity');
            $table->decimal('height')->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('weight');
            $table->decimal('length')->nullable();
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
