<?php
	include ("include/dbconnect.php");
	include ("include/format.inc.php");
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>

<br /><br />
<div id="search-az">
<?php if(! $use_ajax ) { ?>
	<form accept-charset="utf-8" method="get" name="searchform">
		<input type="text" value="<?php echo $searchstring; ?>" name="searchstring" title="<?php echo ucfmsg('SEARCH_FOR_ANY_TEXT'); ?>" size="45" tabindex="0"/>
		<input name="submitsearch" type="submit" value="<?php echo ucfirst(msg('SEARCH')) ?>" />    
	</form>
<?php
$link = "index${page_ext_qry}alphabet";
echo "<div id='a-z'><a href='$link=a'>A</a> | <a href='$link=b'>B</a> | <a href='$link=c'>C</a> | <a href='$link=d'>D</a> | <a href='$link=e'>E</a> | <a href='$link=f'>F</a> | <a href='$link=g'>G</a> | <a href='$link=h'>H</a> | <a href='$link=i'>I</a> | <a href='$link=j'>J</a> | <a href='$link=k'>K</a> | <a href='$link=l'>L</a> | <a href='$link=m'>M</a> | <a href='$link=n'>N</a> | <a href='$link=o'>O</a> | <a href='$link=p'>P</a> | <a href='$link=q'>Q</a> | <a href='$link=r'>R</a> | <a href='$link=s'>S</a> | <a href='$link=t'>T</a> | <a href='$link=u'>U</a> | <a href='$link=v'>V</a> | <a href='$link=w'>W</a> | <a href='$link=x'>X</a> | <a href='$link=y'>Y</a> | <a href='$link=z'>Z</a> | <a href='index$page_ext'>".ucfmsg('ALL')."</a></div>" ;
} else { 
?>
	<form accept-charset="utf-8" method="get" name="searchform" onsubmit="return false">
		<input type="text" value="<?php echo $searchstring; ?>" name="searchstring" title="<?php echo ucfmsg('SEARCH_FOR_ANY_TEXT'); ?>" size="45" tabindex="0" 
<?php if($use_ajax) { ?>		
		       onkeyup="filterResults(this)"/>
<?php } ?>
	</form>
<?php } ?>
<script type="text/javascript">
	document.searchform.searchstring.focus();
</script>
</div><br />
<hr />
<?php
	if(false) {
		$sql_order = "ORDER BY lastname, firstname ASC";
	} else {
		$sql_order = "ORDER BY firstname, lastname ASC";
	}

if ($searchstring) {
  
    $searchwords = split(" ", $searchstring);
  
  	$sql = "SELECT DISTINCT " . $table . ".*, "
        . $table_address . ".*, "
        . $table_phone . ".*, "
        . $table_email . ".* FROM "
        . $table_address . " ,"
        . $table_phone . " ,"
        . $table_email . " ,"
        . $base_from_where;
  
    foreach($searchwords as $searchword) {
    	$sql .= "AND (   lastname  LIKE '%$searchword%' 
                    OR firstname LIKE '%$searchword%' 
                    OR company   LIKE '%$searchword%' 
                    OR postal_address   LIKE '%$searchword%'
                    OR phone_number     LIKE '%$searchword%'
                    OR email_address    LIKE '%$searchword%'
                    OR notes     LIKE '%$searchword%' 
                    )";
    }
    $sql .= $sql_order;
    
  } else if ($alphabet) {
    $sql = "SELECT DISTINCT $table.* FROM $base_from_where AND LEFT(lastname,1) = '$alphabet' ".$sql_order;
  } else{
    $sql="SELECT DISTINCT $table.* FROM $base_from_where ".$sql_order;
	}
	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);
	
	// TBD:  Pagination
	// http://php.about.com/od/phpwithmysql/ss/php_pagination.htm
	
	echo "<label style='width:24em;'><strong>".msg('NUMBER_OF_RESULTS').": <span id='search_count'>$resultsnumber</span></strong></label>";

