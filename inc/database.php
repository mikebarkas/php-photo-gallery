<?php
require_once('config.php');

class MySQLDatabase {

  private $connection;

  function __construct () {
    $this->open_connection();
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
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists('mysql_real_escape_string');

    if ($new_enough_php) {
      if ($magic_quotes_active) {
        $value = stripslashes($value);
      }
      $value = mysql_real_escape_string($value);
    } else {
      if (!$magic_quotes_active) {
        $value = addslashes($value);
      }
    }

    return $value;
  }
}


$database = new MySQLDatabase();
$db =& $database;
?>
