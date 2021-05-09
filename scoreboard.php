<?php
  include_once 'config/Database.php';
  include_once 'models/Scoreboard.php';

  // Instantiate DB & Connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Scoreboard Object
  $scoreboard = new Scoreboard($db);
?>

<!DOCTYPE html>
<html style="font-family: 'Roboto', sans-serif;">
<head>
  <meta name="description" content="Remake of classic puzzle game Blockout (3d tetris) in HTML 5" />
  <title>Global Scoreboard - BlockOut</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="css/blockout.png" type="image/gif" sizes="16x16"> 
  <script src="js/jquery-1.4.2.min.js" defer></script>
  <script src="js/scoreboard/shared.js" defer></script>
  <script src="js/scoreboard/scores.js" defer></script>
  <script src="js/scoreboard/column-sorting.js" defer></script>
</head>
<body>
  <div class="scoreboard">
    <u>
      <h1 class="page-title">
        Global BlockOut Ranking
        <span class="total-scores-count-container">Total Scores: 
          <span id="total-scores-count"></span>
        </span>
      </h1>
    </u>
    <a href="index.php" class="play-btn"><< Back to Game <<</a>
    <div class="sb-filters">
      <form action="" method="POST" class="sb-filters-form" id="sbFiltersForm" onsubmit="filterScores(event)">
        <div class="input-group">
          <label for="set">Set:</label>
          <select id="set">
            <option value="">All</option>
            <option value="FLAT">Flat</option>
            <option value="BASIC">Basic</option>
            <option value="EXTENDED">Extended</option>
          </select>
        </div>
        <div class="input-group">
          <label for="pit">Pit:</label>
          <select id="pit">
            <option value="">All</option>
            <option value="3x3x10">3x3x10</option>
            <option value="5x5x10">5x5x10</option>
            <option value="5x5x12">5x5x12</option>
          </select>
        </div>
        <div class="input-group">
          <label for="level">Level:</label>
          <select id="level">
            <option value="">All</option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </div>
        <div class="input-group">
          <label for="device">Device:</label>
          <select id="device">
            <option value="">All</option>
            <option value="PC">PC</option>
            <option value="Phone">Phone</option>
          </select>
        </div>
        <div class="input-group">
          <label for="countries">Countries:</label>
          <select id="countries">
            <option value="">All</option>
            <?php 
              $countriesStmt = $scoreboard->readUniqueCountries();
              $countries = $countriesStmt->fetchAll(PDO::FETCH_ASSOC);

              foreach ($countries as $country) {
                echo "<option value='".$country['countryName']."'>".$country['countryName']."</option>";
              }
            ?>
          </select>
        </div>
        <div class="input-group">
          <label for="cities">Cities:</label>
          <select id="cities">
            <option value="">All</option>
            <?php 
              $citiesStmt = $scoreboard->readUniqueCities();
              $cities = $citiesStmt->fetchAll(PDO::FETCH_ASSOC);

              foreach ($cities as $city) {
                echo "<option value='".$city['cityName']."'>".$city['cityName']."</option>";
              }
            ?>
          </select>
        </div>
        <button class="sb-submit">VIEW</button>
      </form>
    </div>
    <div class="sb-panel" id="sbPanel">
      <div class="sb-table">
        <div class="sb-thead">
          <div class="sb-row">
            <span class="sb-col rank">Rank</span>
            <span class="sb-col player">Player</span>
            <span class="sb-col set">Set</span>
            <span class="sb-col pit">Pit</span>
            <span class="sb-col level">Level</span>
            <span class="sb-col score">
              Score
              <span onclick="handleColumnSorting(event)" data-sort-type="DESC" data-sort-col="playerScore" class="sort-icon-container">
                <span class="sort-icon-asc"></span>
                <span class="sort-icon-desc active"></span>
              </span>
            </span>
            <span class="sb-col played-at">
              Played At (UTC +0)
              <span onclick="handleColumnSorting(event)" data-sort-type="DEFAULT" data-sort-col="playedAt" class="sort-icon-container">
                <span class="sort-icon-asc"></span>
                <span class="sort-icon-desc"></span>
              </span>
            </span>
            <span class="sb-col country">Country</span>
            <span class="sb-col ip-address">City</span>
            <span class="sb-col pc_phone">PC/Phone</span>
          </div>
        </div>
        <div class="sb-tbody" id="sbTbody">
          
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <ul class="pagination-items" id="pagination-items"></ul>
  </div>
</body>
</html>