if(isset($table_groups) and $table_groups != "" and !$is_fix_group) { ?>

<form id="right" method="get">
	<select name="group" onchange="this.parentNode.submit()">
		<?php
			if($group_name != "") {
				echo "<option>$group_name</option>\n";
			}
		?>
		<option value="">[<?php echo msg("ALL"); ?>]</option>
		<option value="[none]">[<?php echo msg("NONE"); ?>]</option>
		<?php
			$sql="SELECT group_name FROM $table_groups ORDER BY lower(group_name) ASC";
			$result_groups = mysql_query($sql);
			$result_gropup_snumber = mysql_numrows($result_groups);
	
			while ($myrow = mysql_fetch_array($result_groups)) {
			echo "<option>".$myrow["group_name"]."</option>\n";
			}
		?>
	</select>
</form>
<?php } ?>
<br /><br class="clear" />

<form accept-charset="utf-8" name="MainForm" method="post" action="group<?php echo $page_ext; ?>">
	<input type="hidden" name="group" value="<?php echo $group; ?>" />
	<table id="maintable">
		<tr>
			<th></th>
<?php					
			echo "<th>".ucfmsg("FIRSTNAME")."</th>";
			echo "<th>".ucfmsg("LASTNAME")."</th>";
			echo "<th>".ucfmsg("EMAIL")."</th>";
			echo "<th>".ucfmsg("TELEPHONE")."</th>";
      if(!$read_only) {
         echo "<th></th>";
      }
?>			
			<th></th><th></th><th></th><th></th>
		</tr>
