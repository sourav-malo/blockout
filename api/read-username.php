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
  $scoreboard->playerName = $data->playerName;

  // Get all rows stmt
  $stmt = $scoreboard->readSingleByName();

  if(!$stmt->rowCount()) {
    echo json_encode(['status' => 'failure']);
    exit();
  }

  echo json_encode(['status' => 'success']);
?>