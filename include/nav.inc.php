
<table width="100" cellspacing="0" cellpadding="2">
  <tr>
    <td><a href="./<?php echo ($group == "" || $group == "[none]" || $fixgroup ? "" : "?group=".$group); ?>"><?php echo msg('HOME'); ?></a></td>
  </tr>
  <tr>
    <td><a href="birthdays<?php echo $page_ext; ?>"><?php echo msg('NEXT_BIRTHDAYS'); ?></a></td>
  </tr>
  <tr><td/></tr>
<?php if(! $read_only)
{ ?>
  <tr>
    <td><a href="edit<?php echo $page_ext; ?>"><?php echo msg('ADD_NEW'); ?></a></td>
  </tr>
<?php 
} ?>
  <tr><td/></tr>
  <tr><td/></tr>
  <tr><td/></tr>
  <tr><td/></tr>
  <tr>
    <td><a href="view<?php echo $page_ext_qry; ?>all&print"><?php echo msg('PRINT_ALL'); ?></a></td>
  </tr>
  <tr>
    <td><a href="view<?php echo $page_ext_qry; ?>all&print&phones"><?php echo msg('PRINT_PHONES'); ?></a></td>
  </tr>
  <tr>
    <td><a href="csv<?php echo $page_ext; ?>"><?php echo msg('EXPORT_CSV'); ?></a></td>
  </tr>                                                                   
  <tr><td/></tr>                                                          
  <tr><td/></tr>
  <tr><td/></tr>
<?php if(!$read_only && $public_group_edit && $table_groups != "" && !$is_fix_group)
{ ?>
  <tr>
    <td><a href="group<?php echo $page_ext; ?>"><?php echo msg('MANAGE_GROUPS'); ?></a></td>
  </tr>
<?php
} 
/*
 * Add some function only active on the 
 * "php-addressbook.sourceforge.net" Demopage.
 */
if($_SERVER['SERVER_NAME'] == "php-addressbook.sourceforge.net")
{ ?>
<tr><td><br><br><br><br></td></tr>
<tr>
<td bgcolor=#63A624 style="border:1px solid black;">
	<center>
<font color=white>
<a href="http://sourceforge.net/project/platformdownload.php?group_id=157964"><b><font color=white>Download<font></b></a>
<?php echo "v$version"; ?>
</font>
</center>
</td>
</tr>
<?php
} ?>
</table>
