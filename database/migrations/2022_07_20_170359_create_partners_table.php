<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('number_doc');
            $table->uuid('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->enum('status', ['E', 'D']);
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
        Schema::dropIfExists('patners');
    }
}
