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
            $table->integer('user_id');
            $table->integer('firstname');
            $table->integer('middlename');
            $table->string('surname');
            $table->string('email');
            $table->string('phone');
            $table->string('gender');
            $table->integer('doq');
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
