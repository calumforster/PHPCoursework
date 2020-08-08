<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<?php
$row = 5;
$col = 5;

$dyn_table = '<form id="help" action="" method="POST" > <div id="board"> <table border="1" cellpadding="10">';
for ($y = $col; $y>0 ; $y--) {
    $dyn_table .= '<tr>';
    for($x = 1; $x<=$row; $x++){
        $dyn_table .= '<td><input class ="butt" name="submit" type="button" ' ."value=". "$x,$y ".'' ."id=". "$x,$y ".'' ."onClick=changeCol($x,$y) ". "$x,$y>". "$x , $y " . '</input></td>';
        
    }
}


    
$dyn_table .= '</tr></table> </div> </form>';

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <title></title>
        
        <script>
function changeCol(x,y) {
    var id = document.getElementById(x+","+y);
     id.style.backgroundColor="red";
 
}
req.fail(function(jqXHR, textStatus) {
  alert( "Request failed: " + textStatus );
});

  
});
        </script>
    </head>
    <body>
        
      
<?php

  $x = $_POST["xValue"];
 $y = $_POST["yValue"];
 
 header('Content-Type: application/json');
 
 
 if (isset($x) && isset($y))
{
  echo json_encode("$x,$y");
} 
else 
{
  $user = null;
  echo json_encode("no username supplied");
}
?>
    </body>
</html>
