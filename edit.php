<?php

include ("include/dbconnect.php");
include ("include/format.inc.php");
include ("include/header.inc.php");
?>
 <h1>Edit / add address book entry</h1> 
<?php
if($submit)
{

if(! $read_only)
{
$sql = "INSERT INTO $table (firstname, lastname, address, home, mobile, work, email, email2, bday, bmonth, byear, address2, phone2) VALUES ('$firstname','$lastname','$address','$home','$mobile','$work','$email','$email2','$bday','$bmonth','$byear', '$address2', '$phone2')";
$result = mysql_query($sql);

$sql = "INSERT INTO address_in_groups SELECT LAST_INSERT_ID() id, group_id FROM group_list WHERE group_name = '".$group_name."'";
$result = mysql_query($sql);

echo "<br><br>Information entered into address book,\n";
echo "<br><a href='edit$page_ext'>add next</a> or return to ";
echo "<a href='index$page_ext'>home page</a>.<br>";

} else
  echo "<br><br>Editing is disabled.\n";

}
else if($update)
{
  if(! $read_only)
  {
	$sql="SELECT * FROM $base_from_where AND $table.id=$id";
	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);

	if($resultsnumber > 0)
	{
		$sql = "UPDATE $table SET firstname='$firstname',lastname='$lastname',address='$address',home='$home',mobile='$mobile',work='$work',email='$email',email2='$email2',bday='$bday',bmonth='$bmonth',byear='$byear',address2 = '$address2', phone2 = '$phone2' WHERE id=$id";
		$result = mysql_query($sql);

		// header("Location: view?id=$id");		

		echo "<br>Address book updated.\n";
		echo "<br><a href='index$page_ext'>home page</a>";
	} else {
		echo "<br>Invalid ID.\n";
		echo "<br><a href='index$page_ext'>home page</a>";  
	}
  } else
    echo "<br><br>Editing is disabled.\n";
}
else if($id)
{
  if(! $read_only)
  {
$result = mysql_query("SELECT * FROM $base_from_where AND $table.id=$id",$db);
$myrow = mysql_fetch_array($result);
?>
  <form method="post" action="edit<?php echo $page_ext; ?>">
    
  <table width="380" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td> 
        <input type="hidden" name="id" value="<?php echo $myrow["id"]?>">
        Firstname: </td>
      <td> 
        <input type="Text" name="firstname" size="35" value="<?php echo $myrow["firstname"]?>">
      </td>
    </tr>
    <tr> 
      <td>Lastname:</td>
      <td> 
        <input type="Text" name="lastname" size="35" value="<?php echo $myrow["lastname"]?>">
      </td>
    </tr>
    <tr> 
      <td>Address: </td>
      <td> 
        <textarea name="address" rows="5" cols="35"><?php echo $myrow["address"]?></textarea>
      </td>
    </tr>
    <tr> 
      <td>Telephone:</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Home:</td>
      <td> 
        <input type="Text" name="home" value="<?php echo $myrow["home"]?>">
      </td>
    </tr>
    <tr> 
      <td>Mobile:</td>
      <td> 
        <input type="Text" name="mobile" value="<?php echo $myrow["mobile"]?>">
      </td>
    </tr>
    <tr> 
      <td>Work: </td>
      <td> 
        <input type="Text" name="work" value="<?php echo $myrow["work"]?>">
      </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Email:</td>
      <td> 
        <input type="Text" name="email" size="35" value="<?php echo $myrow["email"]?>">
      </td>
    </tr>
    <tr> 
      <td>Email2:</td>
      <td> 
        <input type="Text" name="email2" size="35" value="<?php echo $myrow["email2"]?>">
      </td>
    </tr>
    <tr> 
      <td>Birthday:</td>
      <td> 
        <select name="bday">
	<option value="<?php echo $myrow["bday"]?>" selected><?php echo ($myrow["bday"] == 0?"-":$myrow["bday"]) ?></option>
          <option value="0">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>
        <select name="bmonth">
          <option value="<?php echo $myrow["bmonth"] ?>" selected><?php echo $myrow["bmonth"]?></option>
          <option value="-">-</option>
          <option value="January">January</option>
          <option value="February">February</option>
          <option value="March">March</option>
          <option value="April">April</option>
          <option value="May">May</option>
          <option value="June">June</option>
          <option value="July">July</option>
          <option value="August">August</option>
          <option value="September">September</option>
          <option value="October">October</option>
          <option value="November">November</option>
          <option value="December">December</option>
        </select>
        <input type="text" name="byear" size="4" maxlength="4" value="<?php echo $myrow["byear"]?>">
      </td>
    </tr>
    <tr> 
      <td colspan=2><b><br><br>Secondary</b></td>
    </tr>
    <tr> 
      <td>Address: </td>
      <td> 
        <textarea name="address2" rows="5" cols="35"><?php echo $myrow["address2"]?></textarea>
      </td>
    </tr>
    <tr> 
      <td>Home:</td>
      <td> 
        <input type="Text" name="phone2" value="<?php echo $myrow["phone2"]?>">
      </td>
    </tr>
  </table>
    <br>
    <input type="Submit" name="update" value="Update information">
  </form>
    <br>
  <form method="get" action="delete<?php echo $page_ext; ?>">
    <input type="hidden" name="id" value="<?php echo $myrow["id"]?>">
    <input type="Submit" name="update" value="Delete information">
  </form>
  <?php

  } else
    echo "<br><br>Editing is disabled.\n";
}
else
{
  if(! $read_only)
  {
?>
  <form method="post" action="edit<?php echo $page_ext; ?>">
    
  <table width="380" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td> 
        <input type="hidden" name="id" value="<?php echo $myrow["id"]?>">
        Firstname:</td>
      <td> 
        <input type="Text" name="firstname" size="35">
      </td>
    </tr>
    <tr> 
      <td>Lastname: </td>
      <td> 
        <input type="Text" name="lastname" size="35">
      </td>
    </tr>
    <tr> 
      <td>Address: </td>
      <td> 
        <textarea name="address" rows="5" cols="35"></textarea>
      </td>
    </tr>
    <tr> 
      <td>Telephone:</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Home:</td>
      <td> 
        <input type="Text" name="home">
      </td>
    </tr>
    <tr> 
      <td>Mobile: </td>
      <td> 
        <input type="Text" name="mobile">
      </td>
    </tr>
    <tr> 
      <td>Work:</td>
      <td> 
        <input type="Text" name="work">
      </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Email: </td>
      <td> 
        <input type="Text" name="email" size="35">
      </td>
    </tr>
    <tr> 
      <td>Email2: </td>
      <td> 
        <input type="Text" name="email2" size="35">
      </td>
    </tr>
    <tr>
      <td>Birthday:</td>
      <td>
        <select name="bday">
          <option value="0" selected>-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select>
        <select name="bmonth">
          <option value="-" selected>-</option>
          <option value="January">January</option>
          <option value="February">February</option>
          <option value="March">March</option>
          <option value="April">April</option>
          <option value="May">May</option>
          <option value="June">June</option>
          <option value="July">July</option>
          <option value="August">August</option>
          <option value="September">September</option>
          <option value="October">October</option>
          <option value="November">November</option>
          <option value="December">December</option>
        </select>
        <input type="text" name="byear" size="4" maxlength="4">
      </td>
    </tr>
    <tr> 
      <td colspan=2><b><br><br>Secondary</b></td>
    </tr>
    <tr> 
      <td>Address: </td>
      <td> 
        <textarea name="address2" rows="5" cols="35"></textarea>
      </td>
    </tr>
    <tr> 
      <td>Home:</td>
      <td> 
        <input type="Text" name="phone2">
      </td>
    </tr>
  </table>
    <br>
    <input type="Submit" name="submit" value="Enter information">
  </form>
<?php
  } else
    echo "<br><br>Editing is disabled.\n";
}

include ("include/footer.inc.php");
?>
