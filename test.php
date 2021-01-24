<?php
  $conn = mysqli_connect("localhost", "gamerea_cubeoutt", "gamerea_cubeout", "cubeoutmagi");
  
  $sql_new = "UPDATE scoreboard SET cityName = '$city' WHERE id = $id;";
?>