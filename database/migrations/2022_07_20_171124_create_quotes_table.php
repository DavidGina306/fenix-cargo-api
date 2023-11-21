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
            $table->string('number')->unique();
            $table->string('comment_1')->nullable();
            $table->string('comment_2')->nullable();
            $table->enum('status', ['E', 'D', 'C', 'A', 'W'])->default('E')->comment('E:enable;D:disabled');

            $table->decimal('value');
            $table->decimal('add_price')->nullable();
            $table->decimal('total_weight', 10, 1); // 10 dígitos no total, com 2 dígitos após o ponto decimal
            $table->uuid('doc_type_id');
            $table->foreign('doc_type_id')->references('id')->on('doc_types');

            $table->string('sender_name')->nullable();
            $table->string('recipient_name')->nullable();

            $table->uuid('sender_address_id');
            $table->string('recipien_name')->nullable();
            $table->foreign('sender_address_id')->references('id')->on('addresses');
            $table->uuid('recipient_address_id');
            $table->foreign('recipient_address_id')->references('id')->on('addresses');

            // Foreign keys for relationships with customers, senders, and recipients
            $table->uuid('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->uuid('sender_id')->nullable();
            $table->foreign('sender_id')->references('id')->on('customers');

            $table->uuid('recipient_id')->nullable();
            $table->foreign('recipient_id')->references('id')->on('customers');


            $table->decimal('insurance', 8, 2)->nullable();
            $table->decimal('flat_fee', 8, 2)->nullable();
            $table->decimal('fee', 8, 2)->nullable();
            $table->decimal('minimum_fee', 8, 2)->nullable();
            $table->decimal('excess_weight', 8, 2)->nullable();
            $table->decimal('insurance_percentage', 5, 2)->nullable();

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
