<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanniersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banniers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->timestamps();

            $table->unsignedInteger('id_client');
            $table->foreign('id_client')->references('id')->on('client_banners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banniers');
    }
}
