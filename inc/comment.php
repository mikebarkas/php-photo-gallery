<?phprequire_once(LIB_PATH.DS.'database.php');class Comment {  protected static $table_name = 'comments';  protected static $db_fields = array('id', 'photograph_id', 'created', 'author', 'body');  public $id;  public $photograph_id;  public $created;  public $author;  public $body;  public static function make($photo_id, $author="Anonymous", $body="") {    if (!empty($photo_id) && !empty($author) && !empty($body)) {      $comment = new Comment();      $comment->photograph_id = (int)$photo_id;      $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());      $comment->author = $author;      $comment->body = $body;      return $comment;    } else {      return false;    }  }  public  static function find_comments_on($photo_id=0) {    global $db;    $sql = "SELECT * from " . self::$table_name;    $sql .=" WHERE photograph_id =" . $db->escape_value($photo_id);    $sql .= " ORDER BY created ASC";    return self::find_by_sql($sql);  }  // Find one.  public static function find_by_id ($id=0) {    global $db;    $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name ." WHERE id={$id} LIMIT 1");    return !empty($result_array) ? array_shift($result_array) : false;  }  // Find something by sql.  public static function find_by_sql ($sql="") {    global $db;    $result_set = $db->query($sql);    // Create array of objects.    $object_array = array();    while ($row = $db->fetch_array($result_set)) {      $object_array[] = self::instantiate($row);    }    return $object_array;  }  private static function instantiate ($record) {    $object = new self;    foreach ($record as $attribute=>$value) {      if ($object->has_attribute($attribute)) {        $object->$attribute = $value;      }    }    return $object;  }  private function has_attribute ($attribute) {    $object_vars = $this->attributes();    return array_key_exists($attribute, $object_vars);  }  protected function attributes() {    $attributes = array();    foreach (self::$db_fields as $field) {      if (property_exists($this, $field)) {        $attributes[$field] = $this->$field;      }    }    return $attributes;  }  protected function sanitized_attributes() {    global $db;    $clean_attributes = array();    foreach ($this->attributes() as $key => $value) {      $clean_attributes[$key] = $db->escape_value($value);    }    return $clean_attributes;  }  public function save() {    return isset($this->id) ? $this->update() : $this->create();  }  public function create() {    global $db;    $attributes = $this->sanitized_attributes();    $sql = "INSERT INTO " . self::$table_name . " (";    $sql .= join(", ", array_keys($attributes));    $sql .= ") VALUES ('";    $sql .= join("', '", array_values($attributes));    $sql .= "')";    if ($db->query($sql)) {      $this->id = $db->insert_id();      return true;    } else {      return false;    }  }  public function update() {    global $db;    $attributes = $this->sanitized_attributes();    $attribute_pairs = array();    foreach ($attributes as $key => $value) {      $attribute_pairs[] = "{$key}='{$value}'";    }    $sql = "UPDATE " . self::$table_name . " SET ";    $sql .= join(", ", $attribute_pairs);    $sql .= " WHERE id=" . $db->escape_value($this->id);    $db->query($sql);    return ($db->affected_rows()==1 ) ? true : false;  }  public function delete() {    global $db;    $sql = "DELETE FROM " . self::$table_name . " ";    $sql .= "WHERE id=" . $db->escape_value($this->id);    $sql .= " LIMIT 1";    $db->query($sql);    return ($db->affected_rows()==1 ) ? true : false;  }}