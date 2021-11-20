<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('registration_year');
            $table->string('type');
            $table->string('category');
            $table->string('token')->nullable();
            $table->string('inspection_report')->nullable();
            $table->string('status');
            $table->string('banner_status')->nullable();
            $table->boolean('payment')->default(false);
            $table->boolean('location_approval')->default(false);
            $table->string('recommendation_status')->nullable();
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
        Schema::dropIfExists('registrations');
    }
}
