<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('company_id')->nullable()->index();
            $table->string('class', 10)->nullable();
            $table->string('role', 10)->nullable()->default('Guest');
            $table->string('country', 3)->nullable()->default('FR');
            $table->tinyInteger('proximity')->nullable()->default(1);
            $table->string('gender', 5)->nullable();
            $table->string('firstname', 30)->nullable();
            $table->string('name', 30);
            $table->string('email', 50)->unique();
            $table->string('email_status', 10);
            $table->string('operation', 30);
            $table->string('category', 30);
            $table->text('comments');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->timestamp('rgpd_accepted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
