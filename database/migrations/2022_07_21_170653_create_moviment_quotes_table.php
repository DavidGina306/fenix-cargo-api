<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moviment_quotes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('status', ['E', 'D'])->default('E')->comment('E:enable;D:disabled');
            $table->uuid('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes');
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
        Schema::dropIfExists('moviment_quotes');
    }
}
