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
        <p align="center"><? include"include_menu.php"; ?></p>
        <form action="edit_user_save.php" method="post" name="form" id="form">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div align="center">
                  <p>&nbsp;<?
			
$var = $_REQUEST['q'];
$id = $_REQUEST['id'];
			
$color1 = "#ffffff";  
$color2 = "#ebebeb"; 	

echo"<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>
               <table width='100%' cellpadding='5'>";	
			   

$query = "SELECT * FROM users WHERE `id`='$id'"; 

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
$notes= $row["notes"];
$email= $row["email"];
$permissions= $row["permissions"];
$email_sub = substr($email, 0, 50);

} 


echo"</tabel></font>";

			
			?>
</p>
                  <table width='49%' border='0' align="center" cellpadding='10' cellspacing='0'>
                    <tr>
                      <td width="295" bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">ID</font></td>
                      <td width='342' bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                       <? echo $id; ?><input type="hidden" width="50" name="id" value = '<? echo $id; ?>' /> </font></td>
                    </tr>
                    <tr>
                      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Username</font></td>
                      <td width='342'><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                      <? echo $username; ?></font></td>
                    </tr>
                    <tr>
                      <td bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password</font></td>
                      <td width='342' bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                       <? echo $password; ?></font></td>
                    </tr>
                    <tr>
                      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Lastname</font></td>
                      <td width='342'><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                        <input type="text" width="50" name="lastname" value = '<? echo $lastname; ?>' />
                      </font></td>
                    </tr>
                    <tr>
                      <td bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Firstname</font></td>
                      <td width='342' bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                        <input type="text" width="50" name="firstname" value = '<? echo $firstname; ?>' />
                      </font></td>
                    </tr>
                    <tr>
                      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Phone</font></td>
                      <td width='342'><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                        <input type="text" width="50" name="phone" value = '<? echo $phone; ?>' />
                      </font></td>
                    </tr>
                    <tr>
                      <td bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email </font></td>
                      <td width='342' bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                        <input type="text" width="50" name="email" value = '<? echo $email; ?>' />
                      </font></td>
                    </tr>
					   <tr>
                      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Permissions</font></td>
                      <td width='342'><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                        <input type="text" width="50" name="permissions" value = '<? echo $permissions; ?>' />
                      </font></td>
                    </tr>
					 <tr>
                      <td bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Notes</font></td>
                      <td width='342' bgcolor="#ebebeb"><p><b>
                        <textarea name="notes" cols="45" rows="8"><? echo $notes; ?></textarea>
                       </b></p>                       </td>
                    </tr>
                  </table>
                  <p>
                    <input type="submit" name="Submit" value="Save Changes" />
                  </p>
                  <p>&nbsp;</p>
                  <p><a href="delete_user_confirm.php?id=<? echo $id; ?>"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Delete User </font></a></p>
              </div></td>
            </tr>
          </table>
          <p>
          
          <p>&nbsp;</p>
          <p>
          
          <p>
          <p>&nbsp;</p>
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
