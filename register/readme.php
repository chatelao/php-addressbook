<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Basic Login Readme</title>
</head>

<body>
<div style="text-align:left; width:800px; margin-top:10px;">
  <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Basic Login is a basic PHP login script that can be  downloaded used and modified under the general user public license  provisions.&nbsp; This is not a PHP login  script for a government institution or fortune 500 company as it uses standard  encryption and cookie based user identification that a determined hacker might  exploit.&nbsp; It is, however, perfect for a  standard website that would benefit from a basic PHP to MySQL login script that  is easy to deploy and uses standard methods of restricting access and granting  permissions.</font></p>
  <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">After writing countless PHP login scripts using various  combinations of standard components tailored to the needs of the sites for  which they were designed, I got wise and distilled the elements that I used  most frequently into a basic application that can be easily uploaded and  deployed on any project I was working on.&nbsp;  While there are no grand inventions happening here, Basic Login should  do what you need it to do right out of the gate.&nbsp; Features, functions and components are as  follows:</font></p>
  <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">PHP to MySQL structure<br />
    Password encryption<br />
    Email forgotten password hint<br />
    Email password change/ recreation<br />
    New user account creation with error handling<br />
    User permission level control<br />
    User login routing by permission on login<br />
    Central configuration file<br />
    Administrative user management report<br />
    First user gets admin permissions</font></p>
  <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Using Basic Login is easy:</font></p>
  <ol start="1" type="1">
    <li><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Download       Basic Login files</font></li>
    <li><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Unzip       Basic Login files</font></li>
    <li><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Upload       Basic Login files to a directory of your choice</font></li>
    <li><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Create       users table in MySQL:<br />
      Just run this query or cut and paste the following code into the SQL       window of phpmyadmin or an equivalent MySQL control panel:</font></li>
  </ol>
  <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">CREATE TABLE `users` (<br />
&nbsp;  `id` int(11) NOT NULL auto_increment,<br />
&nbsp;  `username` varchar(50) NOT NULL default '',<br />
&nbsp;  `password` varchar(150) NOT NULL default '',<br />
&nbsp;  `password_hint` varchar(255) NOT NULL default '',<br />
&nbsp;  `lastname` varchar(50) NOT NULL default '',<br />
&nbsp;  `firstname` varchar(50) NOT NULL default '',<br />
&nbsp;  `email` varchar(100) NOT NULL default '',<br />
&nbsp;  `phone` varchar(50) NOT NULL default '',<br />
&nbsp;  `address1` varchar(100) NOT NULL default '',<br />
&nbsp;  `address2` varchar(100) NOT NULL default '',<br />
&nbsp;  `city` varchar(80) NOT NULL default '',<br />
&nbsp;  `state` varchar(20) NOT NULL default '',<br />
&nbsp;  `zip` varchar(20) NOT NULL default '',<br />
&nbsp;  `country` varchar(50) NOT NULL default '',<br />
&nbsp;  `url` varchar(125) NOT NULL default '',<br />
&nbsp;  `permissions` varchar(20) NOT NULL default '1',<br />
&nbsp;  PRIMARY KEY&nbsp; (`id`)<br />
)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></p>
  <ol start="5" type="1">
    <li><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Open       login_config.php and set the configuration values as desired</font></li>
    <li><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Add       your first account.&nbsp; It will be       configured as the administrator by default.&nbsp; </font></li>
    <li><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Put pages behind the security framework &lt; ? include &quot;auth_check_header&quot;; ?&gt; at the very top of any pages that are for members only. Make sure they are in the same directory as the Basic Login files. </font></li>
    <li><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Happy       coding!</font></li>
  </ol>
  <p class="submit">&nbsp;</p>
  <p>&nbsp; </p>
</div>
</body>
</html>
