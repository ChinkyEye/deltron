<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            // $table->float('commission', 8, 2);
            $table->string('date_np',10);
            $table->string('date',10);
            $table->string('time',8);
            $table->integer('is_head')->nullable(); //for head agent who created it
            $table->boolean('is_active')->default(True);
            // $table->unsignedBigInteger('kista_id');
            // $table->foreign('kista_id')->references('id')->on('kistas');
            // $table->unsignedBigInteger('luckydraw_id');
            // $table->foreign('luckydraw_id')->references('id')->on('lucky_draws');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('agents');
    }
}
