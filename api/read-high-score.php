<?php
  header('Content-type: application/json');

  include_once '../config/Database.php';
  include_once '../models/Scoreboard.php';

  // Instantiate DB & Connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Scoreboard Object
  $scoreboard = new Scoreboard($db);

  // Get raw pasted data
  $data = json_decode(file_get_contents('php://input'));

  // Set Properties
  $scoreboard->gameSet = $data->gameSet;
  $scoreboard->gamePit = $data->gamePit;
  $scoreboard->gameLevel = $data->gameLevel;

  // Get high score stmt
  $stmt = $scoreboard->readHighScore();

  // Exit if no score found
  if(!$stmt->rowCount()) {
    echo json_encode(['status' => 'failure', 'message' => 'Error getting the high score']);
    exit();
  }

  // Get high score row
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  echo json_encode(['status' => 'success', 'data' => $row['high_score']]);
?>