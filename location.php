<!DOCTYPE html>
<html lang="en" style="font-family: 'Roboto', sans-serif;">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" href="css/blockout.png" type="image/gif" sizes="16x16"> 
  <script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet'/>
  <title>Location - Blockout</title>
</head>
<body>
  <?php
    $ip = $_POST['ipAddress'];
    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip)); 
  ?>
  <div class="location">
    <h1 class="page-title">Player Geo Location, (zoom +/-)</h1>
    <a href="index.php" class="play-btn"><< Back to Game <<</a>
    <div class="location-information">
      <div class="location-details">
        <div class="location-details-item">
          <div class="location-details-key">Country:</div>
          <div class="location-details-value"><?php echo $ipdat->geoplugin_countryName; ?></div>
        </div>
        <div class="location-details-item">
          <div class="location-details-key">Region:</div>
          <div class="location-details-value" id="region"><?php echo $ipdat->geoplugin_region; ?></div>
        </div>
        <div class="location-details-item">
          <div class="location-details-key">City:</div>
          <div class="location-details-value"><?php echo $ipdat->geoplugin_city; ?></div>
        </div>
        <div class="location-details-item">
          <div class="location-details-key">Timezone:</div>
          <div class="location-details-value"><?php echo $ipdat->geoplugin_timezone; ?></div>
        </div>
        <div class="location-details-item">
          <div class="location-details-key">Latitude:</div>
          <div class="location-details-value" id="lat"><?php echo $ipdat->geoplugin_latitude; ?></div>
        </div>
        <div class="location-details-item">
          <div class="location-details-key">Longitude:</div>
          <div class="location-details-value" id="long"><?php echo $ipdat->geoplugin_longitude; ?></div>
        </div>
      </div>
      <div class="location-map" id="location">
        
      </div>
    </div>
  </div>
  <script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiZ2FtZXJlYWxpdHkiLCJhIjoiY2tlbnhuMGF2MHlhNzMybzh1ZG82MHN0YSJ9.LNtKDkUGpA3ReHFpknDvpQ';
    var map = new mapboxgl.Map({
      container: 'location',
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [document.getElementById('long').innerText, document.getElementById('lat').innerText],
      zoom: 9
    });

    var popup = new mapboxgl.Popup({ closeOnClick: false })
    .setLngLat([document.getElementById('long').innerText, document.getElementById('lat').innerText])
    .setHTML('<h1>'+document.getElementById('region').innerText+'</h1>')
    .addTo(map);
</script>
</body>
</html>