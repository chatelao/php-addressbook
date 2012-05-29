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
      <legend><font size="4">Edit User </font><font size="2"><br />
        </font></legend>
      </font></font></strong>
    </div>
      <div style="text-align:left; width:100%; margin-top:10px;">
        <p align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif"><a href='admin_index.php'><font size="2"><strong>Admin Index</strong></font></a></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;|&nbsp;</font><font face="Verdana, Arial, Helvetica, sans-serif"><a href="traffic.php"><font size="2">Traffic Report</font></a></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">| </font></strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="logout.php">Logout</a></strong></font></p>
     
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><?
			  
			  
			  $id = $_REQUEST['id'];
			  $lastname = $_REQUEST['lastname'];
			  $firstname = $_REQUEST['firstname'];
			  $phone = $_REQUEST['phone'];
			  $email = $_REQUEST['email'];
			  $permissions = $_REQUEST['permissions'];
			  $notes = $_REQUEST['notes'];
			  
			  
$query = "UPDATE `users` SET
`lastname`='$lastname',
`firstname`='$firstname',
`phone`='$phone',
`email`='$email',
`permissions`='$permissions',
`notes`='$notes' 
WHERE `id`='$id'";

// save the info to the database
$results = mysql_query( $query );

// print out the results
if( $results )

{ echo( "<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Your changes have been made sucessfully.</font>" );
}
else
{
die( "Trouble saving information to the database: " . mysql_error() );
}



			  
			  
			  ?>
              <div align="center"></div></td>
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
