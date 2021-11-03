<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceFeeMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_fee_metas', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->string('description');
            $table->float('amount', 10, 2)->nullable();
            $table->float('registration_fee', 10, 2)->nullable();
            $table->float('inspection_fee', 10, 2)->nullable();
            $table->float('location_fee', 10, 2)->nullable();
            $table->float('renewal_fee', 10, 2)->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('service_fee_metas');
    }
}
