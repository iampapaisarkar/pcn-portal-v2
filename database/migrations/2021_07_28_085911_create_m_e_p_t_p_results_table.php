<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMEPTPResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_e_p_t_p_results', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id');
            $table->integer('vendor_id');
            $table->string('status');
            $table->integer('score')->nullable();
            $table->float('percentage')->nullable();
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
        Schema::dropIfExists('m_e_p_t_p_results');
    }
}
