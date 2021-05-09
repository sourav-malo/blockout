<?php
  header('Content-type: application/json');

  include_once '../config/Database.php';
  include_once '../models/Scoreboard.php';
  include_once '../php/datetime.php';

  define('MAX_ROWS_PER_PAGE', 100);

  // Instantiate DB & Connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Scoreboard Object
  $scoreboard = new Scoreboard($db);

  // Get raw pasted data
  $data = json_decode(file_get_contents('php://input'));

  // Set Properties
  $scoreboard->gameSetPattern = '%'.$data->setValue.'%';
  $scoreboard->gamePitPattern = '%'.$data->pitValue.'%';
  $scoreboard->gameLevelPattern = '%'.$data->levelValue.'%';
  $scoreboard->countryNamePattern = '%'.$data->countriesValue.'%';
  $scoreboard->cityNamePattern = '%'.$data->citiesValue.'%';
  $scoreboard->devicePattern = '%'.$data->deviceValue.'%';
  $scoreboard->selectedColumn = $data->selectedColumn;
  $scoreboard->selectedColumnSortType = $data->selectedColumnSortType;
  $scoreboard->pageNoValue = (int) $data->pageNoValue == 0 ? 1 : (int) $data->pageNoValue;

  $scoreboard->maxRowsPerPage = constant('MAX_ROWS_PER_PAGE');

  // Get all scores stmt (per page)
  $stmt = $scoreboard->readPage();

  // If there's no row
  if(!$stmt->rowCount()) {
    echo json_encode(['status' => 'failure']);
    exit();
  }

  // Instantiate result array
  $result = [];

  // Get each of the rows
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dateTime = new DatetimeConversion($row['playedAt']);
    $row['playedAt'] = $dateTime->getDate().' at '.substr($row['playedAt'], 11, 5);

    $row['cityName'] = empty($row['cityName']) ? 'Gamer Position' : $row['cityName'];

    $result[] = [
      'playerName' => $row['playerName'],
      'gameSet' => $row['gameSet'],
      'gamePit' => $row['gamePit'],
      'gameLevel' => $row['gameLevel'],
      'playerScore' => $row['playerScore'],
      'playedAt' => $row['playedAt'],
      'countryName' => $row['countryName'],
      'cityName' => $row['cityName'],
      'PC_Phone' => $row['PC_Phone'],
      'ipAddress' => $row['ipAddress']
    ];
  }

  // Get all scores stmt
  $stmt = $scoreboard->read();

  // Get all scores count
  $allScoresCount = $stmt->rowCount();

  echo json_encode([
    'status' => 'success', 
    'data' => [
      'maxRowsPerPage' => constant('MAX_ROWS_PER_PAGE'),
      'totalRows' => $allScoresCount,
      'totalPages' => ceil($allScoresCount / constant('MAX_ROWS_PER_PAGE')),
      'currentPageNo' => $scoreboard->pageNoValue,
      'scoresInCurrentPage' => $result
    ]
  ]);
?>