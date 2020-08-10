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
   case 'serverTurn':
       $serverMove = $_POST["action"];
       break;
   case 'setGrid':
       $setGridSize = $_POST["action"];
       break;
}



//Game Vars
$battleGrid;



//Session vars
$_SESSION["grid"];
$_SESSION["ship"];


$_SESSION["gridSize"];
$_SESSION["amountOfShips"];

if(!isset($_SESSION["playerShip"])){
    $_SESSION["playerShip"] = array(); 
}

if(!isset($_SESSION["serverShip"])){
    $_SESSION["serverShip"] = array(); 
}



//$_SESSION["serverMoves"];

if (isset($setGridSize)){
    
    $_SESSION["gridSize"] = rand(5,9);
    $_SESSION["amountOfShips"] = rand(1,3);
}

 if (isset($onload))
{
//$_SESSION["playerShip"] = array(); 
//$_SESSION["serverShip"] = array(); 
     
     $ship[] = array(); 
     $returnShip = array();
     $col = $_SESSION["gridSize"];
     $row = $_SESSION["gridSize"];
     
     
     for ($y = $col; $y>0 ; $y--) {
    for($x = 1; $x<=$row; $x++){
        $battleGrid[$x][$y] = 0;        
    }
    }     
    $shipPlaced = false; 
    
   for ($ships = 0 ; $ships < $_SESSION["amountOfShips"] ; $ships++){       
       $tempShip = new Ship();

            while(!$shipPlaced){
       $randX = rand(1,$col);
       $randY = rand(1,$row);        
        $tempShip->orientation = rand(0,1);
        $tempShip->shipLength = rand(1,3);
       
       if($tempShip->orientation == 0){
                    if($randX < $col-($tempShip->shipLength)){
                        for($i =0; $i<$tempShip->shipLength; $i++){
                            
                           $tempShip->point[$i] = $randX+$i . "," . $randY;
                        }
             if(checkPlacement($tempShip, $onload)){
                         $shipPlaced = true;
  
            if($onload == "true"){
                $ship[$ships] = $tempShip;
                array_push($returnShip,$tempShip);
                
       
            }else{
                $ship[$ships] = $tempShip;
                array_push($returnShip,$tempShip);

            }    
                 
             }           

        }
        }else{
            if($randY < $row-($tempShip->shipLength)){
            for($i =0; $i<$tempShip->shipLength; $i++){
             $tempShip->point[$i] = $randX . "," . ($randY+$i);
                       }
             if(checkPlacement($tempShip, $onload)){
                         $shipPlaced = true;
  
            if($onload == "true"){
                $ship[$ships] = $tempShip;
                array_push($returnShip,$tempShip);
                
       
            }else{
                $ship[$ships] = $tempShip;
                array_push($returnShip,$tempShip);

            }    
                 
             }
        }
        }
        
    }

       $shipPlaced = false;
   }
   
   if($onload == "true"){
   $_SESSION["playerShip"] = $ship;
   }else{
      $_SESSION["serverShip"] = $ship;
   }
    
 
     header('Content-Type: application/json');
    $return_data=array('ship'=>$returnShip,'size'=>$col);
    echo json_encode($return_data);
      
     $_SESSION["grid"] = $battleGrid;
  
}


function checkPlacement($passedShip,$isPlayer){
    
    if($isPlayer){
        if(isset($_SESSION["playerShip"])){
            for ($i = 0; $i< count($_SESSION["playerShip"]); $i++){
                for($j = 0; $j < $_SESSION["playerShip"][$i]->shipLength; $j++){
                    for($z = 0; $z < count($passedShip->point); $z++){
                    if($_SESSION["playerShip"][$i]->point[$j] == $passedShip->point[$z]){
                    return false;
                    }
                    }
                }  

            }
        }
    }else{
        if(isset($_SESSION["serverShip"])){
                        for ($i = 0; $i< count($_SESSION["serverShip"]); $i++){
                for($j = 0; $j < $_SESSION["playerShip"][$i]->shipLength; $j++){
                    for($z = 0; $z < count($passedShip->point); $z++){
                    if($_SESSION["playerShip"][$i]->point[$j] == $passedShip->point[$z]){
                    return false;
                    }
                    }
                }  

            }
        }
    }
    
    
    
    return true;
}

 if (isset($playerMove))
{
     
     $ship[] = $_SESSION["serverShip"];
     //$return_data=array('isHit'=> 1,'pointHit'=>$playerMove,'isDestroyed'=> $ship[0]->isDestroyed);   
//     for ($j = 0; $j<count($ship); $j++){
//              $return_data=array('isHit'=> 1,'pointHit'=>$playerMove,'isDestroyed'=> $ship[$j]->isDestroyed);       
//     for($i = 0; $i < $ship[$j]->length; $i++){
//         if($playerMove == $ship[$j]->point[$i]){
//             $ship[$j]->hitScore++;
//             $return_data=array('isHit'=> "Hit",'pointHit'=>$ship[$j]->point[$i],'isDestroyed'=> $ship[$j]->isDestroyed);             
//         }
//           
//        if($ship[$j]->hitScore == $ship[$j]->length){
//                $ship[$j]->isDestroyed = true;        
//            $return_data=array('isHit'=> "Hit",'pointHit'=>$ship[$j]->point[$i],'isDestroyed'=> $ship[$j]->isDestroyed);
//         
//     }
//         
//     }
//         
//     }

   
     

    
       echo json_encode($_SESSION["serverShip"]); 
     
     }
  
      
     
     
     if (isset($serverMove))
{
         
         $row = $_SESSION["gridSize"];
         $col = $_SESSION["gridSize"];
        $randX = rand(1,$col);
        $randY = rand(1,$row);
        $moveAttempt = $randX . "," . $randY;
        
        
     
     $ship = $_SESSION["playerShip"];
//     $return_data=array('isHit'=> 1,'pointHit'=>$moveAttempt,'isDestroyed'=> $ship->isDestroyed);       
//     for($i = 0; $i < $ship->length; $i++){
//         if($moveAttempt == $ship->point[$i]){
//             $ship->hitScore++;
//             $return_data=array('isHit'=> "Hit",'pointHit'=>$ship->point[$i],'isDestroyed'=> $ship->isDestroyed);             
//         }
//           
//        if($ship->hitScore == $ship->length){
//                $ship->isDestroyed = true;        
//            $return_data=array('isHit'=> "Hit",'pointHit'=>$ship->point[$i],'isDestroyed'=> $ship->isDestroyed);
//         
//     }
//         
//     }
      
       echo json_encode($_SESSION["playerShip"]);  
     
     }
    
     
     
    


?>


