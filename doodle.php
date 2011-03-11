<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");

  ?><title>Test</title><?php
  include ("include/header.inc.php");


function encode_rfc3986($input) {
 	     
  $output = rawurlencode($input);
  $output = str_replace('%7E', '~', $output);  
  return str_replace('+',   ' ', $output);
}

function getSignedParams($method, $url, $params /*, $secret*/) {

  $params['oauth_version']          = "1.0";
  $params['oauth_signature_method'] = "HMAC-SHA1";
  $params['oauth_timestamp']        = time();
  $params['oauth_nonce']            = rand();
  
  if(isset($params['oauth_consumer_secret'])) {
  	$secret = $params['oauth_consumer_secret'];
  	unset($params['oauth_consumer_secret']);  	
  }
  $secret .= "&";
  if(isset($params['oauth_token_secret'])) {
  	$secret .= $params['oauth_token_secret'];
  	unset($params['oauth_token_secret']);  	  	
  }
  
  //
  // Build signature from alphabetic sorted params, url & method
  //
  ksort($params); // Wichtig: alphabetische Reihenfolge für Signatur
  $enc_params = http_build_query($params);
  $enc_url = strtoupper($method)."&".encode_rfc3986($url)."&".encode_rfc3986($enc_params);

  $signature = base64_encode( hash_hmac ('sha1', $enc_url, $secret, true));
  $params['oauth_signature'] = $signature;

  return $params;
}

function getCurl($url, $params, $parse_response = true) {

  $params = getSignedParams("get", $url, $params);
  
  $href = $url."?".http_build_query($params);
  
  // DEBUG the URL
  // echo "<a href='".$href."'>".$href."</a><br><br>";
  
  $curl = curl_init($href);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    
  $response = curl_exec($curl);

  if($parse_response) {
    parse_str($response,  $out);
  } else {
  	$out = $response;
  }
  
  return $out;
}

function postCurl($url, $params, $body, $parse_response = true) {
  
  $params = getSignedParams("post", $url, $params);

  echo $url."<br>";
  print_r($params);
 
  $href = $url."?".http_build_query($params);
  $curl = curl_init($href);

  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
  curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-type: text/xml")); 
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    
  curl_setopt($curl, CURLOPT_VERBOSE , 1 );
  curl_setopt($curl, CURLOPT_HEADER , 1 );
  $response = curl_exec($curl);
  
  if($parse_response) {
  	$result = array();
    $res = explode("\n\r", $response);
    foreach($res as $r) {
      $kv = explode(": ", $response);
      if(count($kv) == 2) {
        $k = $kv[0];
        $result[$k] = $kv[1];
      }
    }
    return $result;
  } else {
    return $response;
  }  
}

// -------------------------------------------------------------------

function initDoodle($key, $secret) {
	
  //
  // 1. Get a token.
  //
  echo "<hr><b>Get token</b><br>";

  $in_params['oauth_consumer_key']    = $key;
  $in_params['oauth_consumer_secret'] = $secret;
  
  $url = "http://doodle.com/api1/oauth/requesttoken";
  $out = getCurl($url, $in_params);
  
  // print_r($out);
  
  //
  // 2. Access the token.
  //
  echo "<hr><b>Access token</b><br>";

  $in_params['oauth_token']        = $out['oauth_token'];
  $in_params['oauth_token_secret'] = $out['oauth_token_secret'];

  $url = "http://doodle.com/api1/oauth/accesstoken";  
  $out = getCurl($url, $in_params);

  // print_r($out);

  $in_params['oauth_token']        = $out['oauth_token'];
  $in_params['oauth_token_secret'] = $out['oauth_token_secret'];
  
  return $in_params;
  
}

  $in_params = initDoodle($doodle['key'] , $doodle['secret']);

  //
  // 3. Access a poll (7wmt84q9ypzqa4ar)
  //
  echo "<hr><b>Access a poll (7wmt84q9ypzqa4ar)</b><br>";

  $url = "http://doodle.com/api1/polls/yux8uhbvb96htt2n";
  $out = getCurl($url, $in_params, false);
