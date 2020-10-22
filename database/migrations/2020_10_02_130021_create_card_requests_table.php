<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('requested_to');
            $table->integer('requester_id');
            $table->integer('card_type_id');
            $table->integer('payment_type_id');
            $table->integer('amount');
            $table->string('status')->default('on_progress');
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
        Schema::dropIfExists('card_requests');
    }
}
