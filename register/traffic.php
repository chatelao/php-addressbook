<? include"auth_check_header.php";  


function nicetrim ($s) {
// limit the length of the given string to $MAX_LENGTH char
// If it is more, it keeps the first $MAX_LENGTH-3 characters 
// and adds "..."
// It counts HTML char such as á as 1 char.
//

  $MAX_LENGTH = 80;
  $str_to_count = html_entity_decode($s);
  if (strlen($str_to_count) <= $MAX_LENGTH) {
    return $s;
  }

  $s2 = substr($str_to_count, 0, $MAX_LENGTH - 3);
  $s2 .= "...";
  return htmlentities($s2);
}                   

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<META NAME="KEYWORDS" CONTENT="PHP Login Script Free download secure encrypted passwords php mysql simple login script"> 
<META NAME="DESCRIPTION"
CONTENT="Basic Login Script for PHP to Mysql Download it for free and modify as you see fit">
<meta http-equiv="content-language" content="en">
<title>Basic Login - Download a free basic PHP Login Script</title> 
</head>

<body bgcolor="ebebeb" topmargin="0">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" bgcolor="ffffff"><div align="center">
      <p><strong><font size="5" face="Verdana, Arial, Helvetica, sans-serif">BasicLogin.com</font></strong>
	  <table border="0" cellspacing="0" cellpadding="0" width="750" align="center"><tbody><tr><td colspan="3" width="750" height="38" valign="top"><a href="http://www.wvr.org" target="_blank"></a><a href="http://wvr.org/email_donate.php" target="_blank"></a><a href="http://www.percontact.com" target="_blank"></a><a href="http://www.percontact.com" target="_blank"><img src="http://www.skincaresolve.com/images/200801152254030801_pc_blue_template_top_750w.jpg" border="0" alt="top bar" /></a></td></tr><tr><td width="35" background="http://www.skincaresolve.com/images/200801152256170801_pc_blue_template_left_bg_35w.jpg"> </td><td width="669" valign="top"><table border="0" cellspacing="0" cellpadding="0" width="680"><tbody><tr><td height="72" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td width="33%" height="181" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif"><font face="Verdana, Arial, Helvetica, sans-serif"><font face="Verdana, Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif" size="3"><b><font face="Verdana, Arial, Helvetica, sans-serif">
		  
		   </font></b></font></font></font></font><form action="traffic.php" method="post" name="form" id="form">
		  
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><div>
                   <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><a href='admin_index.php'><font size="2"><strong>Admin Index</strong></font></a></font><br />
                     <br />
                   </div>
                 </div>
                 <div align="center">
                     <font size="3" face="Verdana, Arial, Helvetica, sans-serif"><b><input name="var" type='text' id='var' />
                   &nbsp;
                   <input type="submit" name="Submit22" value="Search traffic" />
                 </b></font></div></td>
               </tr>
             </table>
             <p><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Sort By: <a href="traffic.php?criteria=id">ID</a></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b> | <a href="traffic.php?criteria=ip">IP</a> | <a href="traffic.php?criteria=date">Date</a> | <a href="traffic.php?criteria=site">Site</a> | <a href="traffic.php?criteria=type">Type</a></b></font></p>
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><div align="left"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><b>
                   <?php

$s=$_REQUEST['s'];

$limit=100;

// Build SQL Query  

$criteria_url = $_REQUEST['criteria'];
//secho "Criteria:$criteria_url<br>";

If($criteria_url==''){$criteria="id";}else{$criteria=$criteria_url;}

//echo "Criteria:$criteria<br>";


$var = $_REQUEST['var'];

$query = "select * from traffic WHERE `id` LIKE \"%$var%\" OR `site` LIKE \"%$var%\" OR `type` LIKE \"%$var%\" OR `date` LIKE \"%$var%\" OR `ip` LIKE \"%$var%\" OR `link` LIKE \"%$var%\" OR `page` LIKE \"%$var%\"order by `$criteria` desc"; 


 $numresults=mysql_query($query);
 $numrows=mysql_num_rows($numresults);
 
 echo"<font face='Arial, Helvetica, sans-serif' size='2' color='#000000'>Results: $numrows</font><hr>"; 

 if (empty($s)) {
  $s=0;
  }

// get results
  $query .= " limit $s,$limit";

// get results
  $result = mysql_query($query) or die("Couldn't execute query");


// now you can display the results returned
  while ($row= mysql_fetch_array($result)) {
  
  $id= $row["id"];
  $ip= $row["ip"];
  $date = $row["date"];
  $site = $row["site"];
  $type= $row["type"];
  $link_raw= $row["link"];
  $page= $row["page"];
  $link=nicetrim($link_raw);

  
  
echo "<font face='Arial, Helvetica, sans-serif' size='1' color='#000000'>$id | $ip | $date | $site | $type | $page </font><font face='Arial, Helvetica, sans-serif' size='1' color='#666666'>$link<br><br></font>";

}

$currPage = (($s/$limit) + 1);

//break before paging
  echo "<br />";

  // next we need to do the links to other results
  if ($s>=1) { // bypass PREV link if s is 0
  $prevs=($s-$limit);
  print "&nbsp;<a href=\"$PHP_SELF?s=$prevs&var=$var&criteria=$criteria\">&lt;&lt; 
  Prev 100</a>&nbsp&nbsp;";
  }

// calculate number of pages needing links
  $pages=intval($numrows/$limit);

// $pages now contains int of pages needed unless there is a remainder from division

  if ($numrows%$limit) {
  // has remainder so add one page
  $pages++;
  }

// check to see if last page
  if (!((($s+$limit)/$limit)==$pages) && $pages!=1) {

  // not last page so give NEXT link
  $news=$s+$limit;

  echo "&nbsp;<a href=\"$PHP_SELF?s=$news&var=$var&criteria=$criteria\">Next 100 &gt;&gt;</a>";
  }

$a = $s + ($limit) ;
  if ($a > $numrows) { $a = $numrows ; }
  $b = $s + 1 ;

?>
                 </b></font></div></td>
               </tr>
             </table>
             <p>&nbsp;
                          </p>
		   </form>
          </td>
        </tr>
      </table>	  
	  <p align="left" style="margin: 0in 0in 0pt">&nbsp;</p>
                     </td>
     </tr></tbody></table></td><td width="36" background="http://www.skincaresolve.com/images/200801152254030801_pc_blue_template_right_bg_35w.jpg"> </td></tr><tr><td colspan="3"><a href="http://www.percontact.com" target="_blank"><img src="http://www.skincaresolve.com/images/200801152254030801_pc_blue_template_bottom_750w.jpg" border="0" alt="bottom bar" /></a><a href="http://wvr.org/email_donate.php" target="_blank"></a></td></tr></tbody></table>
	  
	  </p>
      <p>&nbsp;</p>
      <p align="left"><br />  
          <br />
      </p>
    </div></td>
  </tr>
</table>
<?
//View Tracking Code for reference

		   
		   //Time & Date
			$date = date ('m/d/y  g:i a');
			
			//IP Address
			$ip = $_SERVER['REMOTE_ADDR'];
			
			$type = "view";
			
			$site = "basiclogin.com";

//Query Block Tracking: WHERE '$ip' != '69.254.101.167'

	   $query = "INSERT INTO `traffic` (`date`,`ip`,`link`,`notes`,`site`,`type`) 
         VALUES ( '$date','$ip','$link','$notes','$site','$type' WHERE '$ip' != '69.254.101.167')";   
		 		 
		  // save the info to the database
   $results = mysql_query( $query );
   
?>
</body>
</html>
