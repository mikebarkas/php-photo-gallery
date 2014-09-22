<?php
require_once('database.php');


class User {

  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;

  // Find all.
  public static function find_all () {
    return self::find_by_sql("SELECT * FROM users");
  }

  // Find one.
  public static function find_by_id ($id=0) {
    global $db;
    $result_array = self::find_by_sql("SELECT * FROM users WHERE id={$id} LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  // Find something by sql.
  public static function find_by_sql ($sql="") {
    global $db;
    $result_set = $db->query($sql);
    // Create array of objects.
    $object_array = array();
    while ($row = $db->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }

  // Authenticate user log in.
  public static function authenticate($username = '', $password = '') {
    global $db;
    $username = $db->escape_value($username);
    $password = $db->escape_value($password);

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "AND password = '{$password}' ";
    $sql .= "LIMIT 1";

    $result_array = self::find_by_sql($sql);
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  // Create full name;
  public function full_name () {
    if (isset($this->first_name) && isset($this->last_name)) {
      return $this->first_name . ' ' . $this->last_name;
    } else {
      return '';
    }
  }

  private static function instantiate ($record) {
    $object = new self;

    foreach ($record as $attribute=>$value) {
      if ($object->has_attribute($attribute)) {
        $object->$attribute = $value;
      }
    }
    return $object;
  }

  private function has_attribute ($attribute) {
    $object_vars = get_object_vars($this);
    return array_key_exists($attribute, $object_vars);
  }

  public function save() {
    return isset($this->id) ? $this->update() : $this->create();
  }

  public function create() {
    global $db;
    $sql = "INSERT INTO users (";
    $sql .= "username, password, first_name, last_name";
    $sql .= ") VALUES ('";
    $sql .= $db->escape_value($this->username) . "', '";
    $sql .= $db->escape_value($this->password) . "', '";
    $sql .= $db->escape_value($this->first_name) . "', '";
    $sql .= $db->escape_value($this->last_name) . "')";
    if ($db->query($sql)) {
      $this->id = $db->insert_id();
      return true;
    } else {
      return false;
    }
  }

  public function update() {
    global $db;
    $sql = "UPDATE users SET ";
    $sql .= "username='" . $db->escape_value($this->username) . "', ";
    $sql .= "password='" . $db->escape_value($this->password) . "', ";
    $sql .= "first_name='" . $db->escape_value($this->first_name) . "', ";
    $sql .= "last_name='" . $db->escape_value($this->last_name) . "' ";
    $sql .= "WHERE id=" . $db->escape_value($this->id);
    $db->query($sql);
    return ($db->affected_rows()==1 ) ? true : false;
  }

  public function delete() {
    global $db;
    $sql = "DELETE FROM users ";
    $sql .= "WHERE id=" . $db->escape_value($this->id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows()==1 ) ? true : false;
  }
}


?>