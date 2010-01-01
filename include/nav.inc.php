<ul>
<li>
	<a href="./<?php echo ($group == "" || $group == "[none]" || $is_fix_group ? "" : "?group=".$group); ?>"><?php echo msg('HOME'); ?></a>
</li>
<?php if(! $read_only) { ?>
<li class="all">
	<a href="edit<?php echo $page_ext; ?>"><?php echo msg('ADD_NEW'); ?></a>
</li>
<?php } ?>
<?php if(!$read_only && $public_group_edit && $table_groups != "" && !$is_fix_group) { ?>
	<li class="admin">
		<a href="group<?php echo $page_ext; ?>"><?php echo msg('GROUPS'); ?></a>
	</li>
<?php } ?>
    <?php // addition by rehan@itlinkonline.com ?>
	<li class="heading"><a><?php echo msg('TYPES'); ?></a></li>
    <li class="all">
        <a href="phone_type<?php echo $page_ext; ?>"><?php echo msg('PHONE_TYPE'); ?></a>
    </li>
    <li class="all">
        <a href="email_type<?php echo $page_ext; ?>"><?php echo msg('EMAIL_TYPE'); ?></a>
    </li>
    <li class="all">
        <a href="address_type<?php echo $page_ext; ?>"><?php echo msg('ADDRESS_TYPE'); ?></a>
    </li>
	<?php // end addition by rehan@itlinkonline.com ?>
	<li class="all">
		<a href="birthdays<?php echo $page_ext; ?>"><?php echo msg('NEXT_BIRTHDAYS'); ?></a>
	</li>
	<?php // addition by rehan@itlinkonline.com ?>
    <li class="heading"><a><?php echo msg('PRINT'); ?></a></li>
    <li class="export">
        <a href="view<?php echo $page_ext_qry; ?>all&amp;print" target="_blank"><?php echo msg('PRINT_ALL'); ?></a>
    </li>
	<li class="export">
        <a href="view<?php echo $page_ext_qry; ?>all&amp;print&amp;primary" target="_blank"><?php echo msg('PRINT_PRIMARY'); ?></a>
  </li>
	<li class="export">
        <a href="view<?php echo $page_ext_qry; ?>all&amp;print&amp;phones" target="_blank"><?php echo msg('PRINT_PHONES'); ?></a>
  </li>
	<?php // end addition by rehan@itlinkonline.com ?>
	<li class="export">
    	<a href="csv<?php echo $page_ext; ?>"><?php echo msg('EXPORT_CSV'); ?></a>
  </li> 
</ul>
