<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number')->unique();
            $table->uuid('payer_address_id');
            $table->foreign('payer_address_id')->references('id')->on('addresses');
            $table->uuid('payer_id');
            $table->foreign('payer_id')->references('id')->on('customers');
            $table->string("type_invoice_id");
            $table->decimal("interest");
            $table->decimal("penalty");
            $table->decimal('discount');
            $table->decimal('value');
            $table->integer('quantity');
            $table->date("due_date");
            $table->uuid("bank_id");
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->string("barcode")->nullable();
            $table->string("note")->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