?>
<code>
	<?php
  echo htmlentities($out);
  ?>
</code>  
<?php
  
  //
  // 4. Create a new poll
  //
  echo "<hr><b>Create a new poll</b><br>";

  $first = '<poll xmlns="http://doodle.com/xsd1"> <type>TEXT</type> <hidden>false</hidden> <levels>2</levels> <title>'
         . date(DATE_RFC822) .'PPP</title> <description>yum!</description> <initiator> <name>Paul</name> </initiator> <options> <option>Pasta</option> <option>Pizza</option> <option>Polenta</option> </options> </poll>';

  $url = "http://doodle.com/api1/polls";
  $response = postCurl($url, $in_params, $first, true);

  echo "<br><br><br>";

//  print_r(curl_getinfo($curl));
  
  echo "Response:\n".print_r($response)."<br>";
  
  echo "Select your date";
?>

<script src="jscalendar/mootools.v1.11.js" type="text/javascript"></script>
<script src="jscalendar/nogray_date_calendar_vs1_min.js" type="text/javascript"></script>

<script language="javascript">
	window.addEvent("domready", function(){
		var today = new Date();
											
		var calender4 = new Calendar("calendar4", null, {visible:true,
														startDay:1,
														numMonths:3,
														multiSelection:true,
														allowWeekendSelection:true,
														startDate:new Date(today),
														endDate:new Date(today.getFullYear()+1, 11, 31),
														inputField:'selDates',
														dateFormat:'Y-m-d;'
														});
	});
</script>
<link href="jscalendar/nogray_calendar_vs1.css" rel="stylesheet" type="text/css" />
<style>
	* {font-family:Arial, Helvetica, sans-serif;
		font-size:9pt;}
		
	/* table list */
	.table_list {border-collapse:collapse;
		border:solid #cccccc 1px;
		width:100%;}
	
	.table_list td {padding:5px;
		border:solid #efefef 1px;}
	
	.table_list th {background:#75b2d1;
		padding:5px;
		color:#ffffff;}
	
	.table_list tr.odd {background:#e1eff5;}
	
	/* calendar styles */
	#calendar1, #calendar2, #calendar3, #calendar4 {border:solid #666666 1px;
		background:#ffffff;
		padding-bottom:5px;
    padding-right:8px;
    }
	
	#calendar4 {width:200px;}
	#calendar4 .ng-cal-header-table {width:200px;}
	#calendar4 .ng-dateOff {background:#81b8c4;
					color:#1e6372;}
</style>		

<table>
	<tr><td width=1% valign=top>
<div id="calendar4"></div>
</td><td valign=top>
<form>
	<label name=title><b>Participants:</b></label><br>
<?php

$part = $_GET['part'];
$participants = array_filter(explode(';', $part));

$sql  = "SELECT DISTINCT id, firstname, lastname FROM $base_from_where";
$sql .= "AND (id = '".implode("' OR id = '",  $participants)."')";
$sql .= "order by lastname";
  	
$result = mysql_query($sql);
$resultsnumber = mysql_numrows($result);

$rows = array();
while ($myrow = mysql_fetch_array($result)) {
		 $rows[] = "<a href='view.php?id=".$myrow['id']
		         ."' title='".$myrow['firstname']." ".$myrow['lastname']."' target='details'>"
		         . $myrow['firstname'] //." ".$myrow['lastname']
		         . "</a>";
}
echo implode(" - ", $rows);
?>	
	<input name="part" type="hidden" value="<?php echo $part; ?>">
  <br>
	<label name=title><b>Titel:</b></label><br>
	<input size=40 name=title><br>
	<input type=hidden size=40 id=selDates name=dates><br>
	<label name=title><b>Description:</b></label><br>
<textarea name=description cols="100" rows="25">
Dear %firstname%,

Please vote for your prefered date:
- %doodle% 

Regards
Olivier
</textarea><br>
	<input type=submit>
</form>
</td></tr>
</table>

<?php  
  include ("include/footer.inc.php");
?>