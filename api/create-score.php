<?php
  header('Content-type: application/json');

  include_once '../config/Database.php';
  include_once '../models/Scoreboard.php';
  include_once '../php/datetime.php';

  // Instantiate DB & Connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Scoreboard Object
  $scoreboard = new Scoreboard($db);

  // Get raw pasted data
  $data = json_decode(file_get_contents('php://input'));

  // Set Properties
  $scoreboard->playerName = $data->playerName;
  $scoreboard->gameSet = $data->gameSet;
  $scoreboard->gamePit = $data->gamePit;
  $scoreboard->gameLevel = $data->gameLevel;
  $scoreboard->playerScore = $data->playerScore;
  $scoreboard->getIPAddress();
  $scoreboard->getCityName();
  $scoreboard->getCountryName();
  $scoreboard->PC_Phone = $data->PC_Phone;

  // Exit if score insertion fails
  if(!$scoreboard->create()) {
    echo json_encode(['status' => 'failure', 'message' => 'Error saving the score']);
    exit();
  }

  $scoreboard->id = intval($db->lastInsertId());

  // Get last inserted row stmt
  $stmt = $scoreboard->readSingleByID();

  // Exit if no score found
  if(!$stmt->rowCount()) {
    echo json_encode(['status' => 'failure', 'message' => 'Error getting the score']);
    exit();
  }

  // Get last inserted row 
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  $datetime = new DatetimeConversion($row['playedAt']);
  $readableDatetime = $datetime->getDate().' at '.$datetime->getTime();

  echo json_encode([
    'status' => 'success',
    'data' => [
      'id' => $row['id'],
      'playedAt' => $readableDatetime,
      'countryName' => $row['countryName'],
      'ipAddress' => $row['ipAddress']
    ]
  ]);
?>
