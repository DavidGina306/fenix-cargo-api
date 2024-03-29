<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabinetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabinets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order')->unique();
            $table->char('status')->default('O');
            $table->dateTime('entry_date');
            $table->dateTime('out_date')->nullable();
            $table->decimal('doc_value');
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->uuid('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');
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
        Schema::dropIfExists('cabinets');
    }
}
