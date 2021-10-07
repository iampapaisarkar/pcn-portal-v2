<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_registrations', function (Blueprint $table) {
            $table->id();
            $table->integer('registration_id');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('surname');
            $table->string('email');
            $table->string('phone');
            $table->string('gender');
            $table->date('doq');
            $table->longtext('residental_address');
            $table->string('annual_licence_no')->nullable();
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
        Schema::dropIfExists('other_registrations');
    }
}
