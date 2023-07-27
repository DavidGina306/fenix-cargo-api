<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerDetailBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_detail_banks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('agency')->nullable();
            $table->string('checking_account')->nullable();
            $table->string('beneficiaries')->nullable();
            $table->string('pix')->nullable();
            $table->uuid('partner_id');
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->uuid('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks');
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
        Schema::dropIfExists('partner_detail_banks');
    }
}
