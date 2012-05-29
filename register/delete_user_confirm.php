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
      <legend><font size="4">Delete User </font><font size="2"><br />
        </font></legend>
      </font></font></strong>
    </div>
      <div style="text-align:left; width:100%; margin-top:10px;">
        <p align="center"><? include"include_menu.php"; ?></p>
        <p align="center">
          <?
			  
			  
			  $id = $_REQUEST['id'];
			  
			  echo "<br><br><font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='#000000'>Are you sure you want to delete user ID: $id?<br><br><a href='edit_user.php?id=$id'>No</a><br><br><a href='delete_user.php?id=$id'>Yes</a></font>";
			  
		
			  ?>
</p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div align="center"></div></td>
            </tr>
        </table>
         
        
      </div></td>
  </tr>
</table>
<br>
<A href="http://www.amsmerchant.com" target="_blank"></A><br>
<br>
</body>
</html>
