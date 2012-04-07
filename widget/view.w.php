<?php
include ("include/guess.inc.php");

function add($value, $prefix = "") {

	 if($value != "") {
	   $value .= "<br>";
	   if($prefix != "") {
	 	   $value = $prefix." ".$value;
	   }
	 }
	 return $value;
}

function addPhone($phone, $prefix = "") {

  global $default_provider, $providers;

  if($phone != "" && !isset($_GET["print"]) && isset($providers)) {

  	$links = array();
  	foreach($providers as $pprefix => $provider) {
  		$pos = strpos ($phone, $pprefix);
  		$use_default = preg_match('/^0[1-9]/', $phone) == 1;
  		
  		if(($pos !== FALSE && $pos == 0) || ($use_default && $pprefix == $default_provider)) {
  		  $links[] = "<a href='".$provider['url'].urlencode($phone)."'>".$provider['name']."</a>";
  		  $urls[]  = "<a href='".$provider['url'].urlencode($phone)."'>";
  		}
  	}
  	if(count($links) == 1) {
  	  $phone = $urls[0].$phone."</a>";
  	}
  	if(count($links) > 1) {
  	  $phone .= " (".implode(", ", $links).")";
  	}
  }
	return add($phone, $prefix);
}

function addEmail($email) {

  if($email != "") {

  	// Add Mailerspecific link
    $result = "<a href=".'"'.getMailer().$email.'"'.">".$email."</a>";

  	// Add a link to the guess homepage
    $homepage = guessOneHomepage($email);
    if( !isset($_GET["print"]) && $homepage != "") {
      $result   .= " (<a href=".'"http://'.$homepage.'" target="_new"'.">".$homepage."</a>)";
    }
    return add($result);
  } else return "";
}

function addHomepage($homepage) {

  if($homepage != "") {

  	// Keep the protocol-prefixs (http/https)
    $url = ( strcasecmp(substr($homepage, 0, strlen("http")), "http") == 0
           ? $homepage
           : "http://".$homepage);

  	// Display the homepage without protocol-prefixs (http/https)
	  $result = "<a href='".$url."'>".str_replace("http://",  "",
	                                  str_replace("https://", "", $url))."</a>";
	  return add($result);
	} else return "";
}

function addBirthday($bday, $bmonth, $byear, $prefix) {

	// Add the birthday
	if($bday != 0 || $bmonth != "-" || $byear != "") {
    $month = ucfmsg(strtoupper($bmonth));
    $result = ($bday > 0 ? $bday.". " : "")
             .($month != '-' ? $month : "")
             .($byear != ""  ? " ".$byear : "");

    // Add the age
    $birthday = new Birthday($bday, $bmonth, $byear);
    $result .= ( $birthday->getAge() != -1
               ? " (".$birthday->getAge().")"
               : "");

	  return add($result, $prefix);
  } else return "";
}

function addGroup($r, $members, $title = "") {

	$has_members = false;
	$result = "";
	foreach($members as $member) {
		$has_members = $has_members||($r[$member] != "");
	}
	if($has_members) {
		$result .= add(" ");
		if($title != "")  {
		  $result .= add($title);
		}
	}

	return $result;
}

function showOneEntry($r, $only_phone = false) {

	 global $db, $table, $table_grp_adr, $table_groups, $print, $is_fix_group, $mail_as_image;

	 $view = "";
   $view .= add("<b>".$r['firstname']." ".$r['lastname']."</b>");
   $view .= add($r['nickname']);

   $b64 = explode(";", $r['photo']);
   if(count($b64) >= 3 && ! $only_phone) {
     $b64 = $b64[2];
     $b64 = explode(":", $b64);
     if(count($b64) >= 2) {
       $b64 = str_replace(" ", "", $b64[1]);
       $view .= ($r['photo'] != "" ? '<img alt="Embedded Image" width=75 src="data:image/jpg;base64,'.$b64.'"/><br>' : "");
     }
   }
  
   if(! $only_phone) {
     $view .= ($r['title'] != ""?"<i>":"").add($r['title']).($r['title'] != ""?"</i>":"");
     $view .= add($r['company']);
//     $view .= addGroup($r, array('address'));
     $view .= add(str_replace("\n", "<br />", trim($r["address"])));
     $view .= addGroup($r, array('home','mobile','work','fax'));
   }
   $view .= addPhone($r['home'],   ucfmsg('H:'));
   $view .= addPhone($r['mobile'], ucfmsg('M:'));
   $view .= addPhone($r['work'],   ucfmsg('W:'));
   $view .= addPhone($r['fax'],    ucfmsg('F:'));
   if(! $only_phone) {

       $view .= addGroup($r, array('email','email2','email3','homepage'));
     if($mail_as_image) { // B64IMG: Thanks to NelloD
       $view .= ($r['email'] != ""  ? "<img src=\"b64img.php?text=".base64_encode(($r['email']))."\"><br/>" : "");
       $view .= ($r['email2'] != "" ? "<img src=\"b64img.php?text=".base64_encode(($r['email2']))."\"><br/>" : "");
       $view .= ($r['email3'] != "" ? "<img src=\"b64img.php?text=".base64_encode(($r['email3']))."\"><br/>" : "");
     } else {
       $view .= addEmail($r['email']);
       $view .= addEmail($r['email2']);
       $view .= addEmail($r['email3']);
     }
	   $view .= addHomepage($r['homepage']);

	   $view .= addGroup($r, array('bday','bmonth','byear'));
	   $view .= addBirthday($r['bday'], $r['bmonth'], $r['byear'], ucfmsg('BIRTHDAY'));
	   $view .= addBirthday($r['aday'], $r['amonth'], $r['ayear'], ucfmsg('ANNIVERSARY'));

	   $view .= addGroup($r, array('address2','phone2'), "<b>".ucfmsg('SECONDARY')."</b>");
	   $view .= add(str_replace("\n", "<br />", trim($r['address2'])));
  	 $view .= addGroup($r, array('phone2'));
	 }
   $view .= add($r['phone2'], ucfmsg('P:'));

   if(! $only_phone) {

   	 // Detect URLs (http://*, www.*) and show as link.
   	 //
   	 // $text = "Hello, http://www.google.com";
     // $new = preg_replace("/(http:\/\/[^\s]+)/", "<a href=\"$1\">$1</a>", $test);
   	 //
	   $view .= ($r['notes'] != "" ? "<br />".str_replace("\n", "<br />", trim($r['notes']))."<br /><br />" : "");
   }
   echo $view."\n";

   if( !isset($print) and !$is_fix_group) {

	   $sql = "SELECT DISTINCT $table_groups.group_id, group_name
	             FROM $table_grp_adr, $table_groups, $table
	            WHERE $table.id = $table_grp_adr.id
	              AND $table.id = ".$r['id']."
	              AND $table_grp_adr.group_id  = $table_groups.group_id";

	   $result = mysql_query($sql, $db);

	   $first = true;
	   while($g = mysql_fetch_array($result)) {
	   	 if($first)
	   	   echo "<br /><i>".ucfmsg('MEMBER_OF').": ";
	   	 else
			echo ", ";
			echo "<a href='./?group=".urlencode($g['group_name'])."'>".$g['group_name']."</a>";

	   	 $first = false;
	   }
	   if($first != true)
	     echo "</i>";
	   /*
     echo "<br/><br/>";
     echo ucfmsg('MODIFIED') . ": ".$r['modified'];
     echo "<i>(".ucfmsg('CREATED')  . ": ".$r['created'].")</i><br/>";
     */
   }
}
?>