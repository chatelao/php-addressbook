<?php

include ("include/dbconnect.php");
include ("include/format.inc.php");
include ("include/header.inc.php");

echo "<h1>".ucfmsg('GROUPS')."</h1>";

if($submit)
{

if(! $read_only)
{
$sql = "INSERT INTO $table_groups (group_name, group_header, group_footer) VALUES ('$group_name','$group_header','$group_footer')";
$result = mysql_query($sql);

echo "<br><br>Information entered into address book.\n";
echo "<br><a href='group$page_ext'>group page</a>";
} else
  echo "<br><br>Editing is disabled.\n";

}
// -- Add people to a group
else if($new)
{
  if(! $read_only)
  {
?>
  <form accept-charset="utf-8" method="post">
    
  <table width="380" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td>Group name: </td>
      <td> 
        <input type="Text" name="group_name" size="35">
      </td>
    </tr>
    <tr> 
      <td>Group header (Logo): </td>
      <td> 
        <textarea name="group_header" rows="10" cols="80"></textarea>
      </td>
    </tr>
    <tr> 
      <td>Group footer (Comment): </td>
      <td> 
        <textarea name="group_footer" rows="10" cols="80"></textarea>
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
else if($delete)
{
	// Remove the groups
	foreach($selected as $group_id)
	{
		// Delete links between addresses and groups
		$sql = "delete from $table_grp_adr where group_id = $group_id";
		$result = mysql_query($sql);

		// Delete groups
		$sql = "delete from $table_groups  where group_id = $group_id";
		$result = mysql_query($sql);
	}
	
	echo "Groups removed. See on <a href='./group$page_ext'>group page</a>.";	
}
else if($add)
{
	// Lookup for the group_id
	$sql = "select * from $table_groups where group_name = '$to_group'";

	$result = mysql_query($sql);
	// $resultsnumber = mysql_numrows($result);

	$myrow = mysql_fetch_array($result);
	$group_id   = $myrow["group_id"];
	$group_name = $myrow["group_name"];

	// Add people to the group, who are not alread in the group!
	foreach($selected as $user_id)
	{
		
		$sql = "insert into $table_grp_adr (id, group_id) values ($user_id, $group_id)";
		$result = mysql_query($sql);
	}
	
	echo "Users added. See on <a href='./?group=$group_name'>group page \"$group_name\"</a>.";

}
// -- Remove people from a group
else if($remove)
{
	// Lookup for the group_id
	$sql = "select * from $table_groups where group_name = '$group'";

	$result = mysql_query($sql);
	// $resultsnumber = mysql_numrows($result);

	$myrow = mysql_fetch_array($result);
	$group_id   = $myrow["group_id"];
	$group_name = $myrow["group_name"];

	// Remove people from the group, who are not alread in the group!
	foreach($selected as $user_id)
	{
		
		$sql = "delete from $table_grp_adr where id = $user_id AND group_id = $group_id";
		$result = mysql_query($sql);
	}
	
	echo "Users removed. See on <a href='./?group=$group_name'>group page \"$group_name\"</a>.";
}
else if($update)
{
  if(! $read_only)
  {
	$sql="SELECT * FROM $table_groups WHERE group_id=$id";
	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);

	if($resultsnumber > 0)
	{
		$sql = "UPDATE $table_groups SET group_name='$group_name'
                                               , group_header='$group_header' 
                                               , group_footer='$group_footer' 
                                             WHERE group_id=$id";
		$result = mysql_query($sql);

		// header("Location: view?id=$id");		

		echo "<br>Address book updated.\n";
		echo "<br><a href='group$page_ext'>group page</a>";
	} else {
		echo "<br>Invalid ID.\n";
		echo "<br><a href='group$page_ext'>group page</a>";  
	}
  } else
    echo "<br><br>Editing is disabled.\n";
}
// Open for Editing
else if($edit || $id)
{
  if($edit) $id = $selected[0];
  if(! $read_only)
  {
$result = mysql_query("SELECT * FROM $table_groups WHERE group_id=$id",$db);
$myrow = mysql_fetch_array($result);
?>
  <form accept-charset="utf-8" method="post">
        <input type="hidden" name="id" value="<?php echo $myrow["group_id"]?>">
    
  <table width="380" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td><?php echo ucfmsg('GROUP_NAME'); ?></td>
      <td> 
        <input type="Text" name="group_name" size="35" value="<?php echo $myrow["group_name"]?>">
      </td>
    </tr>
    <tr> 
      <td><?php echo ucfmsg('GROUP_HEADER'); ?>: </td>
      <td> 
        <textarea name="group_header" rows="10" cols="80"><?php echo $myrow["group_header"]?></textarea>
      </td>
    </tr>
    <tr> 
      <td><?php echo ucfmsg('GROUP_FOOTER'); ?>: </td>
      <td> 
        <textarea name="group_footer" rows="10" cols="80"><?php echo $myrow["group_footer"]?></textarea>
      </td>
    </tr>
  </table>
    <br>
    <input type="Submit" name="update" value="<?php echo ucfmsg('UPDATE'); ?>">
  </form>
    <br>
  <?php

  } else
    echo "<br><br>Editing is disabled.\n";
}
else
{
	$sql="   SELECT groups.*
	              , parent_groups.group_name  parent_name
	              , parent_groups.group_id    parent_id
	           FROM addr_group_list AS groups
        LEFT JOIN addr_group_list AS parent_groups
               ON groups.group_parent_id = parent_groups.group_id
         ORDER BY groups.group_name";

	$result = mysql_query($sql);
	$resultsnumber = mysql_numrows($result);

?>
<form>
<input type="Submit" name="new" value="<?php echo ucfmsg('NEW_GROUP'); ?>"/>
</form>
<hr>
<form><?php

	while ($myrow = mysql_fetch_array($result))
	{
		echo "<input type=checkbox name='selected[]' value='".$myrow['group_id']."' title='Select (".$myrow['group_name'].")'/>";
		
		if($myrow['parent_name'] != "") {
		  echo $myrow['group_name']." <i>(".$myrow['parent_name'].")</i><br>";
		} else {
		  echo $myrow['group_name']."<br>";
		}
	}	
?>
<br>
<input type="Submit" name="delete" value="<?php echo ucfmsg('DELETE_GROUPS'); ?>">
<input type="Submit" name="edit"   value="<?php echo ucfmsg('EDIT_GROUP'); ?>">
</form><?php
}

include ("include/footer.inc.php");
?>