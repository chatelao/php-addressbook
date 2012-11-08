<?php

  $zpush_states_dir = dirname(__FILE__) . "/../z-push/states/";
  $zpush_logs_dir   = dirname(__FILE__) . "/../z-push/logs/";

//  $zpush_logs_level = LOGLEVEL_DEBUG; // Increase debug level to find bugs
  $zpush_logs_level = LOGLEVEL_INFO;

//  $zpush_log_users       = array('admin');  // Track the xml-messages of one user
  $zpush_log_users       = array();
  $zpush_log_users_level = LOGLEVEL_WBXML;

?>