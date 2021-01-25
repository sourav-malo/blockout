<?php
  include_once '../config/Database.php';
  include_once '../models/Scoreboard.php';
  include_once '../php/datetime.php';

  // Instantiate DB & Connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Scoreboard Object
  $scoreboard = new Scoreboard($db);

  // Set Properties
  $scoreboard->gameSetPattern = '%'.$_POST['setValue'].'%';
  $scoreboard->gamePitPattern = '%'.$_POST['pitValue'].'%';
  $scoreboard->gameLevelPattern = '%'.$_POST['levelValue'].'%';
  $scoreboard->devicePattern = '%'.$_POST['deviceValue'].'%';

  // Get All Scores
  $result = $scoreboard->read();

  // If There's More Than One Row
  if($result->rowCount()) {
    $countRow = 1; // Variable for Counting Row

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      if($countRow == 1) {
        echo '<div class="sb-row first-row">';
      } else {
        echo '<div class="sb-row">';
      }

      // Getting All Values
      $playerName = $row['playerName'];
      $gameSet = $row['gameSet'];
      $gamePit = $row['gamePit'];
      $gameLevel = $row['gameLevel'];
      $playerScore = $row['playerScore'];
      $PC_Phone = $row['PC_Phone'];

      $dateTime = new DatetimeConversion($row['playedAt']);
      $date = $dateTime->getDate();
      $time = $dateTime->getTime();
      $playedAt = "$date at ".substr($row['playedAt'], 11, 5);

      $countryName = $row['countryName'];
      $ipAddress = $row['ipAddress'];

      $scoreboard->ipAddress = $ipAddress;

      $city = "Gamer Position";
      if(!empty($row['cityName'])) {
        $city = $row['cityName'];
      }

      // Preparing for the DOM
      echo '<span class="sb-col rank">
          <span class="circle">'.$countRow.'</span>
        </span>
        <span class="sb-col player">'.$playerName.'</span>
        <span class="sb-col set">'.$gameSet.'</span>
        <span class="sb-col pit">'.$gamePit.'</span>
        <span class="sb-col level">'.$gameLevel.'</span>
        <span class="sb-col score">'.$playerScore.'</span>
        <span class="sb-col played-at">'.$playedAt.'</span>
        <span class="sb-col country">'.$countryName.'</span>
        <span class="sb-col ip-address">
           <form action="location.php" method="POST">
              <input type="hidden" name="ipAddress" value="'.$ipAddress.'">
              <button class="ip-address-btn">'.$city.'</button>
           </form>
        </span>
        <span class="sb-col pc_phone">'.$PC_Phone.'</span>
      </div>';

      $countRow++;
    }
  }
?>