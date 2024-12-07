<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGymSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('gym_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->time('time');
            $table->string('class_type');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gym_schedules');
    }
}
