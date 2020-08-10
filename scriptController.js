// A $( document ).ready() block.
$( document ).ready(function() {
    
    var req = $.ajax({
    url: "phpBackend.php",
    type: 'POST',
    data: {
        action : "setGrid",
    }});
    
    var ship;
    var gridSize;
    
    var req = $.ajax({
    url: "phpBackend.php",
    type: 'POST',
    data: {
        action : "makeBoard",
        isPlayer : true
    }});
        
  req.done(function ( data ) {    
   
            alert(JSON.stringify(data));
        
  gridSize = data.size;
  ship = data.ship;
  ship = data.ship.slice(0, data.ship.length);
  alert(JSON.stringify(data.ship[0]));
  buildGrid(gridSize, ship, true);
  
  var req2 = $.ajax({
    url: "phpBackend.php",
    type: 'POST',
    data: {
        action : "makeBoard",
        isPlayer : false
    }});
        
  req2.done(function ( data ) {

  gridSize = data.size;
  ship = data.ship;
  ship = data.ship.slice(0, data.ship.length);
  buildGrid(gridSize, ship, false);
  
  
});  
});  
});   





function buildGrid(size, ship, isPlayer){
     var col = size;
    var row = size;
    var shipPlaced = false;
    console.log("Ship length"+JSON.stringify(ship.length));
    
    let grid = new Array(col);
            for (var i = 0; i < col; i++) {
                grid[i] = new Array(row);
    }
    
    console.log("ship 1",ship[1]);
    for (var i = 0; i < ship.length; i++) {
            for (var j = 0; j < ship[i].point.length; j++) {
               
            let coOrdinates = ship[i].point[j].split(","); 
            console.log(coOrdinates);
            grid[coOrdinates[1]-1][coOrdinates[0]-1] = 1;
        }        
    
    }
    console.log("Shite code: ", JSON.stringify(grid));
    
    var dyn_table = '<form id="help" action="" method="POST" > <div id="board"> <table border="1" cellpadding="10">';
    for (var y = col-1; y>=0 ; y--) {
    dyn_table += '<tr>';
    for(var x = 0; x<row; x++){
    
    if(isPlayer){
        if(grid[y][x] == 1){
          dyn_table += "<td><input class ='shipButt' name='submit' type='button' value='"+(x+1)+","+(y+1)+"' id='Player:"+(x+1)+","+(y+1)+"'</input></td>";  
        }else{
            dyn_table += "<td><input class ='butt' name='submit' type='button' value='"+(x+1)+","+(y+1)+"' id='Player:"+(x+1)+","+(y+1)+"'</input></td>";
        }      
    }else{
        dyn_table += "<td><input class ='butt' name='submit' type='button' onClick=changeCol("+(x+1)+","+(y+1)+") value='"+(x+1)+","+(y+1)+"' id='"+(x+1)+","+(y+1)+"'</input></td>";
    }
            
        
        }
    }
    
    
    
    dyn_table += '</tr></table> </div> </form>';

    if(isPlayer){
    $("#playerGrid").append(dyn_table);
    
}else{
    $("#enemyGrid").append(dyn_table);
}
    
    
    
//    var dyn_table = '<form id="help" action="" method="POST" > <div id="board"> <table border="1" cellpadding="10">';
//for (var y = col; y>=0 ; y--) {
//    dyn_table += '<tr>';
//    for(var x = 0; x<=row; x++){
//        if(isPlayer){
//            shipPlaced = false;
//                for (var z = 0; z < ship.length; z++) {
//                    
//                //console.log(ship[z].point.length);
//                for (var i = 0; i < ship[z].point.length; i++) {
//                    if(((x+1)+","+(y+1)) == ship[z].point[i]){
//                        dyn_table += "<td><input class ='shipButt' name='submit' type='button' value='"+(x+1)+","+(y+1)+"' id='Player:"+(x+1)+","+(y+1)+"'</input></td>";
//                     shipPlaced = true;
//                    } else if(!shipPlaced && (i == (ship[z].point.length-1))){
//                        dyn_table += "<td><input class ='butt' name='submit' type='button' value='"+(x+1)+","+(y+1)+"' id='Player:"+(x+1)+","+(y+1)+"'</input></td>";
//                    
//                }
//                }
//                
//                } 
//           
//        }else{
//            dyn_table += "<td><input class ='butt' name='submit' type='button' onClick=changeCol("+(x+1)+","+(y+1)+") value='"+(x+1)+","+(y+1)+"' id='"+(x+1)+","+(y+1)+"'</input></td>"; 
//    }
//    }
//}
//dyn_table += '</tr></table> </div> </form>';
//
//if(isPlayer){
//    $("#playerGrid").append(dyn_table);
//    
//}else{
//    $("#enemyGrid").append(dyn_table);
//}   
}
    

function changeCol(x,y) {
    var id = document.getElementById(x+","+y);
    
        var req = $.ajax({
    url: "phpBackend.php",
    type: 'POST',
    data: {
        action : "playerTurn",
        coOrdinates : x+","+y
    }});
        
  req.done(function ( data ) {
      var v = JSON.parse(data);
      if(v.isHit == 1){
          id.style.backgroundColor="white";
          alert("You Miss!");
          serverHit();
      }else if(v.isDestroyed == true){
          alert("You Won!");
          id.style.backgroundColor="red";
          location.reload();
           return false;
      }else{
          alert("You Hit!");
          id.style.backgroundColor="red";
          serverHit();
      }
      
      
      
      
  });
 
};

function serverHit() {
    
     var req = $.ajax({
    url: "phpBackend.php",
    type: 'POST',
    data: {
        action : "serverTurn",
    }});
      
        req.done(function ( data ) {
              var v = JSON.parse(data);
               var id = document.getElementById("Player:"+v.pointHit);
      if(v.isHit == 1){
          id.style.backgroundColor="white";
          alert("Server Miss!");
      }else if(v.isDestroyed == true){
          alert("Server Won!");
          id.style.backgroundColor="red";
          location.reload();
           return false;
      }else{
          alert("Server Hit!");
          id.style.backgroundColor="red";
      }
      
      
      
      
  });
    
};