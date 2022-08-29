<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_agents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('email')->unique();
            $table->string('email_2')->nullable();
            $table->string('contact');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('contact_2')->nullable();
            $table->enum('status', ['E', 'D'])->default('E')->comment('E:enable;D:disabled');
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
        Schema::dropIfExists('customer_agents');
    }
}
