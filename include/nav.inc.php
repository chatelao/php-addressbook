
<table width="100" cellspacing="0" cellpadding="2">
  <tr>
    <td>
    	<img src="<?php echo $url_images; ?>icons/font.png">
    	<a href="./<?php echo ($group == "" || $group == "[none]" || $is_fix_group ? "" : "?group=".$group); ?>"><?php echo msg('HOME'); ?></a></td>
  </tr>
  <tr><td/></tr>
<?php if(! $read_only)
{ ?>
  <tr>
    <td>
    	<img src="<?php echo $url_images; ?>icons/add.png">
    	<a href="edit<?php echo $page_ext; ?>"><?php echo msg('ADD_NEW'); ?></a></td>
  </tr>
<?php 
} 
if(!$read_only && $public_group_edit && $table_groups != "" && !$is_fix_group)
{ ?>
  <tr>
    <td>
      <img src="<?php echo $url_images; ?>icons/group.png">
    	<a href="group<?php echo $page_ext; ?>"><?php echo msg('GROUPS'); ?></a></td>
  </tr>
<?php
} ?>  <tr><td/></tr>
  <tr><td/></tr>
  <tr><td/></tr>
  <tr><td/></tr>
  <tr>
    <td>
    	<img src="<?php echo $url_images; ?>icons/date.png">
    	<a href="birthdays<?php echo $page_ext; ?>"><?php echo msg('NEXT_BIRTHDAYS'); ?></a></td>
  </tr>
  <tr>
    <td>
    	<img src="<?php echo $url_images; ?>icons/printer.png">
    	<a href="view<?php echo $page_ext_qry; ?>all&print"><?php echo msg('PRINT_ALL'); ?></a></td>
  </tr>
  <tr>
    <td>
      <img src="<?php echo $url_images; ?>icons/book_open.png">
      <a href="view<?php echo $page_ext_qry; ?>all&print&phones"><?php echo msg('PRINT_PHONES'); ?></a></td>
  </tr>
  <tr>
    <td>
      <img src="<?php echo $url_images; ?>icons/page_excel.png">
    	<a href="csv<?php echo $page_ext; ?>"><?php echo msg('EXPORT_CSV'); ?></a></td>
  </tr>                                                                   
  <tr><td/></tr>                                                          
  <tr><td/></tr>
  <tr><td/></tr>
<?php
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
<a href="../download"><b><font color=white>Download<font></b></a>
<?php echo "v$version"; ?>
</font>
</center>
</td>
</tr>
<?php
} ?>
</table>
