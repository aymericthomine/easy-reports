<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('contact_id')->nullable();
            $table->string('name',100)->nullable();
            $table->string('ip',40)->nullable();
            $table->string('ip_user', 40)->nullable();
            $table->string('ip_for', 40)->nullable();
            $table->string('accept_language',50)->nullable();
            $table->string('country',50)->nullable();
            $table->string('region',50)->nullable();
            $table->string('city',50)->nullable();
            $table->string('city_lat_long',50)->nullable();
            $table->text('user_agent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trackings');
    }
}

