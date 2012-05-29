<? 
//Set permission level threshold for this page remove if page is good for all levels
$permission_level=5;

include"auth_check_header.php";

?>	

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>AMS Agent Index</title>
</head>

<body topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div align="center"><strong><font size="3"><font face="Verdana, Arial, Helvetica, sans-serif">
      <legend><font size="4">Admin Index</font><font size="2"><br />
        </font></legend>
      </font></font></strong>
    </div>
      <div style="text-align:left; width:100%; margin-top:10px;">
        <p align="center">
          <? include"include_menu.php"; ?> 
          <font size="2" face="Verdana, Arial, Helvetica, sans-serif">|</font> <strong><font face="Verdana, Arial, Helvetica, sans-serif"><a href="traffic.php"><font size="2">Traffic Report</font></a></font></strong></p>
        <form action="admin_index.php" method="post" name="form" id="form">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div align="center">
                  <input name="q" type='text' id='q' />
                &nbsp;
                <input type="submit" name="Submit22" value="Search Users" />
              </div></td>
            </tr>
          </table>
          <p>
            <?
			
$var = $_REQUEST['q'];
			
$color1 = "#ffffff";  
$color2 = "#ebebeb"; 	

echo"<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>
               <table width='100%' cellpadding='5'>";	
			   

$query = "SELECT * FROM users WHERE (`id` LIKE \"%$var%\" OR `username` LIKE \"%$var%\" OR `password` LIKE \"%$var%\" OR `email` LIKE \"%$var%\" OR `lastname`LIKE \"%$var%\" OR `firstname`LIKE \"%$var%\") ORDER BY `id` desc"; 

$numresults=mysql_query($query);
$numrows=mysql_num_rows($numresults); 

// get results
$result = mysql_query($query) or die("Couldn't execute query");

// now you can display the results returned
while ($row= mysql_fetch_array($result)) {

$id= $row["id"];
$username= $row["username"];
$password= $row["password"];
$lastname= $row["lastname"];
$firstname= $row["firstname"];
$phone= $row["phone"];
$email= $row["email"];
$permissions = $row["permissions"];
$email_sub = substr($email, 0, 50);


   $row_color = ($row_count % 2) ? $color1 : $color2; 
//DISPLAY DATA HERE_____________

echo "
    <tr>
    <td width='100%' bgcolor='$row_color'>
	<table width= '100%'><tr>
                <td width='20%' bgcolor='$row_color' >$username</a></td>
                <td width='10%' bgcolor='$row_color' >$lastname, $firstname</td>
                <td width='10%' bgcolor='$row_color' >$phone</td>
                <td width='20%' bgcolor='$row_color' >$email_sub</td>
                <td width='10%' bgcolor='$row_color' >$permissions</td> 
                <td width='100' bgcolor='$row_color' ><a href='edit_user.php?id=$id'>edit</a></td>
				</tr>
				</table>
	</td>
    </tr>
           ";
    $row_count++; 
} 


echo"</tabel></font>";

			
			?>
          </p>
          <p>&nbsp; </p>
        </form>
        </p>
      </div></td>
  </tr>
</table>
<br>
<A href="http://www.amsmerchant.com" target="_blank"></A><br>
<br>
</body>
</html>
