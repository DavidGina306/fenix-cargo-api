<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number');
            $table->string('comment_1')->nullable();
            $table->string('comment_2')->nullable();
            $table->enum('status', ['E', 'D'])->default('E')->comment('E:enable;D:disabled');
            $table->decimal('value')->nullable();
            $table->decimal('width');
            $table->decimal('height');
            $table->decimal('length');
            $table->decimal('cubed_weight');
            $table->integer('quantity');
            $table->decimal('add_price')->nullable();
            $table->uuid('doc_type_id');
            $table->foreign('doc_type_id')->references('id')->on('doc_types');
            $table->uuid('sender_address_id');
            $table->foreign('sender_address_id')->references('id')->on('addresses');
            $table->uuid('recipient_address_id');
            $table->foreign('recipient_address_id')->references('id')->on('addresses');
            $table->uuid('fee_type_id');
            $table->foreign('fee_type_id')->references('id')->on('fee_types')->nullable();
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
        Schema::dropIfExists('quotes');
    }
}
