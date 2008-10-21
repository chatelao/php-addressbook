<link rel="shortcut icon" type="image/x-png" href="<?php echo $url_images; ?>icons/font.png">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="3">
<table>
<tr>
<?php 
  if($group_name != "")
  {  
    $sql="SELECT * FROM $table_groups WHERE group_name = '$group_name'";
    $result = mysql_query($sql);
    $group_myrow = mysql_fetch_array($result);

    echo $group_myrow['group_header'];
  }
?>
<td>
<a href=".">
    <img border=0 title="Addressbook" alt="Addressbook" src="<?php echo $url_images; ?>title.gif" width="341" height="74">
</a>
</td>
<td width=100% align=right valign=top>
<?php
  $lang_cnt = 0;

  if( $_GET["more_langs"] == "" && count($default_languages) > 0) {
    $loop_langs = $default_languages;
    ?>[<a href='?more_langs=yes'>+</a>] | <?php
  } else {
    $loop_langs = $supported_langs;
  }
  
  foreach($loop_langs as $supp_lang) {
    if($supp_lang != $lang)
    {
    	if($lang_cnt++ > 0)
    	  echo " | ";
      echo "<a href='?lang=$supp_lang'><img border=0 width=16 height=11 title='".ucfmsg($supp_lang)."' alt='".ucfmsg($supp_lang)."' src='${url_images}icons/".get_flag($supp_lang).".gif'/></a>";
    }
  }    
?>
 - 
</td>
<td align=right valign=top>
	<a href="preferences<?php echo $page_ext_qry; ?>from=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"><?php echo ucfmsg('PREFERENCES'); ?></td>
  </tr></table>
  <tr> 
    <td width="10" bgcolor="#003366">&nbsp; </td>
    <td width="107" valign="top"> 
      <?php include("include/nav.inc.php"); ?>
    </td>
    <td valign="top">