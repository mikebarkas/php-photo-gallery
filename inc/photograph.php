<?php
require_once(LIB_PATH.DS.'database.php');

class Photograph {

  protected static $table_name = 'photographs';
  protected static $db_fields = array('id', 'filename', 'type', 'caption');
  public $id;
  public $filename;
  public $type;
  public $size;
  public $caption;

  private $temp_path;
  protected $upload_dir = 'images';
  
  public $errors = array();
  public $upload_errors = array(
    UPLOAD_ERR_OK => "No errors.",
    UPLOAD_ERR_INI_SIZE => "Larger than upload_max_filesize.",
    UPLOAD_ERR_FORM_SIZE => "larger than spcified in form.",
    UPLOAD_ERR_PARTIAL => "Partial upload.",
    UPLOAD_ERR_NO_FILE => "No file.",
    UPLOAD_ERR_NO_TMP_DIR => "No temp directory.",
    UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
    UPLOAD_ERR_EXTENSION => "Upload stopped by extension.",
  );

  // Argument: $_FILE['upload_file']
  public function attach_file($file) {

    // Error check on form params.
    if (!$file || empty($file) || !is_array($file)) {
      $this->errors[] = 'No file was uploaded.';
      return false;
    } elseif ($file['error'] != 0) {
      $this->errors[] = $this->upload_errors[$file['error']];
      return false;
    } else {
      // Set object attributes.
      $this->temp_path = $file['tmp_name'];
      $this->filename = basename($file['name']);
      $this->type = $file['type'];
      $this->size = $file['size'];
      return true;
    }
  }

  public function save() {
    // Existing id.
    if (isset($this->id)) {
      $this->update();
    } else {
      // Check for pre existing errors.
      if (!empty($this->errors)) {
        return false;
      }
      // Check caption length.
      if (strlen($this->caption) > 255) {
        $this->errors[] = "The caption can not be longer than 255 characters.";
        return false;
      }

      // Need filename and temp location.
      if (empty($this->filename) || empty($this->temp_path)) {
        $this->errors[] = "File location was not available.";
        return false;
      }

      $target_path = "../images/" . $this->filename;

      // Check if file exists.
      if (file_exists($target_path)) {
        $this->errors[] = "The file {$this->filename} already exists.";
        return false;
      }

      // Move file.
      if (move_uploaded_file($this->temp_path, $target_path)) {
        if ($this->create()) {
          unset($this->temp_path);
          return true;
        }
      } else {
        // File was not moved.
        $this->errors[] = "The file upload failed.";
        return false;
      }
    }
  }

  public function destroy() {
    // Remove DB entry.
    if ($this->delete()) {
      // Then delete file.
      $target_path = SITE_ROOT.DS.'public'.DS.$this->image_path();
      return unlink($target_path) ? true : false;
    } else {
      // Delete failed.
      return false;
    }
  }

  public function image_path() {
    return $this->upload_dir.DS.$this->filename;
  }

  public function size_as_text() {
    if ($this->size < 1024) {
      return "{$this->size} bytes";
    } elseif ($this->size < 1048576) {
      $size_kb = round($this->size/1024);
      return "{$size_kb} KB";
    } else {
      $size_mb = round($this->size/1048576, 1);
      return "{$size_mb} MB";
    }
  }

  // Find all.
  public static function find_all () {
    return self::find_by_sql("SELECT * FROM " . self::$table_name);
  }

  // Find one.
  public static function find_by_id ($id=0) {
    global $db;
    $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id=" . $db->escape_value($id) . " LIMIT 1");
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
    $object_vars = $this->attributes();
    return array_key_exists($attribute, $object_vars);
  }

  protected function attributes() {
    $attributes = array();
    foreach (self::$db_fields as $field) {
      if (property_exists($this, $field)) {
        $attributes[$field] = $this->$field;
      }
    }
    return $attributes;
  }

  protected function sanitized_attributes() {
    global $db;
    $clean_attributes = array();
    foreach ($this->attributes() as $key => $value) {
      $clean_attributes[$key] = $db->escape_value($value);
    }
    return $clean_attributes;
  }

  public function create() {
    global $db;
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . self::$table_name . " (";
    $sql .= join(", ", array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    if ($db->query($sql)) {
      $this->id = $db->insert_id();
      return true;
    } else {
      return false;
    }
  }

  public function update() {
    global $db;
    $attributes = $this->sanitized_attributes();
    $attribute_pairs = array();
    foreach ($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }
    $sql = "UPDATE " . self::$table_name . " SET ";
    $sql .= join(", ", $attribute_pairs);
    $sql .= " WHERE id=" . $db->escape_value($this->id);
    $db->query($sql);
    return ($db->affected_rows()==1 ) ? true : false;
  }

  public function delete() {
    global $db;
    $sql = "DELETE FROM " . self::$table_name . " ";
    $sql .= "WHERE id=" . $db->escape_value($this->id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows()==1 ) ? true : false;
  } 

} // end class

?>