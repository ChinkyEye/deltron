<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kista_id');
            $table->foreign('kista_id')->references('id')->on('kistas'); 
            $table->unsignedBigInteger('luckydraw_id');
            $table->foreign('luckydraw_id')->references('id')->on('lucky_draws');
            $table->string('title');
            $table->string('amount');
            $table->string('date_np',10);
            $table->string('date',10);
            $table->string('time',8);
            $table->boolean('is_active')->default(True);
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
        Schema::dropIfExists('expenses');
    }
}
