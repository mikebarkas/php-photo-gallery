<?php
require_once('config.php');

class MySQLDatabase {

  private $connection;
  private $magic_quotes_active;
  private $real_escape_string_exists;
  public $last_query;

  function __construct () {
    $this->open_connection();
    $this->magic_quotes_active = get_magic_quotes_gpc();
    $this->real_escape_string_exists = function_exists('mysql_real_escape_string');    
  }

  // Open connection.
  public function open_connection () {
    $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
  
    // Select database.
    if (!$this->connection) {
      die('Database connection failed: ' . mysql_error());
    } else {
      $db_select = mysql_select_db(DB_NAME, $this->connection);
      if (!$db_select) {
        die('Database selection failed: ' . mysql_error());
      }
    }
  }

  // Close connection.
  public function close_connection () {
    if (isset($this->connection)) {
      mysql_close($this->connection);
      unset($this->connection);
    }
  }

  // SQL Query.
  public function query ($sql) {
    $this->last_query = $sql; 
    $result = mysql_query($sql, $this->connection);
    $this->confirm_query($result);
    return $result;
  }

  // Confirm query.
  private function confirm_query ($result) {
    if (!$result) {
      die('Databse query failed: ' . mysql_error());
    }
  }

  // Escape input.
  public function escape_value ($value) {
    if ($this->real_escape_string_exists) {
      if ($this->magic_quotes_active) {
        $value = stripslashes($value);
      }
      $value = mysql_real_escape_string($value);
    } else {
      if (!$this->magic_quotes_active) {
        $value = addslashes($value);
      }
    }

    return $value;
  }

  // Database methods.
  public function fetch_array ($result_set) {
    return mysql_fetch_array($result_set);
  }

  public function num_rows ($result_set) {
    return mysql_num_rows($result);
  }

  public function insert_id ($result_set) {
    return mysql_insert_id($this->connection);
  }

  public function affected_rows ($result_set) {
    return mysql_affected_rows($this->connection);
  }
}


$database = new MySQLDatabase();
$db =& $database;
?>
