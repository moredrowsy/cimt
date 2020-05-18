<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResIncRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_inc_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('requester_id')->unsigned();
            $table->bigInteger('requestee_id')->unsigned();
            $table->bigInteger('resource_id')->unsigned();
            $table->bigInteger('incident_id')->unsigned();
            $table->string('status');
            $table->timestamps();
            $table->foreign('requester_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('requestee_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('resource_id')
                ->references('id')
                ->on('resources')
                ->onDelete('cascade');
            $table->foreign('incident_id')
                ->references('id')
                ->on('incidents')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('res_inc_requests');
    }
}
