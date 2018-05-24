<?php
session_start();
if(!isset($_SESSION['username']))
{
  header("Location: index.php");
  exit;
}
include 'db.php';

if(isset($_POST['lat']))
{
  $lat = $_POST['lat'];
  $lng = $_POST['lng'];
  // "INSERT INTO `markers` (`latitude`,`longitude`) VALUES "
  mySQL_Query("INSERT INTO `markers` (`latitude`, `longitude`) VALUES ('$lat','$lng')");
  // $result = mySQL_Query("SELECT * FROM `users` WHERE `username`='$username' AND `password`='$password'");
  // echo "INSERT INTO `markers` (`latitude`, `longitude`) VALUES ('$lat','$lng')";
  exit;
  //code
}

$result = mySQL_Query("SELECT * FROM `markers` WHERE 1");
$arr =[];
if(mySQL_Num_Rows($result)>0)
{
  $i=0;
  while($row=mySQL_Fetch_Array($result))
  {
    // echo $lat;
    $lat = $row['latitude'];
    //echo $lat.'<br>';
    $lng = $row['longitude'];
    $arr[$i]['lat']=$lat;
    $arr[$i]['lng']=$lng;
    $i = $i+1;
  }
}


?>
<!DOCTYPE html>
<html>
<body>
Welcome <?= $_SESSION['username']; ?><a href="logout.php">Logout</a>
<div id="map" style="width:100%;height:650px;"></div>

<script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>

<script>
var latLngArr = <?php echo json_encode($arr);?>; //{lat:,lng:}
var map;

function myMap() {
  var mapCanvas = document.getElementById("map");
  var myCenter=new google.maps.LatLng(17.28958149969751,78.51186133932708);
  var mapOptions = {center: myCenter, zoom: 5};
  map = new google.maps.Map(mapCanvas, mapOptions);
  google.maps.event.addListener(map, 'click', function(event) {
    placeMarker(map, event.latLng);
  });
  for(var i=0;i<latLngArr.length;i++)
  {
    console.log(latLngArr[i])
    var marker = new google.maps.Marker({
      position:  new google.maps.LatLng({lat:parseFloat(latLngArr[i].lat),lng:parseFloat(latLngArr[i].lng)}) ,
      map: map
    });
  }
}

function save(lat, lng){
  alert([lat,lng])
  $.ajax({
    url: "map.php",
    method: 'POST',
    data:{lat:lat,lng:lng}
  }).done(function(resp) {
    //alert(resp);
    alert('saved');
  });
}
function placeMarker(map, location) {
  var marker = new google.maps.Marker({
    position: location,
    map: map
  });
  var infowindow = new google.maps.InfoWindow({                                                            //onClick="save(12,1)">Save !!!</button>
    content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()+'<br><button type="button" onClick="save('+location.lat()+','+location.lng()+')">Save !!!</button>'
  });
  infowindow.open(map,marker);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9Q_bf2zwCurmOYhWRJSCmbwJJ8F05hhM&callback=myMap"></script>

</body>
</html>
