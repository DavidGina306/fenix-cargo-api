<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumnsToOrderMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_movements', function (Blueprint $table) {
            $table->time('time');
            $table->enum('document_type', ['C', 'R', 'M'])->comment('C:CPF;R:RG,M:Matricula');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_movements', function (Blueprint $table) {
            $table->dropColumn('time');
            $table->dropColumn('document_type');
        });
    }
}
