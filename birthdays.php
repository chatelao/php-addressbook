<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>
  
<h1><?php echo ucfirst(msg("NEXT_BIRTHDAYS")) ?></h1>

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

	echo "<table id='birthdays'>";
	$tablespace = 0;

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
			

			if ($tablespace >=1) {
				echo "<tr class='tablespace'><td colspan='10'><br /></td></tr>";
			} else {}

			echo "<tr><th colspan='10'>".ucfmsg(strtoupper($myrow["bmonth"])).$myrow["display_year"]."</th></tr>";
			$alternate = "0"; 

		}
		
		if ($alternate == "1") { 
		$color = "even"; 
		$alternate = "2"; 
		} 
		else { 
		$color = "odd"; 
		$alternate = "1"; 
		} 
		echo "<tr class='$color'>";
		echo "<td align=right>$bday.</td>";
		echo "<td>$lastname</td>";
		echo "<td>$firstname</td>";
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

		if($map_guess)
		{
		if($myrow["address"] != "")
		echo "<td class='center'><a href='http://maps.google.com/maps?q=".urlencode(trim(str_replace("\r\n", ", ", $myrow["address"])).", $country")."&amp;t=h'>
                          <img src='${url_images}icons/car.png' title='Google Maps' alt='vCard' /></a></td>";
		else echo "<td/>";
		}

		$homepage = guessHomepage($email, $email2);
		if(strlen($homepage) > 0)
		{
			echo "<td class='center'><a href='http://$homepage'><img src='${url_images}icons/house.png' title='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)' alt='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)'/></a></td>";
		} else
			echo "<td/>";

		echo "</tr>\n";
		$tablespace++;
	}
	echo "<!-- </tr> --> </table>";

include ("include/footer.inc.php");

?>
