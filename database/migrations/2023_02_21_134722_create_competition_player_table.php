<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('competition_player', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('competition_id');
            $table->unsignedBigInteger('player_id');
            $table->integer('score')->unsigned()->default(0);

            $table->foreign('competition_id')->references('id')->on('competitions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['competition_id', 'player_id']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('competition_player');
    }
};
