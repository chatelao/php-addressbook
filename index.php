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

<?php if($_SERVER['SERVER_NAME'] == "php-addressbook.sourceforge.net") { ?>
<table border=0>
<tr>
	<td>
		Advertisment: Just try for 2$ per month:<br>
		<img src="icons/cross.png">
		  <a href="http://swiss-addressbook.com">www.swiss-addressbook.com</a>
		<img src="icons/cross.png"><br>
		  <b><i>"PHP-Addressbook as a Service"</i></b>
		</td></tr>
</table>
<br>
<?php } ?>

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

  $addresses = new Addresses($searchstring, $alphabet);
  $result = $addresses->getResults();
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
			$sql="SELECT group_name FROM $groups_from_where ORDER BY lower(group_name) ASC";
			$result_groups = mysql_query($sql);
			$result_gropup_snumber = mysql_numrows($result_groups);
	
			while ($myrow = mysql_fetch_array($result_groups))
			{
			echo "<option>".$myrow["group_name"]."</option>\n";
			}
		?>
	</select>
</form>
<?php } ?>
<br /><br class="clear" />

<form accept-charset="utf-8" name="MainForm" method="post" action="group<?php echo $page_ext; ?>">
	<input type="hidden" name="group" value="<?php echo $group; ?>" />
	<table id="maintable" class="sortcompletecallback-applyZebra">
		<tr>
<?php					
  $is_mobile = false;
  
  if(! $is_mobile) {
    foreach($disp_cols as $col) {
    	
    	if(!in_array($col, array("home", "work", "mobile", "select", "edit", "details"))) {
	      echo "<th class='sortable'>".ucfmsg(strtoupper($col))."</th>";
    	} elseif(in_array($col, array("home", "work", "mobile"))) {
	      echo "<th>".ucfmsg("PHONE_".strtoupper($col))."</th>";
	    } else {
        echo "<th></th>";
	    	if($col == "edit" && !$read_only) { // row for edit
            echo "<th></th>";
        }
	    	if($col == "details") {
            echo "<th></th>";
            echo "<th></th>";
        }
	    }
    }
?>      
	</tr>
<?php
  }
	$alternate = "2"; 

	include ("include/guess.inc.php");


function addRow($row) {

    global $addr, $page_ext_qry, $url_images, $read_only, $map_guess, $full_phone, $homepage_guess;
	
    $myrow = $addr->getData();
    
    foreach($myrow as $mycol => $mycolval) {
       ${$mycol} = $mycolval;
    }
		$email     = $addr->firstEMail();

		$emails = $myrow['email'].(   $myrow['email']  != ""
		                           && $myrow['email2'] != "" ? getMailerDelim() : "").$myrow['email2'];

    if($email != "" && $email != $myrow['email2']) {
    	$email2 = $myrow['email2'];
    } else {
    	$email2 = "";
    }
    
    // Special value for short phone
    $row = ($row == "telephone" ? "phone" : $row);
    
    if($row == "phone") {
    if($full_phone) {
      $phone  = $addr->firstPhone();
    } else {
    	$phone  = $addr->shortPhone();
    }
    }
    
    switch ($row) {
      case "select":
        echo "<td class='center'><input type='checkbox' id='$id' name='selected[]' value='$id' title='Select ($firstname $lastname)' alt='Select ($firstname $lastname)' accept='$emails' /></td>";
        break;
      case "first_last":
        echo "<td>$firstname $lastname</td>";
        break;
      case "last_first":
        echo "<td>$lastname $firstname</td>";
        break;
      case "email":
      case "email2":
        echo "<td><a href='".getMailer()."${$row}'>${$row}</a></td>";
        break;
      case "all_phones":
        $phones = $addr->getPhones();
    	  echo "<td>".implode("<br>", $phones)."</td>";
        break;
      case "address":
  		  echo "<td>".str_replace("\n", ", ", $address)."</td>";
  		  break;
      case "edit":
        echo "<td class='center'><a href='view${page_ext_qry}id=$id'><img src='${url_images}icons/status_online.png' title='".ucfmsg('DETAILS')."' alt='".ucfmsg('DETAILS')."' /></a></td>";
        if(! $read_only) {
          echo "<td class='center'><a href='edit${page_ext_qry}id=$id'><img src='${url_images}icons/pencil.png' title='".ucfmsg('EDIT')."' alt='".ucfmsg('EDIT')."'/></a></td>";
        }
  		  break;
      case "details":
        echo "<td class='center'><a href='vcard${page_ext_qry}id=$id'><img src='${url_images}icons/vcard.png' title='vCard' alt='vCard'/></a></td>";        
  
  /*
        if( substr($phone, 0, 3) == "+41" ) {
        	$country = "Switzerland";
        } else {
        	$country = "";
        }
  */
        
        if($map_guess) {
          if($myrow["address"] != "")
          echo "<td class='center'><a href='http://maps.google.com/maps?q=".urlencode(trim(str_replace("\r\n", ", ", trim($myrow["address"]))))."&amp;t=h' target='_blank'>
                                <img src='${url_images}icons/car.png' title='Google Maps' alt='vCard'/></a></td>";
          else echo "<td/>";
        }
        
        if($homepage != "") {
        	  $homepage = (strcasecmp(substr($homepage, 0, strlen("http")),"http")== 0
        	              ? $homepage
        	              : "http://".$homepage);
            echo "<td class='center'><a href='$homepage'><img src='${url_images}icons/house.png' title='$homepage' alt='$homepage'/></a></td>";
        } elseif($homepage_guess && ($homepage = guessHomepage($email, $email2)) != "") {
            echo "<td class='center'><a href='http://$homepage'><img src='${url_images}icons/house.png' title='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)' alt='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)'/></a></td>";
        } else {
        	echo "<td/>";
        }		    
  		  break;
  	  default: // firstname, lastname, home, mobile, work, fax, phone2
         echo "<td>${$row}</td>";
    }
}

	while ($addr = $addresses->nextAddress()) {

		$color = ($alternate++ % 2) ? "odd" : "";
		echo "<tr class='".$color."' name='entry'>";

    if($is_mobile) {
		   // addRow("select");
		   addRow("lastname");
		   addRow("firstname");
		   // addRow("first_last");
		   // addRow("all_phones");
		   // addRow("email");
		   addRow("edit");
    } else {
    	 foreach($disp_cols as $col) {
	       addRow($col);
    	 }
    }

		echo "</tr>\n";
	} 
	
	echo "</table>";
	echo "&nbsp;<input type='checkbox' id='MassCB' onclick=\"MassSelection()\" /> <em><strong>".ucfmsg("SELECT_ALL")."</strong></em><br><br>";
	if($use_doodle) {
    echo "<div class='left'><input type='button' value=\"".ucfmsg("DOODLE")."\"   onclick=\"Doodle()\" /></div>";
  }
  echo "<div class='left'><input type='button' value=\"".ucfmsg("SEND_EMAIL")."\" onclick=\"MailSelection()\" /></div>";
  if(! $read_only) {
    echo "<div class='left'><input type='button' value=\"".ucfmsg("DELETE")."\"     onclick=\"DeleteSel()\" /></div>";
    
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
    
	  	$sql="SELECT group_name FROM $groups_from_where ORDER BY lower(group_name) ASC";
	  	$result = mysql_query($sql);
	  	$resultsnumber = mysql_numrows($result);
	  
	  	while ($myrow = mysql_fetch_array($result))
	  	{
	  		echo "<option>".$myrow["group_name"]."</option>\n";
	  	}
          	echo "</select>";
    
	    echo "</div>";
	  }
  }
	echo "<br/></form>";

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

