<?php
  $conn = mysqli_connect("localhost", "gamerea_cubeoutt", "gamerea_cubeout", "cubeoutmagi");
  $sql = "SELECT * FROM scoreboard WHERE cityName = '';";
  $result = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_assoc($result)) {
    $id = $row["id"];
    $ip = trim($row["ipAddress"]);

    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

    $city = $ipdat->geoplugin_city;

    $sql_new = "UPDATE scoreboard SET cityName = '$city' WHERE id = $id;";
    mysqli_query($conn, $sql_new);
  }
?>