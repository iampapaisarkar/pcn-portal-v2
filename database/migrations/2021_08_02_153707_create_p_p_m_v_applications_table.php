<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePPMVApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_p_m_v_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->integer('meptp_application_id');
            $table->string('reference_1_name');
            $table->string('reference_1_phone');
            $table->string('reference_1_email');
            $table->string('reference_1_address');
            $table->string('reference_1_letter');
            $table->string('current_annual_licence');

            $table->string('reference_2_name');
            $table->string('reference_2_phone');
            $table->string('reference_2_email');
            $table->string('reference_2_address');
            $table->string('reference_2_letter');
            $table->string('reference_occupation');
            
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
        Schema::dropIfExists('p_p_m_v_applications');
    }
}