<?php
	$alternate = "2"; 

	include ("include/guess.inc.php");

	while ($myrow = mysql_fetch_array($result))	{
		
		$addr = new Address($myrow);
                // addition by rehan@itlinkonline.com
                // phone
                $phoneQuery = 'SELECT * FROM ' . $table_phone . ' p LEFT JOIN ' . $table_phone_type . ' pt on pt.phone_type_id = p.phone_type_id WHERE p.addressbook_id = ' . $myrow['id'] . ' ORDER BY phone_type asc';
                // email
                $emailQuery = 'SELECT * FROM ' . $table_email . ' e LEFT JOIN ' . $table_email_type . ' et on et.email_type_id = e.email_type_id WHERE e.addressbook_id = ' . $myrow['id'] . ' ORDER BY email_type asc';
                // address
                $addQuery = 'SELECT * FROM ' . $table_address . ' a LEFT JOIN ' . $table_address_type . ' at on at.address_type_id = a.address_type_id WHERE a.addressbook_id = ' . $myrow['id'] . ' ORDER BY address_type asc ';

                $addr->setPhones($phoneQuery);
                $addr->setEmails($emailQuery);
                $addr->setAddresses($addQuery);
                // end addition by rehan@itlinkonline.com

		$firstname = $myrow["firstname"];
		$id = $myrow["id"];
		$lastname = $myrow["lastname"];
		$company  = $myrow["company"];

		$email  = $addr->firstEMail();
		
    $phone = $addr->shortPhone();

		if ($alternate == "1") { 
			$color = "even"; 
			$alternate = "2"; 
		} 
		else { 
			$color = "odd"; 
			$alternate = "1"; 
		} 
		echo "<tr class='$color' name='entry'>";
		$emails = $myrow['email'].(   $myrow['email']  != ""
		                           && $myrow['email2'] != "" ? getMailerDelim() : "").$myrow['email2'];
		echo "<td class='center'><input type='checkbox' id='$id' name='selected[]' value='$id' title='Select ($firstname $lastname)' alt='Select ($firstname $lastname)' accept='$emails' /></td>";
		echo "<td>$firstname</td>";
		echo "<td>$lastname</td>";
		echo "<td><a href='".getMailer()."$email'>$email</a></td>";
		echo "<td>$phone</td>";
		echo "<td class='center'><a href='view${page_ext_qry}id=$id'><img src='${url_images}icons/status_online.png' title='".ucfmsg('DETAILS')."' alt='".ucfmsg('DETAILS')."' /></a></td>";
                if(! $read_only)
		  echo "<td class='center'><a href='edit${page_ext_qry}id=$id'><img src='${url_images}icons/pencil.png' title='".ucfmsg('EDIT')."' alt='".ucfmsg('EDIT')."'/></a></td>";
		echo "<td class='center'><a href='vcard${page_ext_qry}id=$id'><img src='${url_images}icons/vcard.png' title='vCard' alt='vCard'/></a></td>";
		// addition by rehan@itlinkonline.com
    	switch(substr($phone, 0, 3)){
            case "+41": $country = "Switzerland";   break;
            case "+92": $country = "Pakistan";      break;
            case "+91": $country = "India";         break;
            case "+86": $country = "China";         break;
            case "+96": $country = "Suadia Arabia"; break;
            default:    $country = "";              break;
        }
		// end addition by rehan@itlinkonline.com
		$myrow['address'] = $addr->firstAddress();
		if($map_guess) {
		if($myrow["address"] != "")
		echo "<td class='center'><a href='http://maps.google.com/maps?q=".urlencode(trim(str_replace("\r\n", ", ", $myrow["address"])).", $country")."&amp;t=h' target='_blank'>
                          <img src='${url_images}icons/car.png' title='Google Maps' alt='vCard'/></a></td>";
		else echo "<td/>";
		}

		$homepage = guessHomepage($email, $email2);
		if(strlen($homepage) > 0)		{
			echo "<td class='center'><a href='http://$homepage'><img src='${url_images}icons/house.png' title='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)' alt='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)'/></a></td>";
		} else
			echo "<td/>";

		echo "</tr>\n";
	}

	echo "<tr>";
	echo "<td class='center'><input type='checkbox' id='MassCB' onclick=\"MassSelection()\" /></td><td><em><strong>".ucfmsg("SELECT_ALL")."</strong></em></td><td colspan='8'></td>";
	echo "</tr>\n";
	echo "</table><br />";
	if($use_doodle) {
    echo "<div class='left'><input type='button' value=\"".ucfmsg("DOODLE")."\" onclick=\"Doodle()\" /></div>";
  }
  echo "<div class='left'><input type='button' value=\"".ucfmsg("SEND_EMAIL")."\" onclick=\"MailSelection()\" /></div>";

	if(isset($table_groups) and $table_groups != "" and !$is_fix_group)	{

		// -- Remove from group --
		if($group_name != "" and $group_name != "[none]") 		{
	        	echo "<div class='left'><input type='submit' name='remove' value='".ucfmsg("REMOVE_FROM")." \"$group_name\"'/></div>";
		} else
	        	echo "<div></div>";

		// -- Add to a group --
        	echo "<div class='right'><input type='submit' name='add' value='".ucfmsg("ADD_TO")."'/>-";
        	echo "<select name='to_group'>";

		$sql="SELECT group_name FROM $table_groups ORDER BY lower(group_name) ASC";
		$result = mysql_query($sql);
		$resultsnumber = mysql_numrows($result);
	
		while ($myrow = mysql_fetch_array($result))		{
			echo "<option>".$myrow["group_name"]."</option>\n";
		}
        	echo "</select>";

	}
	echo "</div><br /><br class='clear' /></form>";

	// Show group footer
        if($group_name != "" and $group_myrow['group_footer'] != "")        {  
            echo "<hr />";
            echo $group_myrow['group_footer'];
            echo "<hr />";
        }
?>
<script type="text/javascript">
<!--
//
// Send Mail to selected persons
//
function MailSelection() {
	var addresses = "";
	var dst_count = 0;

  select_count = document.getElementsByName("selected[]").length;
	for (i = 0; i < select_count; i++) {
		selected_i = document.getElementsByName("selected[]")[i];
		if( selected_i.checked == true) {
			if( selected_i.accept != "" && selected_i.accept != null) {
				if(dst_count > 0) {
					addresses = addresses + "<?php echo getMailerDelim(); ?>";
				}
				addresses = addresses + selected_i.accept;
				dst_count++;
			}
		}
	}

	if(dst_count == 0)
		alert("No address selected.");
	else
		location.href = "<?php echo getMailer(); ?>"+addresses;
}
<?php if($use_ajax) { ?>
filterResults(document.getElementsByName("searchstring")[0]);
<?php } ?>
//-->
</script>
<?php include("include/footer.inc.php"); ?>