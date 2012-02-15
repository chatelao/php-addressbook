<?php

$mailers['Standard (mailto:)']     = "mailto:";
$mailers['Standard (mailto-bcc)']    = "mailto:?bcc=";
// $mailers['Outlook (mailto:)']     = "mailto:";
// $mailers['Thunderbird (mailto:)'] = "mailto:";
$mailers['gmail']     = "https://mail.google.com/mail/?fs=1&view=cm&shva=1&to=";
$mailers['yahoo']     = "http://compose.mail.yahoo.com/?to=";
$mailers['hotmail']   = "http://www.hotmail.msn.com/secure/start?action=compose&to=";

function getMailer() {
	 
	global $mailers, $webmailer;
	
	if(isset($mailers[getPref('mailer')])) {
		return $mailers[getPref('mailer')];
	} elseif(isset($webmailer) && isset($mailers[$webmailer])) {
		return $mailers[$webmailer];
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