<?php
include ("include/dbconnect.php");
include ("include/format.inc.php");
  ?><title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title><?php
include ("include/header.inc.php");
?>
  <table border="0" cellspacing="2" width="380">
    <tr>
      <td><h1><?php echo ucfirst(msg("NEXT_BIRTHDAYS")) ?></h1></td>
    </tr>
  </table>
<?php

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
$base_from_where AND $table.bmonth = $month_lookup.bmonth
ORDER BY prio ASC";

	
	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);

	echo "<TABLE BORDER=0>";

	$alternate = "2"; 

	include ("include/guess.inc.php");

	$lastmonth = '';
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

		// Phone order home->mobile->work
		$phone = ($myrow["home"] != "" ? $myrow["home"]
                                               : ($myrow["mobile"] != "" ? $myrow["mobile"]
                                                                         : $myrow["work"]));
		$phone = str_replace("'", "", 
                         str_replace('/', "", 
                         str_replace(" ", "", 
                         str_replace(".", "", $phone))));

		$bday   = $myrow["bday"];
		$bmonth = $myrow["bmonth"];

		if($lastmonth != $bmonth)
		{
			$lastmonth = $bmonth;
			echo "<tr><td colspan=3><h2>".ucfmsg(strtoupper($myrow["bmonth"])).$myrow["display_year"]."</h2></td></tr>";
			$alternate = "0"; 

		}
		
		if ($alternate == "1") { 
		$color = "#ffffff"; 
		$alternate = "2"; 
		} 
		else { 
		$color = "#efefef"; 
		$alternate = "1"; 
		} 
		echo "<tr bgcolor=$color>";
		echo "<td>$bday.</td>";
		echo "<td>$lastname</td>";
		echo "<td>$firstname</td>";
		echo "<td><a href='".getMailer()."$email'>$email</a></td>";
		echo "<td align=right>$phone</td>";
		echo "<td><a href='view${page_ext_qry}id=$id'><img border=0 src=${url_images}icons/status_online.png   width=16 height=16 title='".ucfmsg('DETAILS')."' alt='".ucfmsg('DETAILS')."'/></a></td>";
    if(! $read_only)
		  echo "<td><a href='edit${page_ext_qry}id=$id'><img border=0 src=${url_images}icons/pencil.png width=16 height=16 title='".ucfmsg('EDIT')."' alt='".ucfmsg('EDIT')."'/></a></td>";
		echo "<td><font size=-2><a href='vcard${page_ext_qry}id=$id'><img border=0 src=${url_images}icons/vcard.png   width=16 height=16 title='vCard' alt='vCard'/></a></font></td>";

                if( substr($phone, 0, 1) == "0" || substr($phone, 0, 3) == "+41")
		{
			$country = "Switzerland";
		}
		else 	$country = "";

		if($map_guess)
		{
		if($myrow["address"] != "")
		echo "<td><font size=-2><a href='http://maps.google.com/maps?q=".urlencode(trim(str_replace("\r\n", ", ", $myrow["address"])).", $country")."&t=h'>
                          <img border=0 src=${url_images}icons/car.png width=16 height=16 title='Google Maps' alt='vCard'/></a></font></td>";
		else echo "<td/>";
		}

		$homepage = guessHomepage($email, $email2);
		if(strlen($homepage) > 0)
		{
			echo "<td><font size=-2><a href='http://$homepage'><img border=0 src=${url_images}icons/house.png   width=16 height=16 title='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)' alt='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)'/></a></font></td>";
		} else
			echo "<td/>";

		echo "</TR>\n";
	}
	echo "</TR></TABLE>";

include ("include/footer.inc.php");

?>