<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewals', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('registration_id');
            $table->integer('form_id');
            $table->string('type');
            $table->integer('renewal_year');
            $table->date('expires_at');
            $table->string('licence')->nullable();
            $table->string('status');
            $table->string('renewal')->default(true);
            $table->boolean('payment')->default(false);
            $table->longtext('query')->nullable();
            $table->string('token')->nullable();
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
        Schema::dropIfExists('renewals');
    }
}
