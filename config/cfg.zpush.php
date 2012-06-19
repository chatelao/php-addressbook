<?php

  $zpush_states_dir = dirname(__FILE__).DIRECTORY_SEPARATOR.".."
                                       .DIRECTORY_SEPARATOR."s-push"
                                       .DIRECTORY_SEPARATOR."states"
                                       .DIRECTORY_SEPARATOR;

  $zpush_logs_dir   = dirname(__FILE__).DIRECTORY_SEPARATOR.".."
                                       .DIRECTORY_SEPARATOR."z-push"
                                       .DIRECTORY_SEPARATOR."logs"
                                       .DIRECTORY_SEPARATOR;
  $zpush_logs_level = LOGLEVEL_INFO;

  $zpush_log_users       = array();
  $zpush_log_users_level = LOGLEVEL_WBXML;

?>