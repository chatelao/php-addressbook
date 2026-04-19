<?php
if (!function_exists('mysql_connect')) {
    function mysql_connect($server, $username, $password, $new_link = false, $client_flags = 0) {
        $GLOBALS['mysql_mysqli_link'] = mysqli_connect($server, $username, $password);
        return $GLOBALS['mysql_mysqli_link'];
    }
    function mysql_select_db($database_name, $link_identifier = null) {
        if ($link_identifier === null) $link_identifier = (isset($GLOBALS['mysql_mysqli_link']) ? $GLOBALS['mysql_mysqli_link'] : null);
        return mysqli_select_db($link_identifier, $database_name);
    }
    function mysql_query($query, $link_identifier = null) {
        if ($link_identifier === null) $link_identifier = (isset($GLOBALS['mysql_mysqli_link']) ? $GLOBALS['mysql_mysqli_link'] : null);
        return mysqli_query($link_identifier, $query);
    }
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH) {
        return mysqli_fetch_array($result, $result_type);
    }
    function mysql_fetch_assoc($result) {
        return mysqli_fetch_assoc($result);
    }
    function mysql_fetch_row($result) {
        return mysqli_fetch_row($result);
    }
    function mysql_num_rows($result) {
        return mysqli_num_rows($result);
    }
    function mysql_numrows($result) {
        return mysqli_num_rows($result);
    }
    function mysql_error($link_identifier = null) {
        if ($link_identifier === null) $link_identifier = (isset($GLOBALS['mysql_mysqli_link']) ? $GLOBALS['mysql_mysqli_link'] : null);
        return mysqli_error($link_identifier);
    }
    function mysql_errno($link_identifier = null) {
        if ($link_identifier === null) $link_identifier = (isset($GLOBALS['mysql_mysqli_link']) ? $GLOBALS['mysql_mysqli_link'] : null);
        return mysqli_errno($link_identifier);
    }
    function mysql_real_escape($unescaped_string, $link_identifier = null) { return mysql_real_escape_string($unescaped_string, $link_identifier); }
    function mysql_real_escape_string($unescaped_string, $link_identifier = null) {
        if ($link_identifier === null) $link_identifier = (isset($GLOBALS['mysql_mysqli_link']) ? $GLOBALS['mysql_mysqli_link'] : null);
        return mysqli_real_escape_string($link_identifier, $unescaped_string);
    }
    function mysql_close($link_identifier = null) {
        if ($link_identifier === null) $link_identifier = (isset($GLOBALS['mysql_mysqli_link']) ? $GLOBALS['mysql_mysqli_link'] : null);
        return mysqli_close($link_identifier);
    }
    function mysql_ping($link_identifier = null) {
        if ($link_identifier === null) $link_identifier = (isset($GLOBALS['mysql_mysqli_link']) ? $GLOBALS['mysql_mysqli_link'] : null);
        return mysqli_ping($link_identifier);
    }
    function mysql_data_seek($result, $row_number) {
        return mysqli_data_seek($result, $row_number);
    }
}
