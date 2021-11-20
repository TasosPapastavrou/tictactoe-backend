<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//glasi GameMoves me kataxorisi to table tis basis apo to migr kai to relationship one to many
class GameMoves extends Model
{
    use HasFactory;

    protected $table="game_moves";
    protected $fillable = [
        'move',
        'position',
        'game_id',
    ];
    public function game(){
        return $this->belongsTo(Game::class);
    }
}
