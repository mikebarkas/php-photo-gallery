<?php
require_once('database.php');

class Photograph {

  protected static $table_name = 'photographs';
  protected static $db_fields = array('id', 'filename', 'type', 'caption');
  public $id;
  public $filename;
  public $type;
  public $size;
  public $caption;


}

?>