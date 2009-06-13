<ul>
<li>
	<img src="<?php echo $url_images; ?>icons/font.png" alt="home" />
	<a href="./<?php echo ($group == "" || $group == "[none]" || $is_fix_group ? "" : "?group=".$group); ?>"><?php echo msg('HOME'); ?></a>
</li>
<?php if(! $read_only) { ?>
<li>
	<img src="<?php echo $url_images; ?>icons/add.png" alt="add new" /><a href="edit<?php echo $page_ext; ?>"><?php echo msg('ADD_NEW'); ?></a>
</li>
<?php 
} 
if(!$read_only && $public_group_edit && $table_groups != "" && !$is_fix_group)
{ ?>
	<li><img src="<?php echo $url_images; ?>icons/group.png" alt="groups" /><a href="group<?php echo $page_ext; ?>"><?php echo msg('GROUPS'); ?></a></li>
<?php } ?>
	<li>
		<img src="<?php echo $url_images; ?>icons/date.png" alt="next birthdays" />
		<a href="birthdays<?php echo $page_ext; ?>"><?php echo msg('NEXT_BIRTHDAYS'); ?></a>
	</li>
    <li>
    	<img src="<?php echo $url_images; ?>icons/printer.png" alt="print all" />
    	<a href="view<?php echo $page_ext_qry; ?>all&amp;print"><?php echo msg('PRINT_ALL'); ?></a>
  </li>
    <li>
      <img src="<?php echo $url_images; ?>icons/book_open.png" alt="print phones" />
      <a href="view<?php echo $page_ext_qry; ?>all&amp;print&amp;phones"><?php echo msg('PRINT_PHONES'); ?></a>
  </li>
    <li>
      <img src="<?php echo $url_images; ?>icons/page_excel.png" alt="export csv" />
    	<a href="csv<?php echo $page_ext; ?>"><?php echo msg('EXPORT_CSV'); ?></a>
  </li> 
</ul>
