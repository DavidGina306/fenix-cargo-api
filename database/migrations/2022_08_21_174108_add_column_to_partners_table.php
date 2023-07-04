<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->enum('type', ['F', 'J']);
            $table->enum('profile', ['C', 'M', 'P']);
            $table->enum('gender', ['F', 'M', 'O'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('gender');
            $table->dropColumn('email');
            $table->dropColumn('email_2');
            $table->dropColumn('contact');
        });
    }
}
