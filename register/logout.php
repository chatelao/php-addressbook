<? 

include"login_config.php";

$cookie_name = $cookiename;

$cookie_value ="Unset";

setcookie($cookie_name,$cookie_value,time() + (-3600),"/", $cookie_domain);

unset($cookie_name); 

?>


<p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><br />
      <font size="4">You are now logged out <br />
        <br />
        <a href="login.php">Return to Login      </a></font></strong></font></p>
