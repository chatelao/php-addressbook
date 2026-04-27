<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . "database.interface.php";

/**
 * MySQLi Implementation of the Database Abstraction Layer
 */
class MysqliDatabase implements DatabaseInterface {
    private $link;

    public function connect($server, $username, $password, $new_link = false, $client_flags = 0) {
        try {
            $this->link = mysqli_connect($server, $username, $password);
        } catch (Exception $e) {
            $this->link = false;
        }
        return $this->link;
    }

    public function selectDb($database_name) {
        if (!($this->link instanceof mysqli)) return false;
        return mysqli_select_db($this->link, $database_name);
    }

    public function query($query) {
        if (!($this->link instanceof mysqli)) return false;
        return mysqli_query($this->link, $query);
    }

    public function fetchArray($result, $result_type = MYSQLI_BOTH) {
        if (!($result instanceof mysqli_result)) return false;
        return mysqli_fetch_array($result, $result_type);
    }

    public function fetchAssoc($result) {
        if (!($result instanceof mysqli_result)) return false;
        return mysqli_fetch_assoc($result);
    }

    public function fetchRow($result) {
        if (!($result instanceof mysqli_result)) return false;
        return mysqli_fetch_row($result);
    }

    public function numRows($result) {
        if (!($result instanceof mysqli_result)) return 0;
        return mysqli_num_rows($result);
    }

    public function error() {
        if (!($this->link instanceof mysqli)) return "";
        return mysqli_error($this->link);
    }

    public function errno() {
        if (!($this->link instanceof mysqli)) return 0;
        return mysqli_errno($this->link);
    }

    public function realEscapeString($unescaped_string) {
        if (!($this->link instanceof mysqli)) return addslashes($unescaped_string);
        return mysqli_real_escape_string($this->link, $unescaped_string);
    }

    public function close() {
        if (!($this->link instanceof mysqli)) return true;
        return mysqli_close($this->link);
    }

    public function dataSeek($result, $row_number) {
        if (!($result instanceof mysqli_result)) return false;
        return mysqli_data_seek($result, $row_number);
    }

    public function insertId() {
        if (!($this->link instanceof mysqli)) return 0;
        return mysqli_insert_id($this->link);
    }
}
