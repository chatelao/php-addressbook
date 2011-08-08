<?php

include ("include/dbconnect.php");

$use_ics = isset($_REQUEST['ics']);
if($use_ics) {

   header('Content-type: text/calendar; charset=utf-8');
   header('Content-Disposition: inline; filename=calendar.ics');

   echo "BEGIN:VCALENDAR\r\n";
   echo "PRODID:-//PHP Address Book//php-addressbook ".$version."//EN\r\n";
   echo "VERSION:2.0\r\n";
   echo "CALSCALE:GREGORIAN\r\n";
   echo "METHOD:PUBLISH\r\n";
   echo "X-WR-CALNAME:PHP Adressbook Birthdays\r\n";
   echo "X-WR-TIMEZONE:UTC\r\n";
   echo "X-WR-CALDESC:\r\n";

} else {

	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>

<h1><?php echo ucfirst(msg("NEXT_BIRTHDAYS")) ?></h1>
<?php


	echo "<table id='birthdays'>";
}
	$tablespace = 0;

	$alternate = "2";

	include ("include/guess.inc.php");

  function Birthday2vCal($date, $age) {

  	global $id, $firstname, $lastname, $email, $email2, $home, $mobile, $work, $byear;

    echo "BEGIN:VEVENT\r\n";
    echo "UID:".date('Y', $date).$id."@php-addressbook.sourceforge.net\r\n";
    echo "DTSTART;VALUE=DATE:".date("Ymd", $date)."\r\n";
    echo "DTEND;VALUE=DATE:".date("Ymd", $date+(24*3600))."\r\n";
    echo "DTSTAMP:".date("Ymd\THi00\Z")."\r\n";
    echo "CREATED:".date("Ymd\THi00\Z")."\r\n";
    echo "DESCRIPTION:\r\n";
    echo "LAST-MODIFIED:".date("Ymd\THi00\Z")."\r\n";
    echo "LOCATION:\r\n";
    echo "STATUS:CONFIRMED\r\n";
    echo "SUMMARY:".ucfmsg("BIRTHDAY")." ".$firstname." ".$lastname
                   ." ".$age."\r\n";
    echo "DESCRIPTION:Mail:\\n- ".$email
                         ."\\n- ".$email2
                         ."\\n\\n".ucfmsg("TELEPHONE")
                         .($home   != "" ? "\\n- ".$home   : "")
                         .($mobile != "" ? "\\n- ".$mobile : "")
                         .($work   != "" ? "\\n- ".$work   : "")
                         ."\r\n";
    echo "END:VEVENT\r\n";
  }

	$lastmonth = '';

