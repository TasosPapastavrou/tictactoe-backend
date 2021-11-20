<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //oi metavlites t table game moves opou apothikeuontai oi kinisis twn xristwn 
    //apothikeuw thn kinisi pou kanei poios thn kanei to id tou game kai to id tou move
    public function up()
    {
        Schema::create('game_moves', function (Blueprint $table) {
            $table->id();
            $table->string('move');            
            $table->integer('position');
            $table->unsignedBigInteger('game_id'); 
            $table->timestamps(); 
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_moves');
    }
}
