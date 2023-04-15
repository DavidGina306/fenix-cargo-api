<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderWarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_warnings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('entry_date');
            $table->string('profile');
            $table->string('contact')->nullable();
            $table->boolean('is_whatsaap')->default(false);
            $table->decimal('value');
            $table->uuid('partner_id');
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->uuid('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('order_warnings');
    }
}
