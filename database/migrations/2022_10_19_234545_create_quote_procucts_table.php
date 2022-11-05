<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteProcuctsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_procucts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('width');
            $table->decimal('height');
            $table->decimal('length');
            $table->decimal('cubed_weight');
            $table->integer('quantity');
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
        Schema::dropIfExists('quote_procucts');
    }
}
