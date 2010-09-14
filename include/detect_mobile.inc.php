<?php

function detectMobile() {


   //
   // CONSTANTS
   //
   $agent_match = 'up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone';
   
   $mobile_agents_4prefix = array(
       'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
       'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
       'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
       'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
       'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
       'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
       'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
       'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
       'wapr','webc','winw','winw','xda','xda-');

   $result = false;

   //
   // Some known USER_AGENTS
   //
   if( preg_match('/('.$agent_match.')/i'
      , strtolower($_SERVER['HTTP_USER_AGENT']))) {
       $result=true;
   }
   if(in_array( strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4))
              , $mobile_agents_4prefix)) {
       $result=true;
   }

   //
   // WAP enabled 
   //
   if(   strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0
      or isset($_SERVER['HTTP_X_WAP_PROFILE'])
      or isset($_SERVER['HTTP_PROFILE'])) {
       $result=true;
   }

   if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0) {
       $result = true;
   }

   if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
       $result = false;
   }
}
?>