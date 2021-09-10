<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMEPTPApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_e_p_t_p_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->string('birth_certificate');
            $table->string('educational_certificate');
            $table->string('academic_certificate');
            $table->string('shop_name');
            $table->string('shop_phone');
            $table->string('shop_email');
            $table->string('shop_address');
            $table->string('city');
            $table->integer('state');
            $table->integer('lga');
            $table->boolean('is_registered')->default(false);
            $table->string('ppmvl_no')->nullable();
            $table->integer('traing_centre');
            $table->integer('batch_id');
            $table->integer('tier_id')->nullable();
            $table->integer('index_number_id')->nullable();
            $table->string('status');
            $table->longtext('query')->nullable();
            $table->boolean('payment')->default(false);
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
        Schema::dropIfExists('m_e_p_t_p_applications');
    }
}
