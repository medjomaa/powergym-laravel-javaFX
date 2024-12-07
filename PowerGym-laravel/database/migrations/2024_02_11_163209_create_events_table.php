<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('type');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('coach_id'); // Keep coach_id as unsigned big integer
            $table->unsignedBigInteger('room_id'); // Keep room_id as unsigned big integer
            $table->timestamps();

            
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
