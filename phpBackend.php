<?php
require 'Ship.php';
//Request Vars
session_start();



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

//$_SESSION["playerShip"];
//$_SESSION["serverShip"];


if(!isset($_SESSION["playerShip"])){
    $_SESSION["playerShip"] = array(); 
}

if(!isset($_SESSION["serverShip"])){
    $_SESSION["serverShip"] = array(); 
}



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
                for($j = 0; $j < $_SESSION["serverShip"][$i]->shipLength; $j++){
                    for($z = 0; $z < count($passedShip->point); $z++){
                    if($_SESSION["serverShip"][$i]->point[$j] == $passedShip->point[$z]){
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
     
     $ship = $_SESSION["serverShip"];
     $retResult = "Miss";
     $isShipDestroyed = false;
     $point = "Miss";

    
     for ($j = 0; $j<count($ship); $j++){
                 
     for($i = 0; $i < $ship[$j]->shipLength; $i++){
         $ship[$j]->isDestroyed = false;
         if($playerMove == $ship[$j]->point[$i]){
             $ship[$j]->hitScore++;
             $retResult = "Hit";
             $point = $ship[$j]->point[$i];
                     if($ship[$j]->hitScore == $ship[$j]->shipLength){
                $ship[$j]->isDestroyed = true;
                $isShipDestroyed = true;
                $retResult = "Destroyed";
     }    
         }
           
  
  
           
     }
     }
  
               $return_data=array('ship'=>count($ship) , 'isHit'=> $retResult,'pointHit'=>$point,'isDestroyed'=> $isShipDestroyed);

       echo json_encode($return_data); 

  
}   
     
     
     if (isset($serverMove))
{
         
         $row = $_SESSION["gridSize"];
         $col = $_SESSION["gridSize"];
        $randX = rand(1,$col);
        $randY = rand(1,$row);
        $moveAttempt = $randX . "," . $randY;
            $retResult = "Miss";
            $isShipDestroyed = false;
            $point = $moveAttempt;
        
        
     
     $ship = $_SESSION["playerShip"];
     
          for ($j = 0; $j<count($ship); $j++){
                 
     for($i = 0; $i < $ship[$j]->shipLength; $i++){
         if($moveAttempt == $ship[$j]->point[$i]){
             $ship[$j]->hitScore++;
             $retResult = "Hit";
             $point = $ship[$j]->point[$i];
             $isShipDestroyed = false;
                     if($ship[$j]->hitScore == $ship[$j]->shipLength){
                $ship[$j]->isDestroyed = true;
                $isShipDestroyed = true;
                $retResult = "Destroyed";    
     }
         }
           

           
     }
     }
               $return_data=array('isHit'=> $retResult,'pointHit'=>$point,'isDestroyed'=> $isShipDestroyed);
       echo json_encode($return_data);
     
      
     
     }
    
     
     
    


?>


