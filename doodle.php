<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");

  ?><title>Test</title><?php
  include ("include/header.inc.php");


//*

  function encode_rfc3986($input) {
   	     
     $output = rawurlencode($input);
     $output = str_replace('%7E', '~', $output);
     
     return str_replace('+',   ' ', $output);
   }

function getHref($consumer_key, $url, $secret, $token = null) {

  $params['oauth_version']          = "1.0";
  $params['oauth_signature_method'] = "HMAC-SHA1";
  $params['oauth_consumer_key']     = $consumer_key;
  if($token != null) {
  	$params['oauth_token']          = $token;
  }
  $params['oauth_timestamp']        = time();
  $params['oauth_nonce']            = rand();
  
  //
  // Build signature from alphabetic sorted params, url & method
  //
  ksort($params); // Wichtig: alphabetische Reihenfolge für Signatur
  $enc_params = http_build_query($params);
  $enc_url = "GET&".encode_rfc3986($url)."&".encode_rfc3986($enc_params);

  $signature = base64_encode( hash_hmac ('sha1', $enc_url, $secret, true));

  //
  // Return signed request
  //
  $href = $url."?".$enc_params."&oauth_signature=".urlencode($signature);
  
  return $href;
}

  $doodle['key']    = '';
  $doodle['secret'] = '';
  $url = "http://doodle.com/api1/oauth/requesttoken";

  $href = getHref($doodle['key'], $url, $doodle['secret']."&");
  
  echo "<a href='".$href."'>".$href."</a><br><br>";
  
  $curl = curl_init($href);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    
  $response = curl_exec($curl);

  echo $response."<br>";
  
  parse_str($response,  $out);
  $token        = $out['oauth_token'];
  $token_secret = $out['oauth_token_secret'];
  echo "\n";
  print_r($out);
  
  $url = "http://doodle.com/api1/oauth/accesstoken";
  $href = getHref($doodle['key'], $url, $doodle['secret']."&".$token_secret, $token);
  
  echo "<a href='".$href."'>".$href."</a><br><br>";
  
  $curl = curl_init($href);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    
  $response = curl_exec($curl);

  echo $response."<br>";

  parse_str($response,  $out);
  $token        = $out['oauth_token'];
  $token_secret = $out['oauth_token_secret'];
  echo "\n";
  print_r($out);

  $url = "http://doodle.com/api1/polls";
  $href = getHref($doodle['key'], $url, $doodle['secret']."&".$token_secret, $token);

  echo "<a href='".$href."'>".$href."</a><br><br>";
  
  $curl = curl_init($href);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    
  $response = curl_exec($curl);

  echo $response."<br>";
  /*/
  
require "OAuth.php";  

$consumer_key = '9xah1eip56s4xl3w94w3d7orj8kc57dn';
$consumer_secret = 'hdhi4monswz3hxbwcyrul1ki8h2k72o2';
$http_method = "GET";
$rest_endpoint = "http://doodle.com/api1/oauth/requesttoken";  
$uri_info_path = "";  
$uri = "doodle.com";  
  
  
// $url = "http://doodle.com/api1/oauth/requesttoken";
  
// $endpoint = "$rest_endpoint/$uri_info_path/". urlencode($uri, "UTF-8");  
$endpoint = "http://doodle.com/api1/oauth/requesttoken";
  
// Establish an OAuth Consumer based on read credentials  
$consumer = new OAuthConsumer($consumer_key, $consumer_secret, NULL);  
  
// Setup OAuth request - Use NULL for OAuthToken parameter  
$request = OAuthRequest::from_consumer_and_token($consumer, NULL, $http_method, $endpoint, NULL);  
  
// Sign the constructed OAuth request using HMAC-SHA1 - Use NULL for OAuthToken parameter  
$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);  
  
// Extract OAuth header from OAuth request object and keep it handy in a variable  
$oauth_header = $request->to_header();  

// Initialize a cURL session  
$curl = curl_init($endpoint);

echo "Req:".$request."\n";
echo "End:".$endpoint."<br>"."\n";
echo "Hdr:".$oauth_header."<br>"."\n";

/*  
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    
curl_setopt($curl, CURLOPT_FAILONERROR, false);    
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  
  
// Include OAuth Header as part of HTTP headers in the cURL request  
curl_setopt($curl, CURLOPT_HTTPHEADER, array($oauth_header));     
  
// Make OAuth-signed request to the BCWS server and get hold of server response  
$response = curl_exec($curl);
  
if (!$response) {  
  $response = curl_error($curl);    
}  
    
// Close cURL session  
curl_close($curl);    
  
// Process server response  
print($response);  
//*/
  include ("include/footer.inc.php");

?>
