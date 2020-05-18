<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('pri_func_id')->unsigned();
            $table->bigInteger('sec_func_id')->unsigned()->nullable();
            $table->string('description')->nullable();
            $table->float('distance')->nullable();
            $table->float('cost');
            $table->bigInteger('unit_cost_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('pri_func_id')
                ->references('id')
                ->on('funcs')
                ->onDelete('cascade');
            $table->foreign('sec_func_id')
                ->references('id')
                ->on('funcs')
                ->onDelete('cascade');
            $table->foreign('unit_cost_id')
                ->references('id')
                ->on('unit_costs')
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
        Schema::dropIfExists('resources');
    }
}
