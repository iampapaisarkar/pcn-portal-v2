<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_registrations', function (Blueprint $table) {
            $table->id();
            $table->integer('registration_id');
            $table->integer('user_id');
            $table->integer('bed_capacity');
            $table->string('passport');
            $table->string('pharmacist_name');
            $table->string('pharmacist_email');
            $table->string('pharmacist_phone');
            $table->integer('qualification_year');
            $table->string('registration_no')->nullable();
            $table->string('last_year_licence_no')->nullable();
            $table->longtext('residential_address');
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
        Schema::dropIfExists('hospital_registrations');
    }
}
