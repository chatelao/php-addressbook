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

  //
  // Filter the displayed languages:
  // - Default if exists
  // - Others if selected (All minus Default)
  // - All if nothing is defined
  //
  if( count($default_languages) > 0) {
    if( !isset($_GET["more_langs"]) || $_GET["more_langs"] == "") {
      $loop_langs = $default_languages;
      ?>[<a title='other languages'href='?more_langs=yes'>+</a>] | <?php
    } else {
      $loop_langs = array_diff($supported_langs, $default_languages);
    }
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

  if(  ! ((!isset($_GET["more_langs"]) || $_GET["more_langs"] == "") && count($default_languages) > 0) ) {
    ?> | [<a title='default languages' href='?more_langs='> - </a>]<?php
  }
?>
</td>
<td align=right valign=top>
	<a href="preferences<?php echo $page_ext_qry; ?>from=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"><?php echo ucfmsg('PREFERENCES'); ?></td>
  </tr></table>
  <tr> 
    <td width="10" bgcolor="#003366">&nbsp; </td>
    <td width="107" valign="top"> 
<?php
  if($is_logged_in) {
    include("include/nav.inc.php"); 
  }
?>
    </td>
    <td valign="top">
<?php
//*
if(! $is_logged_in) { ?>
  <form accept-charset="utf-8" method="POST" action="<?php $PHP_SELF ?>" name="searchform">
  	<table><tr><td>
    <b>User:</b>
    </td></tr><tr><td>
    <input type="text" value="<?php echo $user; ?>" name="user" title="<?php echo ucfmsg('SEARCH_FOR_ANY_TEXT'); ?>" size="45"  tabindex="0"/>
    </td></tr><tr><td>
    <b>Password:</b>
    </td></tr><tr><td>
    <input type="password" name="pass" title="<?php echo ucfmsg('SEARCH_FOR_ANY_TEXT'); ?>" size="45"  tabindex="0"/>
    </td></tr><tr><td>
    <script language="javascript">
    <!--
       document.searchform.searchstring.focus();
      --></script>
    <input type="submit" value="<?php echo ucfirst(msg("LOGIN")) ?>"></td>
    <!--
    <input type="submit" value="<?php echo ucfirst(msg("NEW_PASS")) ?>"></td>
      -->
  </form>
<?php
	exit;
} else {
?>
<?php
}
//*/
?>