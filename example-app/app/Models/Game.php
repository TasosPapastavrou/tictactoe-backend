<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//glasi game me kataxorisi to table tis basis apo to migr kai to relationship one to many gia nna pernw kkai apothikeuw ta moves twn xristwn
class Game extends Model
{
    use HasFactory;

    protected $table="games";
    protected $fillable = [
        'user1',
        'user2',
        'winner',
    ];
    public function moves(){
        return $this->hasMany(GameMoves::class);
    }
}
