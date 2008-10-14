<?php
  include ("include/dbconnect.php");
  include ("include/format.inc.php");
  ?><title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title><?php
  include ("include/header.inc.php");
?>
  <br><br>
<center>
  <table border="0" cellspacing="2">
  <form accept-charset="utf-8" method="POST" action="<?php $PHP_SELF ?>">
    <tr valign=center>
	  <td valign="top"> 
        <input type="text" value="<?php echo $searchstring; ?>" name="searchstring" title="<?php echo ucfmsg('SEARCH_FOR_ANY_TEXT'); ?>" size="45"/>
        <input type="submit" value="<?php echo ucfirst(msg("SEARCH")) ?>"></td>
    <td>&nbsp;</td></tr>
    
  </form>

<script type="text/javascript">
function MassSelection()
{
  for (i = 0; i < document.getElementsByName("selected[]").length; i++)
  {
     document.getElementsByName("selected[]")[i].checked = document.getElementById("MassCB").checked;
  }
}


function MailSelection()
{

  var addresses = "";
  var dst_count = 0;

  for (i = 0; i < document.getElementsByName("selected[]").length; i++)
  {
      if( document.getElementsByName("selected[]")[i].checked == true)
      {
         if(  document.getElementsByName("selected[]")[i].accept != ""
           && document.getElementsByName("selected[]")[i].accept != null)
         {
         	  if(dst_count > 0) {
         	  	addresses = addresses + "<?php echo getMailerDelim(); ?>";
         	  }
            addresses = addresses + document.getElementsByName("selected[]")[i].accept;
            dst_count++;
         }
      }
  }

  if(dst_count == 0)
    alert("No address selected.");
  else
    location.href = "<?php echo getMailer(); ?>"+addresses;
}
</script>

<!--
<table width=100%><td valign=top style="border-top-width:2.5px;border-top-style:solid;border-top-color:#FFFFFF">
-->
<tr><td>
<?php
$link = "index${page_ext_qry}alphabet";
echo "<a style='font-size:75%' href='$link=a'>A</a> | <a style='font-size:75%' href='$link=b'>B</a> | <a style='font-size:75%' href='$link=c'>C</a> | <a style='font-size:75%' href='$link=d'>D</a> | <a style='font-size:75%' href='$link=e'>E</a> | <a style='font-size:75%' href='$link=f'>F</a> | <a style='font-size:75%' href='$link=g'>G</a> | <a style='font-size:75%' href='$link=h'>H</a> | <a style='font-size:75%' href='$link=i'>I</a> | <a style='font-size:75%' href='$link=j'>J</a> | <a style='font-size:75%' href='$link=k'>K</a> | <a style='font-size:75%' href='$link=l'>L</a> | <a style='font-size:75%' href='$link=m'>M</a> | <a style='font-size:75%' href='$link=n'>N</a> | <a style='font-size:75%' href='$link=o'>O</a> | <a style='font-size:75%' href='$link=p'>P</a> | <a style='font-size:75%' href='$link=q'>Q</a> | <a style='font-size:75%' href='$link=r'>R</a> | <a style='font-size:75%' href='$link=s'>S</a> | <a style='font-size:75%' href='$link=t'>T</a> | <a style='font-size:75%' href='$link=u'>U</a> | <a style='font-size:75%' href='$link=v'>V</a> | <a style='font-size:75%' href='$link=w'>W</a> | <a style='font-size:75%' href='$link=x'>X</a> | <a style='font-size:75%' href='$link=y'>Y</a> | <a style='font-size:75%' href='$link=z'>Z</a> | <a style='font-size:75%' href='index$page_ext'>".ucfmsg('ALL')."</a>" ;
?>&nbsp;&nbsp;&nbsp;
</td>
</table>
</center>
<br>
<hr>
<?php
if ($searchstring)
	{

	$sql="SELECT DISTINCT $table.* FROM $base_from_where
                AND (lastname  LIKE '%$searchstring%' 
                  OR firstname LIKE '%$searchstring%' 
                  OR address   LIKE '%$searchstring%' 
                  OR email     LIKE '%$searchstring%')
              ORDER BY lastname, firstname ASC";
	}
else if ($alphabet)
	{
$sql = "SELECT DISTINCT $table.* FROM $base_from_where AND LEFT(lastname,1) = '$alphabet' ORDER BY lastname, firstname";
	}
else
	{
$sql="SELECT DISTINCT $table.* FROM $base_from_where ORDER BY lastname, firstname ASC";
	}
	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);
	
	echo "<TABLE BORDER=0 width=100%>";
	echo "<td><strong>".msg('NUMBER_OF_RESULTS').": $resultsnumber</strong></td>";

