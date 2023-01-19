<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objects', function (Blueprint $table) {
            $table->string('number')->unique();
            $table->decimal('width');
            $table->decimal('height');
            $table->decimal('length');
            $table->decimal('cubed_weight');
            $table->decimal('cubed_metric');
            $table->decimal('weight');
            $table->integer('quantity');
            $table->string('description');
            $table->string('note')->nullable();
            $table->uuid('locale_id');
            $table->foreign('locale_id')->references('id')->on('locales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objects');
    }
}
