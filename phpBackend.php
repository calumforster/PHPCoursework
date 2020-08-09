<?php
require 'Ship.php';
session_start();
//Request Vars



switch ($_POST["action"]) {
   case 'makeBoard':
       $onload = $_POST["isPlayer"];
       break;
   case 'playerTurn':
       $playerMove = $_POST["coOrdinates"];
       break;
}
//Game Vars
$battleGrid;



//Session vars
$_SESSION["grid"];
$_SESSION["ship"];

$_SESSION["playerShip"];
$_SESSION["serverShip"];


 if (isset($onload))
{

     $ship = new Ship(); 
     $col = 5;
     $row = 5;
     for ($y = $col; $y>0 ; $y--) {
    for($x = 1; $x<=$row; $x++){
        $battleGrid[$x][$y] = 0;        
    }
    }     
    $shipPlaced = false; 
    while(!$shipPlaced){
        $randX = rand(1,$col);
        $randY = rand(1,$row);
        
        if($randX < $col-1){
            $ship->point[0] = $randX . "," . $randY;
            $ship->point[1] = $randX+1 . "," . $randY;
            $shipPlaced = true;
            if($onload == "true"){
                $_SESSION["playerShip"] = $ship;                
            }else{
                $_SESSION["serverShip"] = $ship;
            }
        }
    } 
     header('Content-Type: application/json');
    $return_data=array('ship'=>$ship,'size'=>$col);
    echo json_encode($return_data);
      
     $_SESSION["grid"] = $battleGrid;
  
} 

 if (isset($playerMove))
{
     
     $ship = $_SESSION["serverShip"];
     $return_data=array('isHit'=> 1,'pointHit'=>$playerMove,'isDestroyed'=> $ship->isDestroyed);       
     for($i = 0; $i < $ship->length; $i++){
         if($playerMove == $ship->point[$i]){
             $ship->hitScore++;
             $return_data=array('isHit'=> "Hit",'pointHit'=>$ship->point[$i],'isDestroyed'=> $ship->isDestroyed);             
         }
           
        if($ship->hitScore == $ship->length){
                $ship->isDestroyed = true;        
            $return_data=array('isHit'=> "Hit",'pointHit'=>$ship->point[$i],'isDestroyed'=> $ship->isDestroyed);
         
     }
         
     }
   
     

    
       echo json_encode($return_data); 
     
     }
  
    
     
     
    


?>


