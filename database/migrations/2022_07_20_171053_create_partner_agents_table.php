<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_agents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('email');
            $table->string('email_2')->nullable();
            $table->string('contact');
            $table->uuid('partner_id');
            $table->foreign('partner_id')->references('id')->on('partners');
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
        Schema::dropIfExists('patner_agents');
    }
}