function Doodle() {
	
	var participants = "";
	var dst_count = 0;

  select_count = document.getElementsByName("selected[]").length;
	for (i = 0; i < select_count; i++) {
		selected_i = document.getElementsByName("selected[]")[i];
		if( selected_i.checked == true) {
			participants += selected_i.id+";";
			dst_count++;
		}
	}
	alert(participants);
	if(dst_count == 0)
		alert("No paticipants selected.");
	else
	  location.href = "./doodle.php?part="+participants;
}

function DeleteSel() {
	
	var participants = "";
	var dst_count = 0;

  select_count = document.getElementsByName("selected[]").length;
	for (i = 0; i < select_count; i++) {
		selected_i = document.getElementsByName("selected[]")[i];
		if( selected_i.checked == true) {
			participants += selected_i.id+";";
			dst_count++;
		}
	}

	if(dst_count == 0)
		alert("No paticipants selected.");
	else
		if(confirm('Delete '+dst_count+' addresses?')) {
	    location.href = "./delete.php?part="+participants;
	  }
}

function applyZebra() {
	
  	// loop over all lines
  	var maintable = document.getElementById("maintable")
  	var tbody     = maintable.getElementsByTagName("tbody");
  	var entries   = tbody[0].children;
  	var zebraCnt  = 0;

	  // Skip header(0) + selection row(length-1)
  	for(i = 1; i < entries.length; i++) {
  		if(entries[i].style.display != "none") {
      	if((zebraCnt % 2) == 0) {
      	  entries[i].className = "";
      	} else {
      	  entries[i].className = "odd";
      	}
     	  zebraCnt++;
  		}
    }
}

//
// Filter the items in the fields
//
function filterResults(field) {

  	var query = field.value;
  	 	
  	// split lowercase on white spaces
  	var words = query.toLowerCase().split(" ");

  	// loop over all lines
  	var maintable = document.getElementById("maintable")
  	var tbody     = maintable.getElementsByTagName("tbody");
  	var entries   = tbody[0].children;
  	var foundCnt  = 0;
	
	  // Skip header(0) + selection row(length-1)
  	for(i = 1; i < entries.length; i++) {
  		
      // Use all columns that don't have the css class "center"
      var content = entries[i].childNodes[0].childNodes[0].accept;
      for(var j=0;j<entries[i].childNodes.length;j++) {
          if(entries[i].childNodes[j].className == "center") continue;
          content += " "+entries[i].childNodes[j].innerHTML;
      }
  		            
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
      	entries[i].style.display = "";
     	  foundCnt++;  			
      } else {
      	entries[i].style.display = "none";
      }
  	}  	
  	document.getElementById("search_count").innerHTML = foundCnt;
  	
  	applyZebra();
}

<?php if($use_ajax) { ?>
filterResults(document.getElementsByName("searchstring")[0]);
<?php } ?>

//-->
</script>
<?php include("include/footer.inc.php"); ?>
<script type="text/javascript" src="jstablesort/tablesort.min.js"></script>