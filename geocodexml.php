<?php


define("MAPS_HOST", "maps.google.com");
define("KEY", "ABQIAAAARrjMA09xr_xJ6GRChXMzdBQyNy8QwsLExkWn_UOp0GZOZdSkpBTDMrst9I970qDQtiMnbb9k0oOuKQ");

echo "hello1 ";


     $geocode_pending = true;
  $delay = 0;
$base_url = "http://" . MAPS_HOST . "/maps/geo?output=csv&key=" . KEY;

	//----------------------------------------
while ($geocode_pending) {
	
    $address = '411 Woody Hayes Drive, Columbus,OH';
    $request_url = $base_url . "&q=" . urlencode($address);
    $csv = file_get_contents($request_url) or die("url not loading");

    echo "<pre>\n$csv</pre>\n";
    $csvSplit = split(",", $csv);
    $status = $csvSplit[0];
	echo 'status ' . $status;
    $lat = $csvSplit[2];
    $lng = $csvSplit[3];
    if ($status == 200) {
      // successful geocode
      $geocode_pending = false;
      $lat = $csvSplit[2];
      $lng = $csvSplit[3];
      echo "<p>Latitude: $lat<br>Longitude: $lng</p>\n";
      
    } else if (strcmp($status, "620") == 0) {
      // sent geocodes too fast
      $delay += 100000;
	  echo "620";
    } else {
      // failure to geocode
      $geocode_pending = false;
      echo "Address " . $address . " failed to geocoded. ";
      echo "Received status " . $status . "
\n";
    }
    usleep($delay);
  }


?>
