<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignNotifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_notifs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('campaign_id')->index();
            $table->foreignId('contact_id')->index();
            $table->tinyInteger('sent')->default(0);
            $table->tinyInteger('open')->default(0);
            $table->tinyInteger('click')->default(0);
            $table->tinyInteger('bounce')->default(0);
            $table->tinyInteger('spam')->default(0);
            $table->tinyInteger('blocked')->default(0);
            $table->tinyInteger('unsub')->default(0);
            $table->text('request')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_notifs');
    }
}
