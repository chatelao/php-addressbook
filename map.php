<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php");


  // Check if we have a key for this domain?
	$google_maps_key = "";
  if(isset($google_maps_keys)) {
    foreach($google_maps_keys as $domain => $key) {
    	if(str_replace($domain,"",$_SERVER['SERVER_NAME']).$domain == $_SERVER['SERVER_NAME']) {
    		$google_maps_key = $key;
    	}
    }
  }
  
  $delay = 200000; // usecs before each fetching
  $base_url = "http://maps.google.ch/maps/geo?output=csv&key=".$google_maps_key;
  $first_fetch = true;

  $cache_write = true;
  $has_620 = false;
  $single_address = false;

  $addresses = new Addresses($searchstring, $alphabet);
  $result = $addresses->getResults();

  //  foreach($addresses as $address) {
  while($myrow = mysql_fetch_array($result)) {

    $coord['addr']   = trim(str_replace("\n", ", ", trim($myrow['address'])),",");
    $coord['html']    = "<b>".$myrow['firstname']." ".$myrow['lastname']."</b><br>";
    $coord['html']   .= ($myrow['company'] != "" ? "<i>".$myrow['company']."</i><br>" : "");
    $coord['html']   .= str_replace("\n","",str_replace("\r","",nl2br($myrow['address'])));
    $coord['id']     = $myrow['id'];
    $coord['long']   = $myrow['addr_long'];
    $coord['lati']   = $myrow['addr_lat'];
    $coord['status'] = $myrow['addr_status'];

    //
    // Geo-code if long/lat is not yet defined
    //
    if(!($coord['status'] == 200 || $coord['status'] == 602 )) {

		  $request_url = $base_url . "&q=" . urlencode($coord['addr']);
		  if($first_fetch) usleep($delay);
		  $first_fetch = false;
		  $csv = file_get_contents($request_url) or die("url not loading");

			$csvSplit = explode(",", $csv);

      // http://code.google.com/intl/de-DE/apis/maps/documentation/javascript/v2/reference.html#GGeoStatusCode
			$coord['status'] = $csvSplit[0];
			if($coord['status'] == 200) {
			  $coord['lati']   = $csvSplit[2];
			  $coord['long']   = $csvSplit[3];
			  
        $sql = "UPDATE $table 
                   SET addr_long   = '".$coord['long']."'
                     , addr_lat    = '".$coord['lati']."'
                     , addr_status = '".$coord['status']."'
                  WHERE id        = '".$myrow['id']."'
                    AND domain_id = '$domain_id'
                    AND deprecated is null;";
        $upd_result = mysql_query($sql);
		  } else {
        $sql = "UPDATE $table 
                   SET addr_status = '".$coord['status']."'
                  WHERE id        = '".$myrow['id']."'
                    AND domain_id = '$domain_id'
                    AND deprecated is null;";
        $upd_result = mysql_query($sql);
		  }          
		}
		$coords[] = $coord;
  }
  if($single_address) {
  	 $coords = array();
  	 $coords[] = $single_coord;
  }
  
  //
  // Concat multiple entries on one place:
  // * Sort places
  // * Concat content
  //
  $longs = array();
  $latis = array();
  foreach ($coords as $key => $coord) {
    $longs[$key] = $coord['long'];
    $latis[$key] = $coord['lati'];
    
    $coords[$key]['bubble']  = $coord['html']."<br>";
    $coords[$key]['bubble'] .= "<b><a href='view.php?id=".$coord['id']."'>...".msg('MORE')."</a></b>";   
  }
  array_multisort($longs, SORT_ASC, $latis, SORT_ASC, $coords);
  // print_r($coords);

  ?>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=<? echo $google_maps_key; ?>" type="text/javascript"></script>

    <script type="text/javascript">

    function initialize() {
        if (GBrowserIsCompatible()) {

          var map = new GMap2(document.getElementById("map_canvas"));
          var bounds = new GLatLngBounds();

          <?php
          // PHP-Thumbnails:
          // - http://icant.co.uk/articles/phpthumbnails/
          $i = 0;
//           foreach($coords as $coord) {
          for($i = 0; $i < count($coords); $i++) {
          	
          	$coord = $coords[$i];
          	if($coord['status'] != 200) {
          		continue;
          	}
          	
          	if(   isset($coords[$i+1]) 
               && $coords[$i]['long'] == $coords[$i+1]['long']
          	   && $coords[$i]['lati'] == $coords[$i+1]['lati']) {
          	         	
          	  // Add html to next bubble
          	  $coords[$i+1]['bubble'] .= "<br><br>".$coords[$i]['bubble'];
          	  continue;
          	}
          	
          	// Sample fr den Thumbnail-Marker: http://www.schockwellenreiter.de/maps/tut03.html
          	?>
          	var point<?php echo $i; ?>  = new GLatLng( <?php echo $coord['lati'].", ".$coord['long'] ?>);
  		      var marker<?php echo $i; ?> = new GMarker(point<?php echo $i; ?>);
            GEvent.addListener( marker<?php echo $i; ?>, "mouseover"
                              , function() { marker<?php echo $i; ?>.openInfoWindowHtml(<?php echo '"'.$coord['bubble'].'"'?>);});
  		      map.addOverlay(marker<?php echo $i; ?>);
  		      bounds.extend(point<?php echo $i; ?>);

  		     <?php
  		    }
  		    //
          // Auto zoom around the markers
          // - Thanks to: http://imagine-it.org/google/debug_bounds.html
          //
  	     ?>
  	      var clat = (bounds.getNorthEast().lat() + bounds.getSouthWest().lat()) /2;
        	var clng = (bounds.getNorthEast().lng() + bounds.getSouthWest().lng()) /2;
        	map.setCenter(new GLatLng(clat,clng));
  <?php if(count($coords) == 1) { ?>
        	map.setZoom(9);
  <?php } else { ?>
        	map.setZoom(map.getBoundsZoomLevel(bounds));
  <?php } ?>
        	map.setUIToDefault();
        }
    }
  </script>
  </head>
  <body onload="initialize()" onunload="GUnload()">
  	<br><br>
  <div id="map_canvas" style="width: 800px; height: 600px"></div>
  
<?php  
  include("include/footer.inc.php");   
?>