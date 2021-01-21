<!-- sourav_malo :: Full Page Starts -->

<!DOCTYPE html>
<html style="font-family: 'Roboto', sans-serif;">
<head>
  <meta name="description" content="Remake of classic puzzle game Blockout (3d tetris) in HTML 5" />
  <title>Global Scoreboard - BlockOut</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="css/style.css" />
  <script src="js/scoreboard.js" defer></script>
</head>
<body>
  <div class="scoreboard">
    <u><h1 class="page-title">Global BlockOut Ranking</h1></u>
    <a href="index.php" class="play-btn"><< Back to Game <<</a>
    <div class="sb-filters">
      <form action="" method="POST" class="sb-filters-form" id="sbFiltersForm">
        <div class="input-group">
          <label for="set">Set:</label>
          <select id="set">
            <option value="">All</option>
            <option value="BASIC">Basic</option>
            <option value="FLAT">Flat</option>
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
            <span class="sb-col score">Score</span>
            <span class="sb-col played-at">Played At (UTC +0)</span>
            <span class="sb-col country">Country</span>
            <span class="sb-col ip-address">Gamer Map</span>
            <span class="sb-col pc_phone">PC/Phone</span>
          </div>
        </div>
        <div class="sb-tbody" id="sbTbody">
          
        </div>
      </div>
    </div>
    <!-- Pagination -->
    <form class="pagination-form" id="pagination-form" method="POST">
      <span class="page-count-container">
        (<span class="cur-page-count" id="cur-page-count">2</span>/<span class="total-page-count" id="total-page-count">10</span>)
      </span>
      <input type="number" class="page-no-inp" id="page-no-inp"/>
      <button class="pagination-btn">Go</button>
    </form>
  </div>
</body>
</html>

<!-- sourav_malo :: Full Page Ends -->
