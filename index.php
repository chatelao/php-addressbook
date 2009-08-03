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
		       onkeyup="filterResults(this)"/>
	</form>
<?php } ?>
<script type="text/javascript">
	document.searchform.searchstring.focus();
</script>
</div><br />
<hr />
<?php
	if(true) {
		$sql_order = "ORDER BY lastname, firstname ASC";
	} else {
		$sql_order = "ORDER BY firstname, lastname ASC";
	}

if ($searchstring) {
  
    $searchwords = split(" ", $searchstring);
  
  	$sql = "SELECT DISTINCT $table.* FROM $base_from_where";
  
    foreach($searchwords as $searchword) {
    	$sql .= "AND (   lastname  LIKE '%$searchword%' 
                    OR firstname LIKE '%$searchword%' 
                    OR address   LIKE '%$searchword%' 
                    OR email     LIKE '%$searchword%'
                    OR email2    LIKE '%$searchword%'
                    OR address2  LIKE '%$searchword%' 
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
	
			while ($myrow = mysql_fetch_array($result_groups))
			{
			echo "<option>".$myrow["group_name"]."</option>\n";
			}
		?>
	</select>
</form><br /><br class="clear" />

<?php } ?>

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
?>			
			<th></th><th></th><th></th><th></th><th></th>
		</tr>
<?php
	$alternate = "2"; 

	include ("include/guess.inc.php");

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
		echo "<td class='center'><input type='checkbox' id='id$id' name='selected[]' value='$id' title='Select ($firstname $lastname)' alt='Select ($firstname $lastname)' accept='$emails' /></td>";
		echo "<td>$lastname</td>";
		echo "<td>$firstname</td>";
		echo "<td><a href='".getMailer()."$email'>$email</a></td>";
		echo "<td>$phone</td>";
		echo "<td class='center'><a href='view${page_ext_qry}id=$id'><img src='${url_images}icons/status_online.png' title='".ucfmsg('DETAILS')."' alt='".ucfmsg('DETAILS')."' /></a></td>";
                if(! $read_only)
		  echo "<td class='center'><a href='edit${page_ext_qry}id=$id'><img src='${url_images}icons/pencil.png' title='".ucfmsg('EDIT')."' alt='".ucfmsg('EDIT')."'/></a></td>";
		echo "<td class='center'><a href='vcard${page_ext_qry}id=$id'><img src='${url_images}icons/vcard.png' title='vCard' alt='vCard'/></a></td>";

    if( substr($phone, 0, 3) == "+41" )
		{
			$country = "Switzerland";
		} else {
			$country = "";
		}

		if($map_guess)
		{
		if($myrow["address"] != "")
		echo "<td class='center'><a href='http://maps.google.com/maps?q=".urlencode(trim(str_replace("\r\n", ", ", $myrow["address"])).", $country")."&amp;t=h'>
                          <img src='${url_images}icons/car.png' title='Google Maps' alt='vCard'/></a></td>";
		else echo "<td/>";
		}

		$homepage = guessHomepage($email, $email2);
		if(strlen($homepage) > 0)
		{
			echo "<td class='center'><a href='http://$homepage'><img src='${url_images}icons/house.png' title='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)' alt='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)'/></a></td>";
		} else
			echo "<td/>";

		echo "</tr>\n";
	}

	echo "<tr>";
	echo "<td class='center'><input type='checkbox' id='MassCB' onclick=\"MassSelection()\" /></td><td><em><strong>".ucfmsg("SELECT_ALL")."</strong></em></td><td colspan='8'></td>";
	echo "</tr>\n";
	echo "</table><br />";
        echo "<div class='left'><input type='button' value=\"".ucfmsg("SEND_EMAIL")."\" onclick=\"MailSelection()\" /></div>";

	if(isset($table_groups) and $table_groups != "" and !$is_fix_group)
	{

		// -- Remove from group --
		if($group_name != "" and $group_name != "[none]") 
		{
	        	echo "<div class='left'><input type='submit' name='remove' value='".ucfmsg("REMOVE_FROM")." \"$group_name\"'/></div>";
		} else
	        	echo "<div></div>";

		// -- Add to a group --
        	echo "<div class='right'><input type='submit' name='add' value='".ucfmsg("ADD_TO")."'/>-";
        	echo "<select name='to_group'>";

		$sql="SELECT group_name FROM $table_groups ORDER BY lower(group_name) ASC";
		$result = mysql_query($sql);
		$resultsnumber = mysql_numrows($result);
	
		while ($myrow = mysql_fetch_array($result))
		{
			echo "<option>".$myrow["group_name"]."</option>\n";
		}
        	echo "</select>";

	}
	echo "</div><br /><br class='clear' /></form>";

	// Show group footer
        if($group_name != "" and $group_myrow['group_footer'] != "")
        {  
            echo "<hr />";
            echo $group_myrow['group_footer'];
            echo "<hr />";
        }
?>
<script type="text/javascript">
<!--

//
// Select All/None items
//
function MassSelection() {
  
  select_count = document.getElementsByName("selected[]").length;
  all_checked  = document.getElementById("MassCB").checked;
  
	for (i = 0; i < select_count; i++) {
	  // select only visible items
	  if( document.getElementsByName("selected[]")[i].parentNode.parentNode.style.display != "none") {
		  document.getElementsByName("selected[]")[i].checked = all_checked;
		}
	}
}

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

//
// Filter the items in the fields
//
function filterResults(field) {

  	var query = field.value;
  	 	
  	// split lowercase on white spaces
  	var words = query.toLowerCase().split(" ");

  	// loop over all lines
  	var entries = document.getElementById("maintable").childNodes[0].childNodes;
  	var foundCnt = 0;
	
	  // Skip header(0) + selection row(length-1)
  	for(i = 1; i < entries.length-1; i++) {
  		
  		// Name + Firstname + Phonenumber + Mailaddress
  		var content = entries[i].childNodes[0].childNodes[0].accept
  		            + " " + entries[i].childNodes[1].innerHTML
  		            + " " + entries[i].childNodes[2].innerHTML;
  		            
      // Don't be case sensitive
  		content = content.toLowerCase();

      // check if all words are present  		            
      var foundAll = true;
  		for(j = 0; j < words.length; j++) {
  			foundAll = foundAll && (content.search(words[j]) != -1);
  		}
  		
  		// Keep selected entries
      foundAll = foundAll || entries[i].childNodes[0].childNodes[0].checked;
  		
      // ^Hide entry
      if(foundAll) {
      	last_url = entries[i].childNodes[5].childNodes[0].href;
      	entries[i].style.display = "";
      	if((foundCnt % 2) == 0) {
      	  entries[i].className = "odd";
      	} else {
      	  entries[i].className = "even";
      	}
     	  foundCnt++;
      } else {
      	entries[i].style.display = "none";
      }
  	}
  	document.getElementById("search_count").innerHTML = foundCnt;
  	
  	// Auto-Forward if only one entry found
  	if(foundCnt == 1 && false) {
  		location = last_url;
  	}
}

filterResults(document.getElementsByName("searchstring")[0]);

//-->
</script>
<?php include("include/footer.inc.php"); ?>
