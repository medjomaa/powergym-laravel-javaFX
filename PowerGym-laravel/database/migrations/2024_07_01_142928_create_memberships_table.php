<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->enum('membership_type', ['monthly', 'quarterly', 'yearly']);
            $table->enum('paid', ['0', '1']);
            $table->timestamps();
            $table->softDeletes(); // Assuming you want soft deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('memberships');
    }
}
