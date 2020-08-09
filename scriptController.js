// A $( document ).ready() block.
$( document ).ready(function() {
    
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

  gridSize = data.size;
  ship = data.ship;
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
  buildGrid(gridSize, ship, false);
  alert(JSON.stringify(data));
  
});  
});  
});   





function buildGrid(size, ship, isPlayer){
     var col = size;
    var row = size;
    var dyn_table = '<form id="help" action="" method="POST" > <div id="board"> <table border="1" cellpadding="10">';
for (var y = col; y>0 ; y--) {
    dyn_table += '<tr>';
    for(var x = 1; x<=row; x++){
        if(isPlayer){
            if((ship.point[0] == x+","+y) || (ship.point[1] == x+","+y)){
                dyn_table += "<td><input class ='shipButt' name='submit' type='button' value='"+x+","+y+"' id='"+x+","+y+"'</input></td>";
            }else{
            dyn_table += "<td><input class ='butt' name='submit' type='button' value='"+x+","+y+"' id='"+x+","+y+"'</input></td>";
        }
        }else{
            dyn_table += "<td><input class ='butt' name='submit' type='button' onClick=changeCol("+x+","+y+") value='"+x+","+y+"' id='"+x+","+y+"'</input></td>"; 
    }
    }
}
dyn_table += '</tr></table> </div> </form>';

if(isPlayer){
    $("#playerGrid").append(dyn_table);
    
}else{
    $("#enemyGrid").append(dyn_table);
}   
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
      }else if(v.isDestroyed == true){
          alert("You Won!");
          id.style.backgroundColor="red";
          location.reload();
           return false;
      }else{
          alert("You Hit!");
          id.style.backgroundColor="red";
      }
      
      
      
      
  });
 
};