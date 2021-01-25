<?php
  $conn = mysqli_connect("localhost", "root", "", "__scoreboard");
  
  $sql = "SELECT * FROM scoreboard WHERE cityName IS NULL LIMIT 10;";

  $result = mysqli_query($conn, $sql);

  echo mysqli_num_rows($result);

  while($row = mysqli_fetch_assoc($result)) {
    $id = $row["id"];
    $ipAddress = $row["ipAddress"];

    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ipAddress)); 

    $city = $ipdat->geoplugin_city;
    
    $sql_one = "UPDATE scoreboard SET cityName = '$city' WHERE id = $id;";

    mysqli_query($conn, $sql_one);
  }
?>