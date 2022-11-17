<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title');
            $table->dateTime('schedule_at');
            $table->longText('body')->nullable();
            $table->boolean('finished')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->boolean('answered')->nullable();
            $table->string('response_message')->nullable();
            $table->longText('response_body')->nullable();
            $table->unsignedBigInteger('interection_id')->nullable();
            $table->foreign('interection_id')->references('id')->on('interections');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->foreign('animal_id')->references('id')->on('animals');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
