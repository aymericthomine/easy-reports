<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_templates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 30);
            $table->string('subject_1_fr', 50)->nullable();
            $table->string('subject_2_fr', 50)->nullable();
            $table->string('subject_1_en', 50)->nullable();
            $table->string('subject_2_en', 50)->nullable();
            $table->string('greetings_1_fr', 20)->nullable();
            $table->string('greetings_2_fr', 20)->nullable();
            $table->string('greetings_1_en', 20)->nullable();
            $table->string('greetings_2_en', 20)->nullable();
            $table->text('line1_1_fr')->nullable();
            $table->text('line1_2_fr')->nullable();
            $table->text('line1_1_en')->nullable();
            $table->text('line1_2_en')->nullable();
            $table->text('line2_1_fr')->nullable();
            $table->text('line2_2_fr')->nullable();
            $table->text('line2_1_en')->nullable();
            $table->text('line2_2_en')->nullable();
            $table->string('salutations_1_fr', 20)->nullable();
            $table->string('salutations_2_fr', 20)->nullable();
            $table->string('salutations_1_en', 20)->nullable();
            $table->string('salutations_2_en', 20)->nullable();
            $table->string('view_1_fr', 20)->nullable();
            $table->string('view_2_fr', 20)->nullable();
            $table->string('view_1_en', 20)->nullable();
            $table->string('view_2_en', 20)->nullable();
            $table->string('attachment_fr', 100)->nullable();
            $table->string('attachment_en', 100)->nullable();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->boolean('unsubscribe')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_templates');
    }
}
