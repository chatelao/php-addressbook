<?php
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
                  <p>&nbsp;<?php

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

$color1 = "#ffffff";
$color2 = "#ebebeb";

echo"<font size='2' face='Verdana, Arial, Helvetica, sans-serif'>
               <table width='100%' cellpadding='5'>";


$sql = "SELECT * FROM users WHERE `user_id`=?";

$result = $db_access->execute($sql, array($id));

// now you can display the results returned
if ($row = $db_access->fetchArray($result)) {

$id= $row["user_id"];
$username= $row["username"];
$password= $row["md5_pass"];
$lastname= $row["lastname"];
$firstname= $row["firstname"];
$phone= $row["phone"];
$notes= isset($row["notes"]) ? $row["notes"] : '';
$email= $row["email"];
$permissions= isset($row["permissions"]) ? $row["permissions"] : '';
$email_sub = substr($email, 0, 50);

}


echo"</table></font>";


			?>
</p>
                  <table width='49%' border='0' align="center" cellpadding='10' cellspacing='0'>
                    <tr>
                      <td width="295" bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">ID</font></td>
                      <td width='342' bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                       <? echo htmlspecialchars($id); ?><input type="hidden" width="50" name="id" value = '<? echo htmlspecialchars($id); ?>' /> </font></td>
                    </tr>
                    <tr>
                      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Username</font></td>
                      <td width='342'><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                      <? echo htmlspecialchars($username); ?></font></td>
                    </tr>
                    <tr>
                      <td bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password</font></td>
                      <td width='342' bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                       <? echo htmlspecialchars($password); ?></font></td>
                    </tr>
                    <tr>
                      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Lastname</font></td>
                      <td width='342'><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                        <input type="text" width="50" name="lastname" value = '<? echo htmlspecialchars($lastname); ?>' />
                      </font></td>
                    </tr>
                    <tr>
                      <td bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Firstname</font></td>
                      <td width='342' bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                        <input type="text" width="50" name="firstname" value = '<? echo htmlspecialchars($firstname); ?>' />
                      </font></td>
                    </tr>
                    <tr>
                      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Phone</font></td>
                      <td width='342'><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                        <input type="text" width="50" name="phone" value = '<? echo htmlspecialchars($phone); ?>' />
                      </font></td>
                    </tr>
                    <tr>
                      <td bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email </font></td>
                      <td width='342' bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                        <input type="text" width="50" name="email" value = '<? echo htmlspecialchars($email); ?>' />
                      </font></td>
                    </tr>
					   <tr>
                      <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Permissions</font></td>
                      <td width='342'><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                        <input type="text" width="50" name="permissions" value = '<? echo htmlspecialchars($permissions); ?>' />
                      </font></td>
                    </tr>
					 <tr>
                      <td bgcolor="#ebebeb"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Notes</font></td>
                      <td width='342' bgcolor="#ebebeb"><p><b>
                        <textarea name="notes" cols="45" rows="8"><? echo htmlspecialchars($notes); ?></textarea>
                       </b></p>                       </td>
                    </tr>
                  </table>
                  <p>
                    <input type="submit" name="Submit" value="Save Changes" />
                  </p>
                  <p>&nbsp;</p>
                  <p><a href="delete_user_confirm.php?id=<? echo htmlspecialchars($id); ?>"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Delete User </font></a></p>
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
