<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMEPTPIndexNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_e_p_t_p_index_numbers', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('arbitrary_1')->default('PCN');
            $table->string('arbitrary_2')->default('MT');
            $table->string('batch_year');
            $table->string('state_code');
            $table->string('school_code');
            $table->string('tier');
            $table->timestamps();
        });

        $prefix = DB::getTablePrefix();
		DB::update("ALTER TABLE ".$prefix."m_e_p_t_p_index_numbers AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_e_p_t_p_index_numbers');
    }
}
