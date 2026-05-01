<?php

include ("include/dbconnect.php");

if (!$asterisk_integration) {
      die();
}


//get the user
$username = $login->getUser()->getName();

//find the extension from th db
$user_q = mysql_query("
      SELECT phone FROM users WHERE username = '{$username}'
");

$extensionrow = mysql_fetch_array($user_q);
if (is_array($extensionrow)) {
      
      //get the config file
      require("config/cfg.asterisk.php");
      


      $a_number = $extensionrow['phone'];
      $b_number = preg_replace("/[^a-zA-Z0-9]/", "", $_GET['b_number']);
            

      #$a_context = "from-internal";
      $b_context = "from-internal";

      #specify the amount of time you want to try calling the specified channel before hangin up
      $wait_time = "30";
      $timeout = $wait_time * 1000;
      
      #specify the priority you wish to place on making this call
      $priority = "1";


      $errno=0 ;
      $errstr=0 ;
      
      //$caller_id = "$b_number";
	$caller_id = $a_number;	
		
      
      $oSocket = fsockopen ($asterisk_ami_host, $asterisk_ami_port, $errno, $errstr, 20);
      if (!$oSocket)
      {
        echo "Error: Cannot connect to asterisk ami $errstr ($errno)<br>\n";
      }
      else
      {



            fputs($oSocket, "Action: login\r\n");
            fputs($oSocket, "Events: off\r\n");
            fputs($oSocket, "Username: $asterisk_ami_user\r\n");
            fputs($oSocket, "Secret: $asterisk_ami_pass\r\n\r\n");
            fputs($oSocket, "Action: originate\r\n");

            fputs($oSocket, "Channel: SIP/$a_number\r\n");
            #fputs($oSocket, "Channel: Local/00{$a_number}@{$a_context}\r\n");
            fputs($oSocket, "WaitTime: $wait_time\r\n");
            fputs($oSocket, "Timeout: $timeout\r\n");
            fputs($oSocket, "CallerId: $caller_id\r\n");
            fputs($oSocket, "Exten: $b_number\r\n");
            fputs($oSocket, "Context: $b_context\r\n");
            fputs($oSocket, "Priority: $priority\r\n\r\n");

            //$returnn = fgets($oSocket);

            /*
            $returnn = fgets($oSocket);
            //echo $returnn."\n";
            $returnn = fgets($oSocket);
            //echo $returnn."\n";
            $returnn = fgets($oSocket);
            //echo $returnn."\n";
            $returnn = fgets($oSocket);
            //echo $returnn."\n";
            $returnn = fgets($oSocket);
            if ($returnn == "Response: Success\r\n")
            {
	            ////echo $returnn;
	            echo "OK\n";
	            $sent_ok = true;
	            break;
            }
            #echo $returnn."<br>";
            #$returnn = fgets($oSocket);
            #echo $returnn."<br>";

                          
            //echo $returnn."<br>";
            
            */
            
            fputs($oSocket, "Action: Logoff\r\n\r\n");


            //sleep(1);
            usleep(15000);
            fclose($oSocket);
            
            
            echo "OK";
      }
      


}