if(isset($table_groups) and $table_groups != "" and !$is_fix_group)
{
?>
<td align=right>
<form>
<select name="group" onChange="this.parentNode.submit()">
<?php
	if($group_name != "") 
	{
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
</form>
</td></tr>
</table>
<?php
}
?>
<form accept-charset="utf-8" name=MainForm method="POST" action="group<?php echo $page_ext; ?>">
<input type="hidden" name="group" value="<?php echo $group; ?>">
<table border=0>
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
			$color = "#ffffff"; 
			$alternate = "2"; 
		} 
		else { 
			$color = "#efefef"; 
			$alternate = "1"; 
		} 
		echo "<TR bgcolor=$color>";
		$emails = $myrow['email'].(   $myrow['email']  != ""
		                           && $myrow['email2'] != "" ? getMailerDelim() : "").$myrow['email2'];
		echo "<TD><input type=checkbox id=".$id." name='selected[]' value='$id' title='Select ($firstname $lastname)' alt='Select ($firstname $lastname)' accept=".$emails."></td>";
		echo "<TD>$lastname</td>";
		echo "<td>$firstname</td>";
		echo "<td><a href='".getMailer()."$email'>$email</a></td>";
		echo "<td align=right>$phone</td>";
		echo "<td><a href='view${page_ext_qry}id=$id'><img border=0 src=icons/status_online.png   width=16 height=16 title='".ucfmsg('DETAILS')."' alt='".ucfmsg('DETAILS')."'/></a></td>";
                if(! $read_only)
		  echo "<td><a href='edit${page_ext_qry}id=$id'><img border=0 src=icons/pencil.png width=16 height=16 title='".ucfmsg('EDIT')."' alt='".ucfmsg('EDIT')."'/></a></td>";
		echo "<td><font size=-2><a href='vcard${page_ext_qry}id=$id'><img border=0 src=icons/vcard.png   width=16 height=16 title='vCard' alt='vCard'/></a></font></td>";

                if( substr($phone, 0, 1) == "0" || substr($phone, 0, 3) == "+41")
		{
			$country = "Switzerland";
		}
		else 	$country = "";

		if($map_guess)
		{
		if($myrow["address"] != "")
		echo "<td><font size=-2><a href='http://maps.google.com/maps?q=".urlencode(trim(str_replace("\r\n", ", ", $myrow["address"])).", $country")."&t=h'>
                          <img border=0 src=icons/car.png width=16 height=16 title='Google Maps' alt='vCard'/></a></font></td>";
		else echo "<td/>";
		}

		$homepage = guessHomepage($email, $email2);
		if(strlen($homepage) > 0)
		{
			echo "<td><font size=-2><a href='http://$homepage'><img border=0 src=icons/house.png   width=16 height=16 title='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)' alt='".ucfmsg("GUESSED_HOMEPAGE")." ($homepage)'/></a></font></td>";
		} else
			echo "<td/>";

		echo "</TR>\n";
	}

	echo "<tr height=2/>";
	echo "<TR >";
		echo "<TD><input type=checkbox id=MassCB onclick=\"MassSelection()\"></td><td><em><strong>".ucfmsg("SELECT_ALL")."</strong></em></TD>";
	echo "</TR>\n";
	echo "<tr height=9/>";
	echo "</TR></TABLE><TABLE width=100%><TR>";
        echo "<td><input type=button value=\"".ucfmsg("SEND_EMAIL")."\" onclick=\"MailSelection()\"/></td>";

	if(isset($table_groups) and $table_groups != "" and !$is_fix_group)
	{

		// -- Remove from group --
		if($group_name != "" and $group_name != "[none]") 
		{
	        	echo "<td align=center><input type=submit name=remove value='".ucfmsg("REMOVE_FROM")." \"$group_name\"'/></td>";
		} else
	        	echo "<td align=center/>";

		// -- Add to a group --
        	echo "<td align=right><input type=submit name=add value='".ucfmsg("ADD_TO")."'/>-";
        	echo "<select name=to_group>";

		$sql="SELECT group_name FROM $table_groups ORDER BY lower(group_name) ASC";
		$result = mysql_query($sql);
		$resultsnumber = mysql_numrows($result);
	
		while ($myrow = mysql_fetch_array($result))
		{
			echo "<option>".$myrow["group_name"]."</option>\n";
		}
        	echo "</select>";

	}
	echo "</TR></form>";

	// Show group footer
        if($group_name != "" and $group_myrow['group_footer'] != "")
        {  
            echo "<tr><td colspan=3><hr>";
            echo $group_myrow['group_footer'];
            echo "<hr></td></tr>";
        }
	echo "</TABLE>";
	include("include/footer.inc.php");

?>
