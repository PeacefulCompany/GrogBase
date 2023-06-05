<?php
/*
    Author: Vincent Feistel
    Student No: 2256777
*/

/**
 * This class automatically handles connection creation and destroying via reference counting.
 * Thus you can instantiate this class and its subclasses as many times as you want without connection issues
 *
 * This class assumes the following constants are set:
 * - `DB_HOST`: The host URL of the database
 * - `DB_USER`: The user to authenticate the connection
 * - `DB_PASS`: The 
 * - `DB_NAME`: The name of the database to connect to
 */
class Database {
    private $conn;

    private static $global_conn;
    private static $count = 0;
    
    /*
     * Sets up a singleton database connection
     * that is re-used across Database instances
     */
    private static function get_connection() {
        if(self::$global_conn == null) {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if($conn->connect_error) throw self::error("Failed to connect to database: ".$conn->connect_error);
            
            self::$global_conn = $conn;
        }
        return self::$global_conn;
    }

    public function __construct() {
        // connect to database
        $this->conn = self::get_connection();
        self::$count++;
    }

    public function __destruct() {
        self::$count--;
        if(self::$count > 0) return;
        self::$global_conn->close();
        self::$global_conn = null;
    }

    /**
     * Prepares and executes an SQL statement
     * 
     * @param string $query The statement to execute
     * @param string $types The data types of the parameters(i = int, d = float, s = string, b = blob)
     * @param array $params The parameters to bind
     *
     * @throws Exception If the statement fails to prepare/execute, an exception with HTTP code 500 is thrown
     * 
     * @return array|null The result of the query (if any)
     */
    public function query($query = '', $types='', $params=[]) {
        $statement = $this->exec_statement($query, $types, $params);

        $result = $statement->get_result();
        if($result) $result = $result->fetch_all(MYSQLI_ASSOC);
        else $result = null;

        $statement->close();

        return $result;
    }

    /**
     * Retrieves the column names of a column in the database
     * @param string $table The name of the table to query
     *
     * @throws Exception If the passed-in table does not exist, an exception with HTTP code 500 is thrown
     * 
     * @return array<string> The array of column names of the table
     */
    public function get_column_names($table) {
        $result = $this->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME = ?", 'ss', [DB_NAME, $table]);
        if(empty($result)) throw self::error("Table does not exist: " . json_encode($table));

        $result = array_map(function($name) {
            return $name['COLUMN_NAME'];
        }, $result);
        return $result;
    }

    /**
     * Prepares an executes the statement, throwing an exception
     * if it failed to do either.
     *
     * **NOTE**: This is not intended for use as a standalone function;
     * IT DOES NOT CLOSE THE STATEMENT AFTER EXECUTING. Only use this
     * function if you're doing advanced prepared statements
     *
     * @param string $query The statement to execute
     * @param string $types The data types of the parameters(i = int, d = float, s = string, b = blob)
     * @param array $params The parameters to bind
     *
     * @throws Exception If the statement failed to prepare/execute, an exception with HTTP code 500 is thrown
     *
     * @return mysqli_stmt The executed statement
     */
    private function exec_statement($query, $types, $params) {
        $statement = $this->conn->prepare($query); 
        if(!$statement) throw self::error('Failed to prepare statement: ' . $query);
        
        if($params) $statement->bind_param($types, ...$params);
        if(!$statement->execute()) throw self::error('Failed to execute statement: ' . $query);

        return $statement;
    }

    /**
     * Checks if a value exists in the column of a table
     *
     * @param string $table The name of the table
     * @param string $column The name of the column
     * @param string $value The value to search for
     *
     * @throws Exception See `query` for the exceptions thrown
     *
     * @return boolean whether the value exists
     */
    protected function search_column($table, $column, $value) {
        $result = $this->query("SELECT COUNT(*) as count FROM $table WHERE $column = ?", 's', [$value]);
        $result = $result[0];
        return $result['count'] > 0;
    }

    /**
     * Gets all distinct values in a column
     *
     * @param string $table The table to select from 
     * @param string $column The column name
     *
     * @throws Exception See `query` for the exceptions thrown
     *
     * @return array An array with all distinct column values
     */
    public function get_column_distinct($table, $col, $limit = 0) {
        $query = "SELECT DISTINCT $col FROM $table ";
        $params = [];
        $types = '';

        if($limit != 0) {
            $query .= "LIMIT ?";
            $params[] = $limit;
            $types .= 'i';
        }

        return array_map(function($row) use($col) {
            return $row[$col];
        }, $this->query($query, $types, $params));
    }

    /**
     * Helper function for throwing exceptions with an
     * HTTP error code to accompany it
     *
     * @param string $msg The message of the error
     */
    protected static function error($msg) {
        return new Exception($msg, 500); 
    }
}

?>
