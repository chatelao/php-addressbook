<?php
  
  //
  // Default webprovider (mailto:, gmail.com, yahoo.com)
  //  * Used to provide "mailto:" links in contacts
  //
  // $webmail_provider = "gmail";
  // $webmail_provider = "yahoo";
  // $webmail_provider = "hotmail";

  //
  // Incoming Mailbox to parse and add mails:
  // - See: http://www.php.net/manual/de/function.imap-open.php
  //
  
  //*
  // - Please create a folder "Processed" in your mailbox!
  //
  $mail_box  = "{pop.your-domain.com:993/imap/ssl/novalidate-cert}INBOX";
  $mail_user = "split@your-domain.com";
  $mail_pass = "secret";
  //*/
  
  //
  // Be careful, all mails not matching
  // one of this addresses will be deleted.
  //
  //
  /*
  $mail_accept[] = "boss@yourdomain.com"
  $mail_accept[] = "you@yourdomain.com"
  //*/

?>