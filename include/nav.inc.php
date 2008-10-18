
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
} ?>
<?php
if($choose_lang)
{ ?>
<tr><td/></tr>                                                          
<tr><td/></tr>
<tr><td/></tr>
<tr><td>
<?php
  $lang_cnt = 0;
  foreach($supported_langs as $supp_lang) {
    if($supp_lang != $lang)
    {
    	if($lang_cnt++ % 4 == 0)
    	  echo "<br>";
      echo "<a href='?lang=$supp_lang'><img border=0 width=16 height=11 title='".ucfmsg($supp_lang)."' alt='".ucfmsg($supp_lang)."' src='icons/".get_flag($supp_lang).".gif'/></a>";
    }
  }    
}
?>
</td></tr>  
</table>
