<?php
  include_once '../config/Database.php';
  include_once '../models/Scoreboard.php';

  // Instantiate DB & Connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Scoreboard Object
  $scoreboard = new Scoreboard($db);

  // Set Properties
  $scoreboard->gameSetPattern = '%'.$_POST['setValue'].'%';
  $scoreboard->gamePitPattern = '%'.$_POST['pitValue'].'%';
  $scoreboard->gameLevelPattern = '%'.$_POST['levelValue'].'%';
  $scoreboard->countryNamePattern = '%'.$_POST['countriesValue'].'%';
  $scoreboard->cityNamePattern = '%'.$_POST['citiesValue'].'%';
  $scoreboard->devicePattern = '%'.$_POST['deviceValue'].'%';

  // Get All Scores
  $result = $scoreboard->read();

  echo ceil($result->rowCount() / 200);
?>