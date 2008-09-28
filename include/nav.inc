
<table width="100" cellspacing="0" cellpadding="2">
  <tr>
    <td><a href="./<?php echo ($group == "" || $group == "[none]" || $fixgroup ? "" : "?group=".$group); ?>">home</a></td>
  </tr>
  <tr>
    <td><a href="birthdays<?php echo $page_ext; ?>">next birthdays</a></td>
  </tr>
  <tr><td/></tr>
<?php if(! $read_only)
{ ?>
  <tr>
    <td><a href="edit<?php echo $page_ext; ?>">add new</a></td>
  </tr>
<?php 
} ?>
  <tr><td/></tr>
  <tr><td/></tr>
  <tr><td/></tr>
  <tr><td/></tr>
  <tr>
    <td><a href="view<?php echo ${page_ext_qry} ?>all&print">print all</a></td>
  </tr>
  <tr>
    <td><a href="view<?php echo ${page_ext_qry} ?>all&print&phones">print phones</a></td>
  </tr>
  <tr>
    <td><a href="csv<?php echo $page_ext; ?>">export csv</a></td>
  </tr>
  <tr><td/></tr>
  <tr><td/></tr>
  <tr><td/></tr>
<?php if(!$read_only && $public_group_edit && $table_groups != "" && !$is_fix_group)
{ ?>
  <tr>
    <td><a href="group<?php echo $page_ext; ?>">manage groups</a></td>
  </tr>
<?php 
} ?>
</table>