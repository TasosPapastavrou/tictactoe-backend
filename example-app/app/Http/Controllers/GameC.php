<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\GameMoves;
use Illuminate\Http\Request;


//h klasi opou eklelite to game
//ena mikro sxolio deen duskoleutika sto na oloklirwsw auth thn askhsh
//to mono pou den exw kanei einnai na balw enan elgxo sta Request pou pairnoun oi functions apo ta dedomena pou sttelnw logo oti einai
//fix oi metablites pou stelnw
class GameC extends Controller
{
    //o pinakas opoou apo thikeuei tis kinisis twn paixtwn
    public $table = [0,0,0,0,0,0,0,0,0];
    //o pinakas opou tha elegxo me ton apo panw gia na dw ean uparxei nikitis
    public $winnerTable =   [[0,1,2],
                            [3,4,5],
                            [6,7,8],
                            [0,3,6],
                            [1,4,7],
                            [2,5,8],
                            [0,4,8],
                            [2,4,6]
                            ]; 

    // to idio me ton pinaka table telika to ekana me diaforetiko tropo
    public $Mtable=[[0,0,0],
                    [0,0,0],
                    [0,0,0]]; 

    //h sunartisi epistresi to teleutaio game ean upaarxei                
    public function showLastGame(){
    
        //epistrefw ola ta games pou exoun paixei
        $t=Game::all();
    
        $l=count($t);

        $show=[         
            "user1"=>"empty",
            "user2"=>"empty", 
            "winner"=>"empty",        
            "moves"=>[]         
        ];
    
        //ean uparxei ftiaxnw enan pinaka opou stelnw ta katalila dedomena
        if($l>0){            
            $t2=Game::find($l);    
            $m=Game::find($l)->moves;         
            $show=[         
                "user1"=>$t2->user1,
                "user2"=>$t2->user2, 
                "winner"=>$t2->winner,        
                "moves"=>$m         
            ];
            return $show;    
            }
        else{
            return $show;
            }         
        }

    //apothikeuw ta onomata twn xristwwn otan patisoun to koumpi play kai epistrfw to id tou game
    public function CreateGame(Request $request){
    $game = new Game();
    $game->user1=$request->u1;
    $game->user2=$request->u2;
    $game->winner="null";
    $game->save();   
    return $game->id;
} 


///otan jekinaei na to paixnidi epistrefi kapoies times giaa na arxikopoihsh to table thn
///triliza me times 0
public function StarTheGame($rid){

    $message = [
        "winner"=>"empty",
        "step"=>"continue" 
    ];  
    $game = Game::find($rid);
    $u1=$game->user1;
    $u2=$game->user2;

    $gameBegin = [
        "id"=>$rid,
        "user1"=>$u1,
        "user2"=>$u2,
        "table"=>$this->table,
        "message"=>$message        
    ];

    return $gameBegin; 
}


public function domove($id,Request $request){

    ///brisko to game opou paizete twra
    // dimiourgo ena neo obj gia mia nea kinisi apothikeuw tiss times
    $game=Game::find($id);
    $nm = new GameMoves();
    $nm->move=$request->mov;
    $nm->position=$request->pos;
    $nm->game_id=$id;
    $game->moves()->save($nm);         
   
    //epistrfw tis kinisis pou exoun ginei se auto to game
    $allm = Game::find($id)->moves;
    //metraw poses exw kanei
    $count = count($allm);

    //tajinomo ton pinaka table gia na epistrojo me sira ton pikana pou tha emfanisti sto front
    for($i=0;$i<$count && $i<9;$i++){ 
        $posi=$allm[$i]->position;
        $this->table[$posi]=$allm[$i]->move;             
    }  
    
    //kanw elegxw ean uparxei nikitis 123 grammi eews 158 
    $char=$request->mov;
    $sum=0;
    $message = [
        "winner"=>"empty",
        "step"=>"continue" 
    ];
     
    for($i=0;$i<8;$i++){
        $sum=0;
        for($j=0;$j<3;$j++){
            $counnt = $this->winnerTable[$i][$j];
            $val= $this->table[$counnt];
            if(!is_int($val))
            if($char==$this->table[$counnt]){
                $sum++;
            }
        }
        //otan uparxei nikitis apothikeuw to onoma tou sthn engrafi tis basis dedomenwn me to onoma tou epipleon etimazw antistixo mnm
        if($sum==3){
            $message = [
                "winner"=>"winner is ".$request->mov,
                "step"=>"stop" 
            ];
            if($char=='x')
            {  
                $game=Game::find($id);
                $game->winner=$game->user1;
                $game->save();
            }else{ 
                $game=Game::find($id);
                $game->winner=$game->user2;
                $game->save();
            }
            break;
        }
    
    } 

    //telos ean den uparxei nikitis kai exei ftasi h teleutea kinisi stelnw antistixo minima gia thn isopalia
   
    
    $cc = strlen($message["winner"]);
    $cr =  count(Game::find($id)->moves);

//ean wwinner einai empty kai round 9 draw
 if($cc==5 And $cr==9){
    $game=Game::find($id);
    $game->winner="Draw";
    $game->save();

    $message = [
        "winner"=>"Draw",
        "step"=>"continue" 
    ];
 }


    $gameBegin = [ 
        "table"=>$this->table,
        "message"=>$message,    
    ];

  
     return $gameBegin; 
}



































}