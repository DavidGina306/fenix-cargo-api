<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('role');
            $table->string('email');
            $table->enum('type', ['F', 'J']);
            $table->string('document');
            $table->string('email_2')->nullable();
            $table->string('contact');
            $table->enum('gender', ['F', 'M', 'O'])->comment('F:female;M:male;O:Others');
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
        Schema::dropIfExists('customers');
    }
}
