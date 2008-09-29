<?php
include ("include/dbconnect.php");

function add($value, $first = false)
{
	# Remove whitespaces, Replace newlines and escape ["] character
	$res = trim($value);
	$res = str_replace("\r\n", ", ", $res);
	$res = str_replace('"', '""',  $res);

	# Print to result
	echo ($first ? "" : ";" ) . '"'.$res.'"';
}


	// $sql=  "SELECT * FROM $base_from_where  ORDER BY lastname, firstname ASC";
	
	$sql = "SELECT $table.*, $month_lookup.bmonth_num FROM $month_from_where ORDER BY lastname, firstname ASC";

	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);	


	header('Content-Type: application/vnd.ms-excel; charset=utf-8');
	header("Content-disposition: attachement; filename=export-".date("Ymd").($group_name != "" ? "-".$group_name : "").".csv");

	# Name + Geburtstag
	add(ucfmsg("LASTNAME"), true);
	add(ucfmsg("FIRSTNAME"));
	add(ucfmsg("BIRTHDAY"));

	# Home contact
	add("Address");
	if($plz_pattern != "")
	{
		add("PLZ");
		add("City");
	}
        
	add("Home");
	add("Mobil");
	add("E-Mail home");

	# Work contact
	add("Office");
	add("E-Mail office");


	# 2nd contact
	add("Second Adress");
	add("Second Phone");
	echo "\r\n";


	while ($myrow = mysql_fetch_array($result))
	{

		# Name + Geburtstag
		add($myrow["lastname"], true);
		add($myrow["firstname"]);

		$day    = $myrow["bday"];
		$year   = $myrow["byear"];
                if(false) // verbose month
                {
		  // $month  = $myrow["bmonth"];
		  add( ($day > 0 ? "$day. ":"").($month != null ? $month : "")." $year"); 
                } else {
		  $month  = $myrow["bmonth_num"];
		  add( ($day > 0 ? "$day.":"").($month != null ? "$month." : "")."$year"); 
                }
		
		# Home contact
		if($plz_pattern != "")
		{

			preg_match( "/(.*)(\b".$plz_pattern."\b)(.*)/m"
                                  , str_replace("\r\n", ", ", trim($myrow["address"])), $matches);

			add(preg_replace("/,$/", "", trim($matches[1])));
			add($matches[2]);
			add(preg_replace("/^,/", "", trim($matches[3])));
		}
		else add($myrow["address"]);

		add($myrow["home"]);
		add($myrow["mobile"]);
		add($myrow["email"]);


		# Work contact
		add($myrow["work"]);
		add($myrow["email2"]);

		# 2nd contact
		add($myrow["address2"]);
		add($myrow["phone2"]);

		echo "\r\n";
	}

?>