$sql="
SELECT DISTINCT $table.*, $month_lookup.* ,
IF ($month_lookup.bmonth_num < MONTH( CURDATE( ) )
    OR $month_lookup.bmonth_num = MONTH( CURDATE( ) )
       AND $table.bday < DAYOFMONTH( CURDATE( ) ) , CONCAT( ' ', YEAR( CURDATE( ) ) +1 ) , ''
) display_year,
IF (
$month_lookup.bmonth_num < MONTH( CURDATE( ) )
OR $month_lookup.bmonth_num = MONTH( CURDATE( ) )
AND $table.bday < DAYOFMONTH( CURDATE( ) ) , $month_lookup.bmonth_num+12, $month_lookup.bmonth_num
)*32+bday prio
FROM $month_lookup,
$base_from_where AND $table.bmonth = $month_lookup.bmonth AND $table.bday > 0
ORDER BY prio ASC;";

	$result = mysql_query($sql);
	$resultsnumber = mysql_num_rows($result);

	while ($myrow = mysql_fetch_array($result))
	{
		$firstname = $myrow["firstname"];
		$id = $myrow["id"];
		$lastname = $myrow["lastname"];

		$email  = ($myrow["email"] != "" ? $myrow["email"] : ($myrow["email2"] != "" ? $myrow["email2"] : ""));
		$email2 = $myrow["email2"];

		$home   = $myrow["home"];
		$mobile = $myrow["mobile"];
		$work   = $myrow["work"];

		$homepage = $myrow["homepage"];

		// Phone order home->mobile->work
		$phone = ($myrow["home"] != "" ? $myrow["home"]
                                               : ($myrow["mobile"] != "" ? $myrow["mobile"]
                                                                         : $myrow["work"]));
		$phone = str_replace("'", "",
                         str_replace('/', "",
                         str_replace(" ", "",
                         str_replace(".", "", $phone))));

		$bday         = $myrow["bday"];
		$bmonth       = $myrow["bmonth"];
		$bmonth_num   = $myrow["bmonth_num"];
		$byear        = $myrow["byear"];
		$display_year = $myrow["display_year"];

	  // Current year

    $addr = new Address($myrow);
    if($addr->getBirthday()->getAge() != -1) {
      $age = "(".$addr->getBirthday()->getAge().")";
    } else {
    	$age = "";
    }    
    
  	if($use_ics) {

      // Last year
      /* -- commented to reduce traffic
      $date = gmmktime(0,0,0,$bmonth_num,$bday,date('Y')-1,0);
      Birthday2vCal($date);
      */

      $date = gmmktime(0,0,0,$bmonth_num,$bday,date('Y'),0);
      Birthday2vCal($date, $age);

      // Next year
      $date = gmmktime(0,0,0,$bmonth_num,$bday,date('Y')+1);
      $age = ($byear != "" ? " (".(date('Y', $date)-$byear).")" : "");
      Birthday2vCal($date, $age);

	  } else {

		  if($lastmonth != $bmonth) {

		  	$lastmonth = $bmonth;

		  	if ($tablespace >=1) {
		  		echo "<tr class='tablespace'><td colspan='10'><br /></td></tr>";
		  	} else {}

		  	echo "<tr><th colspan='11'>".ucfmsg(strtoupper($myrow["bmonth"])).$myrow["display_year"]."</th></tr>";
		  	$alternate = "0";
		  }

		  if ($alternate == "1") {
		    $color = "even";
		    $alternate = "2";
		  } else {
		    $color = "odd";
		    $alternate = "1";
		  }

		  echo "<tr class='$color'>";
		  echo "<td align=right>$bday.</td>";
		  echo "<td>$lastname</td>";
		  echo "<td>$firstname</td>";
		  echo "<td align='right'><i>$age</i></td>";
		  echo "<td><a href='".getMailer()."$email'>$email</a></td>";
		  echo "<td>$phone</td>";
		  echo "<td class='center'><a href='view${page_ext_qry}id=$id'><img src='${url_images}icons/status_online.png' title='".ucfmsg('DETAILS')."' alt='".ucfmsg('DETAILS')."'/></a></td>";
      if(! $read_only)
		    echo "<td class='center'><a href='edit${page_ext_qry}id=$id'><img src='${url_images}icons/pencil.png' title='".ucfmsg('EDIT')."' alt='".ucfmsg('EDIT')."'/></a></td>";
		  echo "<td class='center'><a href='vcard${page_ext_qry}id=$id'><img src='${url_images}icons/vcard.png' title='vCard' alt='vCard'/></a></td>";

      if( substr($phone, 0, 1) == "0" || substr($phone, 0, 3) == "+41")
		  {
		  	$country = "Switzerland";
		  }
		  else 	$country = "";

		  if($map_guess) {
		    if($myrow["address"] != "")
		    echo "<td class='center'><a href='http://maps.google.com/maps?q=".urlencode(trim(str_replace("\r\n", ", ", $myrow["address"])).", $country")."&amp;t=h'>
                              <img src='${url_images}icons/car.png' title='Google Maps' alt='vCard' /></a></td>";
		    else echo "<td/>";
		  }

      if($homepage != "") {
      	  $homepage = (strcasecmp(substr($homepage, 0, strlen("http")),"http")== 0
      	              ? $homepage
      	              : "http://".$homepage);
          echo "<td class='center'><a href='$homepage'><img src='${url_images}icons/house.png' title='$homepage' alt='$homepage'/></a></td>";
      } elseif(($homepage = guessHomepage($email, $email2)) != "") {
          echo "<td class='center'><a href='http://$homepage'><img src='${url_images}icons/house.png' title='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)' alt='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)'/></a></td>";
      } else {
      	echo "<td/>";
      }		    

		  echo "</tr>\n";
		  $tablespace++;
	  }
	}

if($use_ics) {
  echo "END:VCALENDAR\r\n";
} else {
  echo "</table>";
  include ("include/footer.inc.php");
}
?>