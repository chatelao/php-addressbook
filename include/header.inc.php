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
    <img border=0 title="Addressbook" alt="Addressbook" src="title.gif" width="341" height="74">
</a>
</td>
<td width=100% align=right valign=top>
	<a href="preferences<?php echo $page_ext; ?>?from=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"><?php echo ucfmsg('PREFERENCES'); ?></td>
  </tr></table>
  <tr> 
    <td width="10" bgcolor="#003366">&nbsp; </td>
    <td width="107" valign="top"> 
      <?php include("include/nav.inc.php"); ?>
    </td>
    <td valign="top">