<?php

$mailers['Standard (mailto:)']     = "mailto:";
// $mailers['Outlook (mailto:)']     = "mailto:";
// $mailers['Thunderbird (mailto:)'] = "mailto:";
$mailers['gmail']     = "https://mail.google.com/mail/?fs=1&view=cm&shva=1&to=";
$mailers['yahoo']     = "http://compose.mail.yahoo.com/?to=";
$mailers['hotmail']   = "http://www.hotmail.msn.com/secure/start?action=compose&to=";

function getMailer() {
	 
	global $mailers;
	
	if(isset($mailers[getPref('mailer')])) {
		return $mailers[getPref('mailer')];
	} else {
		return "mailto:";
	}
}

function getMailerDelim() {
	 
	global $mailers;
	
	if(getPref('mailer') == 'colon') {
		return ",";
  } else {
		// return ";";
		return "%3B";
	}
}
?>