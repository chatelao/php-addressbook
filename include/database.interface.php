<?php

/**
 * Database Abstraction Layer Interface
 */
interface DatabaseInterface {
    /**
     * Connect to the database server
     */
    public function connect($server, $username, $password, $new_link = false, $client_flags = 0);

    /**
     * Select a database
     */
    public function selectDb($database_name);

    /**
     * Execute a query
     */
    public function query($query);

    /**
     * Fetch a result row as an associative, a numeric array, or both
     */
    public function fetchArray($result, $result_type = MYSQLI_BOTH);

    /**
     * Fetch a result row as an associative array
     */
    public function fetchAssoc($result);

    /**
     * Fetch a result row as a numeric array
     */
    public function fetchRow($result);

    /**
     * Get the number of rows in a result
     */
    public function numRows($result);

    /**
     * Get the last error message
     */
    public function error();

    /**
     * Get the last error number
     */
    public function errno();

    /**
     * Escapes special characters in a string for use in an SQL statement
     */
    public function realEscapeString($unescaped_string);

    /**
     * Close the database connection
     */
    public function close();

    /**
     * Move the internal result pointer
     */
    public function dataSeek($result, $row_number);

    /**
     * Get the ID generated in the last query
     */
    public function insertId();

    /**
     * Execute a query with parameters using prepared statements
     *
     * @param string $query The SQL query with placeholders (?)
     * @param array $params The parameters to bind to the placeholders
     * @return mixed The result of the query (mysqli_result for SELECT, bool for others)
     */
    public function execute($query, array $params = []);
}
