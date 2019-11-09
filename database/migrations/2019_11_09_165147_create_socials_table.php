<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("type")->nullable();
            $table->string("auth_url")->nullable();
            $table->string("secret_id")->nullable();
            $table->string("secret_key")->nullable();
            $table->string("service_key")->nullable();
            $table->timestamps();
        });

        Schema::create('social_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('social_id');
            $table->foreign('social_id')->references('id')->on('socials');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string("temp_code")->nullable();
            $table->string("access_token")->nullable();
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
        Schema::dropIfExists('social_user');
        Schema::dropIfExists('socials');
    }
}
