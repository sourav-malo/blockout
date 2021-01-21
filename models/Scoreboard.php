<?php
  class Scoreboard {
    // DB Stuff
    private $conn;
    private $table = 'scoreboard';

    // Scoreboard Properties
    public $id;
    public $playerName;
    public $gameSet;
    public $gamePit;
    public $gameLevel;
    public $playerScore;
    public $playedAt;
    public $countryName;
    public $cityName;
    public $ipAddress;
    public $PC_Phone;

    public $gameSetPattern;    
    public $gamePitPattern;    
    public $gameLevelPattern;
    public $devicePattern;
    public $pageNoValue;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Read IP Address
    public function getIPAddress() {
      $ipAddress = '';

      if(getenv('HTTP_CLIENT_IP')) {
        $ipAddress = getenv('HTTP_CLIENT_IP');
      } else if(getenv('HTTP_X_FORWARDED_FOR')) {
        $ipAddress = getenv('HTTP_X_FORWARDED_FOR');
      } else if(getenv('HTTP_X_FORWARDED')) {
        $ipAddress = getenv('HTTP_X_FORWARDED');
      } else if(getenv('HTTP_FORWARDED_FOR')) {
        $ipAddress = getenv('HTTP_FORWARDED_FOR');
      } else if(getenv('HTTP_FORWARDED')) {
        $ipAddress = getenv('HTTP_FORWARDED');
      } else if(getenv('REMOTE_ADDR')) {
        $ipAddress = getenv('REMOTE_ADDR');
      } else {
        $ipAddress = 'UNKNOWN';
      } 

      return $ipAddress;
    }

    // Read Country Name by ipAddress
    public function getCountryName() {
      $this->ipAddress = $this->getIPAddress();
      if($this->ipAddress == 'UNKNOWN') {
        return 'UNKWON';
      } else {
        $ipData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$this->ipAddress")); 
        return $ipData->geoplugin_countryName;
      }
    }

    // Read City Name by ipAddress
    public function getCityName() {
      $this->ipAddress = $this->getIPAddress();
      if($this->ipAddress == 'UNKNOWN') {
        return 'UNKWON';
      } else {
        $ipData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=$this->ipAddress")); 
        return $ipData->geoplugin_city;
      }
    }

    // Read High Score
    public function readHighScore() {
      // Create Query
      $query = "SELECT MAX(playerScore) AS high_score
        FROM
          $this->table
        WHERE
          gameSet LIKE :gameSetPattern
        AND
          gamePit LIKE :gamePitPattern
        AND
          gameLevel LIKE :gameLevelPattern;";

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind Data
      $stmt->bindParam(':gameSetPattern', $this->gameSetPattern);
      $stmt->bindParam(':gamePitPattern', $this->gamePitPattern);
      $stmt->bindParam(':gameLevelPattern', $this->gameLevelPattern);

      // Execute Statement
      $stmt->execute();

      return $stmt;
    }

    // Read Scores
    public function read() {
      // Create Query
      $query = "SELECT *
        FROM
          $this->table
        WHERE
          gameSet LIKE :gameSetPattern
        AND
          gamePit LIKE :gamePitPattern
        AND
          gameLevel LIKE :gameLevelPattern
        AND
          PC_Phone LIKE :devicePattern
        ORDER BY 
          playerScore DESC;";

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind Data
      $stmt->bindParam(':gameSetPattern', $this->gameSetPattern);
      $stmt->bindParam(':gamePitPattern', $this->gamePitPattern);
      $stmt->bindParam(':gameLevelPattern', $this->gameLevelPattern);
      $stmt->bindParam(':devicePattern', $this->devicePattern);

      // Execute Statement
      $stmt->execute();

      return $stmt;
    }

    // Read Scores
    public function readPagination() {
      $startRow = ($this->pageNoValue - 1) * 200;

      // Create Query
      $query = "SELECT *
        FROM
          $this->table
        WHERE
          gameSet LIKE :gameSetPattern
        AND
          gamePit LIKE :gamePitPattern
        AND
          gameLevel LIKE :gameLevelPattern
        AND
          PC_Phone LIKE :devicePattern
        ORDER BY 
          playerScore DESC
        LIMIT
          $startRow, 200;";

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind Data
      $stmt->bindParam(':gameSetPattern', $this->gameSetPattern);
      $stmt->bindParam(':gamePitPattern', $this->gamePitPattern);
      $stmt->bindParam(':gameLevelPattern', $this->gameLevelPattern);
      $stmt->bindParam(':devicePattern', $this->devicePattern);

      // Execute Statement
      $stmt->execute();

      return $stmt;
    }

    // Read Single Score
    public function readSingleByName() {
      // Create Query
      $query = "SELECT *
        FROM
          $this->table
        WHERE
          playerName = :playerName;";

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind Data
      $stmt->bindParam(':playerName', $this->playerName);

      // Execute Statement
      $stmt->execute();

      return $stmt;
    }

    // Read Single Score
    public function readSingleByID() {
      // Create Query
      $query = "SELECT *
        FROM
          $this->table
        WHERE
          id = :id;";

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind Data
      $stmt->bindParam(':id', $this->id);

      // Execute Statement
      $stmt->execute();

      return $stmt;
    }

    // Update Score
    public function update() {
      // Create Query
      $query = "UPDATE
        $this->table
      SET
        playerName = :playerName
      WHERE
        id = :id
      ;";

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind Data
      $stmt->bindParam(':playerName', $this->playerName);
      $stmt->bindParam(':id', $this->id);

      // Execute Statement
      if($stmt->execute()) {
        return true;
      }

      return false;
    }

    // Create Score
    public function create() {
      // Create Query
      $query = "INSERT INTO
      $this->table 
        (
          playerName,
          gameSet,
          gamePit,
          gameLevel,
          playerScore,
          countryName,
          cityName,
          ipAddress,
          PC_Phone
        )
      VALUES
        (
          :playerName,
          :gameSet,
          :gamePit,
          :gameLevel,
          :playerScore,
          :countryName,
          :cityName,
          :ipAddress,
          :PC_Phone
        );  
      ";

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Bind Data
      $stmt->bindParam(':playerName', $this->playerName);
      $stmt->bindParam(':gameSet', $this->gameSet);
      $stmt->bindParam(':gamePit', $this->gamePit);
      $stmt->bindParam(':gameLevel', $this->gameLevel);
      $stmt->bindParam(':playerScore', $this->playerScore);
      $stmt->bindParam(':countryName', $this->countryName);
      $stmt->bindParam(':cityName', $this->cityName);
      $stmt->bindParam(':ipAddress', $this->ipAddress);
      $stmt->bindParam(':PC_Phone', $this->PC_Phone);

      // Execute Query
      if($stmt->execute()) {
        return array(
          "status" => "success",
          "lastInsertID" => $this->conn->lastInsertID()
        );
      } else {
        return array(
          "status" => "failure"
        );
      }
    }
  }
?>